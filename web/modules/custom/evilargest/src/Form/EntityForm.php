<?php

namespace Drupal\evilargest\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\MessageCommand;
use Drupal\Core\Ajax\RedirectCommand;
use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Form for entity type.
 */
class EntityForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form = parent::buildForm($form, $form_state);
    $form['#prefix'] = '<div id="wrapper_wrapper"';
    $form['#suffix'] = '</div>';
    $form['actions']['submit']['#ajax'] = [
      'callback' => '::setMessage',
      'wrapper' => 'wrapper_wrapper',
    ];
    $form['name']['widget'][0]['value']['#ajax'] = [
      'callback' => '::dynamicNameValidation',
      'disable-refocus' => TRUE,
      'event' => 'finishedinput',
      'progress' => [
        'type' => 'none',
      ],
    ];

    $form['email']['widget'][0]['value']['#ajax'] = [
      'callback' => '::dynamicEmailValidation',
      'disable-refocus' => TRUE,
      'event' => 'finishedinput',
      'progress' => [
        'type' => 'none',
      ],
    ];

    $form['phone']['widget'][0]['value']['#ajax'] = [
      'callback' => '::dynamicPhoneValidation',
      'disable-refocus' => TRUE,
      'event' => 'finishedinput',
      'progress' => [
        'type' => 'none',
      ],
    ];
    return $form;
  }

  /**
   * Submit Ajax.
   */
  public function setMessage(array &$form, FormStateInterface $form_state) {
    if ($form_state->hasAnyErrors()) {
      return $form;
    }
    $response = new AjaxResponse();
    $response->addCommand(new RedirectCommand('/evilargest/evilargest_review'));
    return $response;
  }

  /**
   * {@inheritdoc}
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->getEntity();
    $entity->save();
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
    $form_state->setRedirect('evilargest_review');
  }

}
