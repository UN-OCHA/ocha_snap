<?php

/**
 * @file
 * Contains \Drupal\ocha_snap\Controller\OchaSnapController.
 */

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

    $form['tokens'] = array(
      '#type'   => 'item',
      '#title'  => $this->t('Tokens'),
      '#markup' => $this->t('You can use the token <em>[pagination]</em> in both the header and footer. It will be replaced with a translated version of the text <em>Page current of total</em> with the appropriate numbers inserted.'),
    );

    $form['header'] = array(
      '#type'          => 'textarea',
      '#title'         => $this->t('PDF Header'),
      '#description'   => $this->t('HTML content to use as the generated PDF header. You can <em>not</em> use remote references for images or stylesheets. Any javascript is ignored.'),
      '#default_value' => $config->get('header'),
    );

    $form['footer'] = array(
      '#type'          => 'textarea',
      '#title'         => $this->t('PDF Footer'),
      '#description'   => $this->t('HTML content to use as the generated PDF footer. You can <em>not</em> use remote references for images or stylesheets. Any javascript is ignored.'),
      '#default_value' => $config->get('footer'),
    );

    $form['css'] = array(
      '#type'          => 'textarea',
      '#title'         => $this->t('PDF CSS'),
      '#description'   => $this->t('Any custom CSS rules you need injected into the page before the PDF is generated.'),
      '#default_value' => $config->get('css'),
    );

    $form['debug'] = array(
      '#type'          => 'checkbox',
      '#title'         => $this->t('Debug'),
      '#description'   => $this->t('Collect and log debug information in the Snap Service backend.'),
      '#default_value' => $config->get('debug'),
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->configFactory->getEditable(static::SETTINGS)
      ->set('header', $form_state->getValue('header'))
      ->set('footer', $form_state->getValue('footer'))
      ->set('css', $form_state->getValue('css'))
      ->set('debug', $form_state->getValue('debug'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}
