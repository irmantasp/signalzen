<?php

namespace Drupal\signalzen;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Routing\AdminContext;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\signalzen\Form\SignalZenSettingsForm;

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
  public function getColors(): ?array {
    return array_filter(
      $this->widgetConfig->get(),
      function ($color_name) {
        return strpos($color_name, 'color_') === 0;
      },
      ARRAY_FILTER_USE_KEY
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getWidgetConfiguration(): array {
    return [
      'token' => $this->getPublicToken(),
      'colors' => $this->getWidgetColors(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function canUserUseWidget(): bool {
    return $this->account->hasPermission('use signalzen live chat');
  }

  /**
   * {@inheritdoc}
   */
  public function displayOnRoute(): bool {
    if ($this->isAdminRoute()) {
      return $this->getDisplayOnAdminRoutes();
    }

    return TRUE;
  }

  /**
   * Get colors for widget.
   *
   * @return array
   *   Contains list of colors, with transformed color names and color values.
   */
  private function getWidgetColors() {
    $widget_colors = [];
    foreach ($this->getColors() as $config_color => $color_value) {
      $widget_colors[$this->transformColorName($config_color)] = $color_value;
    }

    return $widget_colors;
  }

  /**
   * Transform config color name to widget color name.
   *
   * @param string $color_name
   *   Color name as machine_name.
   *
   * @return mixed
   *   Color name in camelCase format without 'color_' prefix.
   */
  private function transformColorName(string $color_name) {
    $color_name = str_replace('color_', '', $color_name);
    return str_replace('_', '', lcfirst(ucwords($color_name, '_')));
  }

  /**
   * Get config 'admin_routes' value.
   *
   * @return bool
   *   Config value.
   */
  private function getDisplayOnAdminRoutes(): bool {
    return $this->widgetConfig->get('admin_routes');
  }

  /**
   * Is current route admin route?
   *
   * @return bool
   *   Return TRUE if current route is admin route. FALSE if not.
   */
  private function isAdminRoute(): bool {
    return $this->adminContext->isAdminRoute($this->route->getRouteObject());
  }

}
