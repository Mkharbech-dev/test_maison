<?php
namespace Drupal\rss_import\Service;


use Drupal\node\Entity\Node;

/**
 *
 */
class LastArticlesService {

  /**
   * @param $limit
   * @return array|\Drupal\Core\Entity\EntityBase[]|\Drupal\Core\Entity\EntityInterface[]|\Drupal\node\Entity\Node[]
   */
  public function getNumberOfArticles($limit = 5) {
    $query = \Drupal::entityQuery('node');
    $query->condition('type', 'drupal_planet_rss');
    $query->condition('status', 1);
    $query->sort('created', 'ASC');
    $query->range(0, $limit)
          ->accessCheck();
    $nids = $query->execute();

    if (!empty($nids)) {
      return Node::loadMultiple($nids);
    }

    return [];
  }
}
