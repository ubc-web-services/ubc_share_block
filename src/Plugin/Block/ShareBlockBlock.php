<?php

namespace Drupal\ubc_share_block\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a share block block.
 *
 * @Block(
 *   id = "ubc_share_block_share_block",
 *   admin_label = @Translation("Share Block"),
 *   category = @Translation("Custom")
 * )
 */
class ShareBlockBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'label_display' => FALSE,
      'domain' => NULL,
      'copy' => NULL,
      'facebook' => NULL,
      'linkedin' => NULL,
      'twitter' => NULL,
      'email' => NULL,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['domain'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Site domain'),
      '#description' => $this->t('Add the site\'s domain. This should be in the for format of mysite.ubc.ca (no https://).'),
      '#default_value' => $this->configuration['domain'],
      '#placeholder' => $this->t('yoursitename.ubc.ca'),
      '#size' => 60,
      '#maxlength' => 128,
      '#required' => true,
    ];
    $form['copy'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Add a Copy Link button'),
      '#description' => $this->t('Add a button to copy a link to the page'),
      '#default_value' => $this->configuration['copy'],
    ];
    $form['facebook'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Add a Facebook button'),
      '#description' => $this->t('Share with Facebook'),
      '#default_value' => $this->configuration['facebook'],
    ];
    $form['linkedin'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Add a LinkedIn button'),
      '#description' => $this->t('Share with LinkedIn'),
      '#default_value' => $this->configuration['linkedin'],
    ];
    $form['twitter'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Add a Twitter button'),
      '#description' => $this->t('Share with Twitter'),
      '#default_value' => $this->configuration['twitter'],
    ];
    $form['email'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Add an Email button'),
      '#description' => $this->t('Share via Email'),
      '#default_value' => $this->configuration['email'],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['domain'] = $form_state->getValue('domain');
    $this->configuration['copy'] = $form_state->getValue('copy');
    $this->configuration['facebook'] = $form_state->getValue('facebook');
    $this->configuration['linkedin'] = $form_state->getValue('linkedin');
    $this->configuration['twitter'] = $form_state->getValue('twitter');
    $this->configuration['email'] = $form_state->getValue('email');
  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account) {
    // @DCG Evaluate the access condition here.
    $condition = TRUE;
    return AccessResult::allowedIf($condition);
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();
    $build = [
      '#theme' => 'share_block',
      '#domain' => $config['domain'],
      '#copy' => $config['copy'],
      '#facebook' => $config['facebook'],
      '#linkedin' => $config['linkedin'],
      '#twitter' => $config['twitter'],
      '#email' => $config['email'],
    ];
    return $build;
  }

}
