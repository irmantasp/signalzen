<?php

namespace Drupal\signalzen;

use Drupal\Core\Config\ConfigFactoryInterface;
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
   * Creates SignalZenWidgetManager objects.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The configuration factory.
   */
  public function __construct(
    ConfigFactoryInterface $config_factory
  ) {
    $this->widgetConfig = $config_factory->get(SignalZenSettingsForm::CONFIG_NAME);
  }

  public function getPublicToken(): ?string {
    return $this->widgetConfig->get('public_token_field');
  }

  public function getColors(): ?array {
    return array_filter(
      $this->widgetConfig->get(),
      function ($color_name) {
        return strpos($color_name, 'color_') === 0;
      },
      ARRAY_FILTER_USE_KEY
    );
  }

  public function getWidgetConfiguration(): array {
    return [
      'token' => $this->getPublicToken(),
      'colors' => $this->getWidgetColors(),
    ];
  }

  private function getWidgetColors() {
    $widget_colors = [];
    foreach ($this->getColors() as $config_color => $color_value) {
      $widget_colors[$this->transformColorName($config_color)] = $color_value;
    }

    return $widget_colors;
  }

  private function transformColorName(string $color_name) {
    $color_name = str_replace('color_', '', $color_name);
    return str_replace('_', '', lcfirst(ucwords($color_name, '_')));
  }

}
