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
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $config = $this->config(static::CONFIG_NAME);
    $form['public_token_field'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Public Token'),
      '#default_value' => $config->get('public_token_field'),
      '#required' => TRUE,
      '#description' => $this->t('To enable SignalZen chat widget on your website, you just need to enter your <strong>Public Token</strong> which you can find in the <strong>Integration page</strong> while logged in to your account at <a href=":homepage" target="_blank">signalzen.com</a>.', [':homepage' => 'https://signalzen.com/']),
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
