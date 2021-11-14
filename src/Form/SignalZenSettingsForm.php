<?php

namespace Drupal\signalzen\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * SignalZen live chat widget settings form.
 */
class SignalZenSettingsForm extends ConfigFormBase {

  /**
   * Config name.
   */
  public const CONFIG_NAME = 'signalzen.settings';

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames(): array {
    return [
      static::CONFIG_NAME,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'signalzen_settings';
  }

  /**
   * Gets the color configuration names that will be editable.
   *
   * @return array
   *   An array of color configuration field names that are editable.
   */
  protected function getEditableColorConfigNames(): array {
    return [
      'color_primary' => $this->t('Primary color'),
      'color_secondary' => $this->t('Secondary color'),
      'color_footer' => $this->t('Footer color'),
      'color_error' => $this->t('Error color'),
      'color_popup' => $this->t('Popup color'),
      'color_popup_close' => $this->t('Popup close color'),
      'color_popup_close_symbol' => $this->t('Popup close symbol color'),
      'color_popup_form_input_border' => $this->t('Popup form input color'),
      'color_badge' => $this->t('Badge color'),
      'color_footer_emojis_popup' => $this->t('Footer emojis background color'),
      'color_footer_options' => $this->t('Footer options color'),
      'color_operator_messages' => $this->t('Operator messages background color'),
      'color_form_input' => $this->t('Form input color'),
      'color_form_input_border' => $this->t('Form input border color'),
      'color_form_button' => $this->t('Form button background color'),
      'color_form_placeholder' => $this->t('Form input placeholder color'),
      'color_text_primary' => $this->t('Text primary color'),
      'color_text_error' => $this->t('Error text color'),
      'color_text_time' => $this->t('Time text color'),
      'color_text_time_separator' => $this->t('Time separator text color'),
      'color_text_user_message' => $this->t('User message text color'),
      'color_text_form_text' => $this->t('Form text input color'),
      'color_text_form_input' => $this->t('Form text color'),
      'color_text_form_title' => $this->t('Form text title color'),
      'color_text_form_button' => $this->t('Form button text color'),
      'color_online_indicator' => $this->t('Online indicator color')
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $config = $this->config(static::CONFIG_NAME);
    $form['#attributes'] = array('enctype' => 'multipart/form-data');
    $form['public_token_field'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Public Token'),
      '#default_value' => $config->get('public_token_field'),
      '#required' => TRUE,
      '#description' => $this->t('To enable SignalZen chat widget on your website, you just need to enter your <strong>Public Token</strong> which you can find in the <strong>Integration page</strong> while logged in to your account at <a href=":homepage" target="_blank">signalzen.com</a>.', [':homepage' => 'https://signalzen.com/']),
    ];

    $form['colors'] = [
      '#type' => 'details',
      '#title' => $this->t('Colors config'),
    ];

    foreach ($this->getEditableColorConfigNames() as $color_config => $color_config_name) {
      $form['colors'][$color_config] = [
        '#type' => 'color',
        '#title' => $color_config_name,
        '#default_value' => $config->get($color_config),
        '#required' => TRUE,
      ];
    }

    $form['layout'] = [
      '#type' => 'details',
      '#title' => $this->t('Positioning config'),
    ];
    $form['layout']['horizontal_position'] = [
      '#type' => 'select',
      '#title' => 'Horizontal position',
      '#default_value' => $config->get('horizontal_position'),
      '#options' => [ '' => 'Default', 'left' => 'Left', 'right' => 'Right'],
      '#empty_option' => 'Default',
    ];

    $form['layout']['vertical_position'] = [
      '#type' => 'select',
      '#title' => 'Vertical position',
      '#default_value' => $config->get('vertical_position'),
      '#options' => [ '' => 'Default', 'bottom' => 'Bottom', 'top' => 'Top'],
      '#empty_option' => 'Default',
    ];

    $form['layout']['horizontal_offset'] = [
      '#type' => 'number',
      '#title' => 'Horizontal offset (px)',
      '#default_value' => $config->get('horizontal_offset'),
    ];

    $form['layout']['vertical_offset'] = [
      '#type' => 'number',
      '#title' => 'Vertical offset (px)',
      '#default_value' => $config->get('vertical_offset'),
    ];

    $form['chat_icon'] = [
      '#type' => 'details',
      '#title' => $this->t('Chat Icon config'),
    ];

    $form['chat_icon']['chat_icon_enabled'] = [
      '#type' => 'checkbox',
      '#title' => 'Custom Chat Icon enabled',
      '#default_value' => $config->get('chat_icon_enabled'),
    ];

    $form['chat_icon']['chat_icon_width'] = [
      '#type' => 'number',
      '#title' => 'Custom Chat Icon width (px)',
      '#default_value' => $config->get('chat_icon_width'),
    ];

    $form['chat_icon']['chat_icon_height'] = [
      '#type' => 'number',
      '#title' => 'Custom Chat Icon height (px)',
      '#default_value' => $config->get('chat_icon_height'),
    ];

    $form['chat_icon']['chat_icon_closed'] = [
      '#type' => 'managed_file',
      '#title' => 'Custom Chat Icon image (when chat is closed)',
      '#default_value' => $config->get('chat_icon_closed'),
    ];

    $form['chat_icon']['chat_icon_open'] = [
      '#type' => 'managed_file',
      '#title' => 'Custom Chat Icon image (when chat is open)',
      '#default_value' => $config->get('chat_icon_open'),
    ];

    $form['chat_icon']['chat_icon_loading'] = [
      '#type' => 'managed_file',
      '#title' => 'Custom Chat Icon image (when chat is loading)',
      '#default_value' => $config->get('chat_icon_loading'),
    ];

    $form['display'] = [
      '#type' => 'details',
      '#title' => $this->t('Display settings'),
    ];

    $form['display']['admin_routes'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Display on administration pages?'),
      '#default_value' => $config->get('admin_routes'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $config = $this->config(static::CONFIG_NAME);
    $form_state->cleanValues();
    $values = $form_state->getValues();

    foreach ($values as $config_name => $value) {
      $config->set($config_name, $value);
    }

    $config->save();
    parent::submitForm($form, $form_state);
  }

}
