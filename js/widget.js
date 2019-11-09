/**
 * @file
 */

(function ($, Drupal, drupalSettings) {

  let initialized;

  Drupal.behaviors.signalZen = {
    attach: function attach(context, settings) {
      this.init(context,settings);
    },
    init: function init(context, settings) {
      if (!initialized) {
        if (settings.signalZen.token !== undefined && settings.signalZen.colors !== undefined) {
          window.paceOptions = {
            ajax: {
              trackWebSockets: false,
              ignoreURLs: [/signalzen/]
            }
          };

          let widgetConfig = {
            appId: settings.signalZen.token,
            colors: settings.signalZen.colors
          };

          new SignalZen(widgetConfig).load();
        }

        initialized = true;
      }
    }
  };
})(jQuery, Drupal, drupalSettings);
