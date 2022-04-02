<?php

namespace Drupal\signalzen;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Routing\AdminContext;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\signalzen\Form\SignalZenSettingsForm;
use Drupal\file\Entity\File;

/**
 * Provides helper functions for SignalZen live chat widget.
 */
class SignalZenWidgetManager implements SignalZenWidgetManagerInterface {

  /**
   * SignalZen live chat widget config.
   *
   * @var \Drupal\Core\Config\ImmutableConfig
   */
  protected $widgetConfig;

  /**
   * Current user.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $account;

  /**
   * Current route.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $route;

  /**
   * Admin context.
   *
   * @var \Drupal\Core\Routing\AdminContext
   */
  protected $adminContext;

  /**
   * Creates SignalZenWidgetManager objects.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The configuration factory.
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   Current user.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   Current route.
   * @param \Drupal\Core\Routing\AdminContext $admin_context
   *   Admin context.
   */
  public function __construct(
    ConfigFactoryInterface $config_factory,
    AccountProxyInterface $current_user,
    RouteMatchInterface $route_match,
    AdminContext $admin_context
  ) {
    $this->widgetConfig = $config_factory->get(SignalZenSettingsForm::CONFIG_NAME);
    $this->account = $current_user;
    $this->route = $route_match;
    $this->adminContext = $admin_context;
  }

  /**
   * {@inheritdoc}
   */
  public function getPublicToken(): ?string {
    return $this->widgetConfig->get('public_token_field');
  }

  /**
   * {@inheritdoc}
   */
  public function getWidgetConfiguration(): array {
    return [
      'token' => $this->getPublicToken()
    ];
  }

}
