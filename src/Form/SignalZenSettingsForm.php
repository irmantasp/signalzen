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
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $config = $this->config(static::CONFIG_NAME);

    $form['public_token_field'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Public Token'),
      '#default_value' => $config->get('public_token_field'),
      '#required' => TRUE,
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
