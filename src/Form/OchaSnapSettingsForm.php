<?php

namespace Drupal\ocha_snap\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * OCHA Snap settings.
 */
class OchaSnapSettingsForm extends ConfigFormBase {

  /**
   * Config settings.
   *
   * @var string
   */
  const SETTINGS = 'ocha_snap.settings';

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ocha_snap_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      static::SETTINGS,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::SETTINGS);

    $form['url'] = [
      '#type' => 'textfield',
      '#title'         => $this->t('Url'),
      '#description'   => $this->t('Snap service endpoint (eg: http://www.test.com:8442/snap). If left empty, <em>http://localhost:8442/snap</em> will be used.'),
      '#default_value' => $config->get('url'),
    ];

    $form['site_user'] = [
      '#type' => 'textfield',
      '#title'         => $this->t('Site User'),
      '#description'   => $this->t('Snap service user name.'),
      '#default_value' => $config->get('site_user'),
    ];

    $form['site_pass'] = [
      '#type' => 'textfield',
      '#title'         => $this->t('Site password'),
      '#description'   => $this->t('Password associated with snap service user.'),
      '#default_value' => $config->get('site_pass'),
    ];

    $form['tokens'] = [
      '#type'   => 'item',
      '#title'  => $this->t('Tokens'),
      '#markup' => $this->t('You can use the token <em>[pagination]</em> in both the header and footer. It will be replaced with a translated version of the text <em>Page current of total</em> with the appropriate numbers inserted.'),
    ];

    $form['header'] = [
      '#type'          => 'textarea',
      '#title'         => $this->t('PDF Header'),
      '#description'   => $this->t('HTML content to use as the generated PDF header. You can <em>not</em> use remote references for images or stylesheets. Any javascript is ignored.'),
      '#default_value' => $config->get('header'),
    ];

    $form['footer'] = [
      '#type'          => 'textarea',
      '#title'         => $this->t('PDF Footer'),
      '#description'   => $this->t('HTML content to use as the generated PDF footer. You can <em>not</em> use remote references for images or stylesheets. Any javascript is ignored.'),
      '#default_value' => $config->get('footer'),
    ];

    $form['css'] = [
      '#type'          => 'textarea',
      '#title'         => $this->t('PDF CSS'),
      '#description'   => $this->t('Any custom CSS rules you need injected into the page before the PDF is generated.'),
      '#default_value' => $config->get('css'),
    ];

    $form['debug'] = [
      '#type'          => 'checkbox',
      '#title'         => $this->t('Debug'),
      '#description'   => $this->t('Collect and log debug information in the Snap Service backend.'),
      '#default_value' => $config->get('debug'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->configFactory->getEditable(static::SETTINGS)
      ->set('url', $form_state->getValue('url'))
      ->set('site_user', $form_state->getValue('site_user'))
      ->set('site_pass', $form_state->getValue('site_pass'))
      ->set('header', $form_state->getValue('header'))
      ->set('footer', $form_state->getValue('footer'))
      ->set('css', $form_state->getValue('css'))
      ->set('debug', $form_state->getValue('debug'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
