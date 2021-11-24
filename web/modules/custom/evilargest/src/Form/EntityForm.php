<?php

namespace Drupal\evilargest\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\MessageCommand;
use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form for entity type.
 */
class EntityForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form = parent::buildForm($form, $form_state);

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
   * Ajax name field validation.
   */
  public function dynamicNameValidation(array $form, FormStateInterface $form_state): AjaxResponse {
    $response = new AjaxResponse();
    $name = $form_state->getValue('name')[0]['value'];
    $namestrl = strlen($name);
    if (($namestrl < 2 || $namestrl > 100)) {
      $response->AddCommand(
        new MessageCommand(
          $this->t('The name must be in range of 2 to 100 symbols.'),
          '.field--name-name',
          [
            'type' => 'error',
          ]
        )
      );
    }
    return $response;
  }

  /**
   * Ajax email field validation.
   */
  public function dynamicEmailValidation(array $form, FormStateInterface $form_state): AjaxResponse {
    $response = new AjaxResponse();
    $phone = $form_state->getValue('email')[0]['value'];
    $pattern = '/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/';
    if (!preg_match($pattern, $phone)) {
      $response->addCommand(
        new MessageCommand(
          $this->t('Please, check your email.'),
          '.field--name-email',
          [
            'type' => 'error',
          ],
        ),
      );
    }
    return $response;
  }

  /**
   * Ajax phone field validation.
   */
  public function dynamicPhoneValidation(array $form, FormStateInterface $form_state): AjaxResponse {
    $response = new AjaxResponse();
    $phone = $form_state->getValue('phone')[0]['value'];
    $pattern = '/(\+?( |-|\.)?\d{1,2}( |-|\.)?)?(\(?\d{3}\)?|\d{3})( |-|\.)?(\d{3}( |-|\.)?\d{4})/';
    if (!preg_match($pattern, $phone)) {
      $response->addCommand(
        new MessageCommand(
          $this->t('Please, check your phone number.'),
          '.field--name-phone',
          [
            'type' => 'error',
          ],
        ),
      );
    }
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
}
