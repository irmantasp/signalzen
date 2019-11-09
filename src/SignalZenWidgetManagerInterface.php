<?php

namespace Drupal\signalzen;

/**
 * Provides an interface for SignalZen live chat widget manager.
 */
interface SignalZenWidgetManagerInterface {

  /**
   * Get 'public_token_field' config value.
   *
   * @return string|null
   *   Public token.
   */
  public function getPublicToken(): ?string;

  /**
   * Get config values with 'color_' prefix.
   *
   * @return array|null
   *   List of colors.
   */
  public function getColors(): ?array;

  /**
   * Initial chat widget configuration.
   *
   * @return array
   *   Configuration array containing token and colors.
   */
  public function getWidgetConfiguration(): array;

  /**
   * Can user use widget?
   *
   * @return bool
   *   Returns TRUE if user has permission 'use signalzen live chat'.
   */
  public function canUserUseWidget(): bool;

  /**
   * Should widget be displayed on current route?
   *
   * @return bool
   *   Returns TRUE if current route is not admin route.
   *   Returns FALSE if current route is admin route but no 'admin_routes'
   *   config is provided, or value is FALSE;
   */
  public function displayOnRoute(): bool;

}
