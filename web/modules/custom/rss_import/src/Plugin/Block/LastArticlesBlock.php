<?php
namespace Drupal\rss_import\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\node\Entity\Node;

/**
 *
 * @Block(
 *    id = "derniers_articles_block",
 *    admin_label = @Translation("Block de derniers articles")
 *  )
 */
class LastArticlesBlock extends BlockBase {

  /**
   * @return array
   */
  public function build()
  {
    $config = \Drupal::config('block.block.derniers_articles_block');
    //$config->get('settings.my_text_field');
    return [
      '#theme' => 'block__rss_import',
      '#data' => [
        'name' => 'salah',
        'lastname' => 'mkharbech',
      ],
    ];
  }


  /**
   * @param $limit
   * @return \Drupal\Core\Entity\EntityBase[]|\Drupal\Core\Entity\EntityInterface[]|Node[]
   */
  private function getData($limit = 10){
    $query = \Drupal::entityQuery('node');
    $query->condition('status', 1);
    $query->condition('type', 'drupal_planet_rss');
    $query->range(0, $limit)
          ->accessCheck();
    $nids = $query->execute();
    return Node::loadMultiple($nids);
  }
}
