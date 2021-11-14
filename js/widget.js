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
        if (settings.signalZen.token !== 'undefined' && settings.signalZen.colors !== 'undefined') {
          window.paceOptions = {
            ajax: {
              trackWebSockets: false,
              ignoreURLs: [/signalzen/]
            }
          };

          let widgetConfig = {
            appId: settings.signalZen.token,
            colors: settings.signalZen.colors,
          };
          if (!Array.isArray(settings.signalZen.chatIcon)) {
            widgetConfig.chatIcon = settings.signalZen.chatIcon
          }
          if (!Array.isArray(settings.signalZen.layout)) {
            widgetConfig.layout = settings.signalZen.layout
          }
          new SignalZen(widgetConfig).load();
        }

        initialized = true;
      }
    }
  };
})(jQuery, Drupal, drupalSettings);
