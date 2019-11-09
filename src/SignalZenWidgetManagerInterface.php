<?php

namespace Drupal\signalzen;

/**
 * Provides an interface for SignalZen live chat widget manager.
 */
interface SignalZenWidgetManagerInterface {

  public function getPublicToken(): ?string;

  public function getColors(): ?array;

  public function getWidgetConfiguration(): array;

}
