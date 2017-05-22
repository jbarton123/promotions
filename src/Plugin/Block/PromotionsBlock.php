<?php

namespace Drupal\promotions\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;


/**
 * Provides a 'promotions' Block.
 *
 * @Block(
 * id = "promotions_block",
 * admin_label = @Translation("Promotions Block"),
 * )
 */
class PromotionsBlock extends BlockBase implements BlockPluginInterface {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $config = $this->getConfiguration();

    if (!empty($config['iframe'])) {
      $output = $this->prepareUrl($config['iframe']);
    } else {
      $output = $this->t('No Promotion has been set.');
    }

    return array(
      '#plain_text' => $output,
      '#theme' => 'promotion-block'
    );
  }

  /**
   * Prepares a non embed youtube URL to be embedded in an iFrame.
   *
   * @param string $url Url to prepare.
   *
   * @return string
   */
  private function prepareUrl($url) {
    $query_string = '?rel=0&amp;showinfo=0';

    if (!strpos($url, 'embed')) {
      $embed_url = str_replace('watch?v=', 'embed/', $url);

      return $embed_url . $query_string;
    }

    return $url . $query_string;
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {

    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $form['promotions_block_iframe'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('iFrame'),
      '#description' => $this->t('Enter an iFrame to embed a Video.'),
      '#default_value' => isset($config['iframe']) ? $config['iframe'] : '',
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->setConfigurationValue('iframe', $form_state->getValue('promotions_block_iframe'));
  }
}