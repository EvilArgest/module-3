<?php

namespace Drupal\evilargest\Controller;

use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Entity\EntityFormBuilder;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Displaying entity form.
 */
class MyEntityController extends ControllerBase {

  /**
   * Drupal services.
   */
  protected $entityManager;

  /**
   * Drupal services.
   */
  protected $formBuilder;

  /**
   * Providing dependency injection.
   */
  public static function create(ContainerInterface $container): MyEntityController {
    $instance = parent::create($container);
    $instance->entityManager = $container->get('entity_type.manager');
    $instance->formBuilder = $container->get('entity.form_builder');
    return $instance;
  }

  /**
   * Outputting module data.
   */
  public function build(): array {
    $entity = $this->entityManager
      ->getStorage('evilargest_review')
      ->create();
    $form = $this->formBuilder->getForm($entity, 'default');

    $storage = $this->entityManager->getStorage('evilargest_review');
    $query = $storage->getQuery()
      ->sort('date', "DESC")
      ->pager(5);
    $pager = [
      '#type' => 'pager',
    ];

    $reviews = $query->execute();

    $review = $storage->loadMultiple($reviews);
    $get_view = $this->entityManager->getViewBuilder('evilargest_review');
    $render = $get_view->viewMultiple($review);
    return [
      '#theme' => 'evilargest-page',
      '#form' => $form,
      '#pager' => $pager,
      '#reviews' => $render,
    ];
  }

}
