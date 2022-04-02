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
   * Initial chat widget configuration.
   *
   * @return array
   *   Configuration array containing all widget configuration.
   */
  public function getWidgetConfiguration(): array;

}
