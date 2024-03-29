<?php
namespace Drupal\rss_import\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
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
  public function build() {
    $config = $this->getConfiguration();
    $build_data = \Drupal::service("rss_import_build_data_service");
    $item_count = $config['articles_number'] ?? 5;

    return [
      '#theme' => 'rss_import_block',
      '#nodes' => $build_data->getNumberOfArticles($item_count),
    ];
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

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->setConfiguration(
      [
        'articles_number' => $form_state->getValue('articles_number'),
        'cache_invalidation' => $form_state->getValue('cache_invalidation'),
      ]
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheContexts() {
    return Cache::mergeContexts(parent::getCacheContexts(), ['ip']);
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    $config = $this->getConfiguration();
    return $config['cache_invalidation'] ?? -1;
  }
}
