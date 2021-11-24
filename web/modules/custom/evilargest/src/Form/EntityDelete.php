<?php

namespace Drupal\evilargest\Form;

use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\Entity\ContentEntityConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\Validator\Constraints\Url;

/**
 * Deleting review.
 */
class EntityDelete extends ContentEntityConfirmFormBase {

  /**
   * Returning confirmation question.
   */
  public function getQuestion(): TranslatableMarkup {
    return $this->t('Are you sure u wanna delete this?');
  }

  /**
   * Redirecting to the page with a review after canceling deleting.
   */
  public function getCancelUrl(): Url {
    return new Url('evilargest_review');
  }

  /**
   * Confirming text.
   */
  public function getConfirmText(): TranslatableMarkup {
    return $this->t('Cancel');
  }

  /**
   * Deleting review.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function deleteForm(array $form, FormStateInterface $form_state): void {
    $entity = $this->entity;
    $entity->delete();
    $form_state->setRedirect('evilargest_review');
  }

}
