/**
 * @file
 * SignalZen live chat widget behaviors.
 */

(function ($, Drupal, drupalSettings) {

  'use strict';

  let initialized;

  Drupal.behaviors.signalZen = {
    attach: function attach(context, settings) {
      this.init(context, settings);
    },
    init: function init(context, settings) {
      if (!initialized) {
        if (settings.signalZen.token !== 'undefined') {
          window.paceOptions = {
            ajax: {
              trackWebSockets: false,
              ignoreURLs: [/signalzen/]
            }
          };

          let widgetConfig = {
            appId: settings.signalZen.token,
          };
          new SignalZen(widgetConfig).load();
        }

        initialized = true;
      }
    }
  };
})(jQuery, Drupal, drupalSettings);
