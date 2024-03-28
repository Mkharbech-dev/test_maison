<?php
namespace Drupal\rss_import\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;

/**
 *
 * @Block(
 *    id = "derniers_articles_block",
 *    admin_label = @Translation("Block de derniers articles")
 *  )
 */
class LastArticlesBlock extends BlockBase {
  public function build()
  {
    // TODO: Implement build() method.
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $form['articles_number'] = [
      '#type' => 'number',
      '#title' => $this->t('Nombre d\'Articles'),
      '#description' => $this->t('Nombre d\'articles à afficher dans le Block '),
      '#default_value' => isset($config['articles_number']) ? $config['articles_number'] : 1,
      '#required' => TRUE,
    ];

    $form['cache_invalidation'] = [
      '#type' => 'number',
      '#title' => $this->t('Invalidation de cache'),
      '#description' => $this->t('Durée de cache avant invalidation'),
      '#default_value' => isset($config['cache_invalidation']) ? $config['cache_invalidation'] : 0,
      '#required' => TRUE,
    ];

    return $form;
  }




}
