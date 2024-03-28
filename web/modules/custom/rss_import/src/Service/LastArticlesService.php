<?php
namespace Drupal\rss_import\Service;


class LastArticlesService {
  public function getNumberOfArticles($limit = 10) {
    $lastArticles = [];
    $query = \Drupal::entityQuery('node');
    $query->condition('type', 'drupal_planet_rss');
    $query->condition('status', 1);
    $query->sort('created', 'ASC');
    $query->range(0, $limit)
          ->accessCheck();
    $nids = $query->execute();

    if (!empty($nids)) {
      $lastArticles = \Drupal\node\Entity\Node::loadMultiple($nids);
    }

    return $lastArticles;
  }
}
