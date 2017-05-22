<?php

namespace Drupal\promotions\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class PromotionsForm
 *
 * @package Drupal\Promotions\Form
 * @author  Jack Barton <jackbarton4@hotmail.co.uk>
 */
class PromotionsForm extends FormBase {

  public function getFormId() {
    return 'promotions_settings';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['promotions_block_iframe'] = [
      '#type' => 'textfield',
      '#title' => $this->t('iFrame'),
      '#description' => $this->t('Enter an iFrame to embed a Video.'),
      '#default_value' => isset($config['iframe']) ? $config['iframe'] : '',
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_typr' => 'primary'
    ];

    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    $query_string = '?rel=0&amp;showinfo=0';

    $url = $form_state->getValue('promotions_block_iframe');

    if ($url === NULL) {
      $form_state->setErrorByName('promotions_block_iframe',
        $this->t('Please enter an embed code to display a video.')
      );
    }

    if (!strpos($url, 'embed')) {
      $embed_url = str_replace('watch?v=', 'embed/', $url);

      return $embed_url . $query_string;
    }

    return $url . $query_string;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    // TODO: Implement submitForm() method.
  }
}