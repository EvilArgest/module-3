<?php

namespace Drupal\evilargest\Entity;

use Drupal\Core\Entity\Annotation\ContentEntityType;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the EntityEntity.
 *
 * @ContentEntityType(
 *   id = "evilargest_review",
 *   label = @Translation("Review"),
 *   base_table = "evilargest_review",
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid",
 *   },
 *   handlers = {
 *    "views_data" = "Drupal\views\EntityViewsData",
 *    "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "form" = {
 *       "default" = "Drupal\evilargest\Form\EntityForm",
 *       "delete" = "Drupal\evilargest\Form\EntityDelete",
 *     },
 *   },
 *   links = {
 *     "canonical" = "/evilargest/evilargest_review/{evilargest_review}",
 *     "edit-form" = "/evilargest/evilargest_review/{evilargest_review}/edit",
 *     "delete-form" = "/evilargest/evilargest_review/{evilargest_review}/delete",
 *     "collection" = "/evilargest/evilargest_review/list"
 *   },
 * )
 */
class EntityEntity extends ContentEntityBase {

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type): array {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the review'))
      ->setReadOnly(TRUE);

    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the review'))
      ->setReadOnly(TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('Username'))
      ->setDefaultValue(NULL)
      ->setRequired(TRUE)
      ->setSetting('max_length', 100)
      ->setPropertyConstraints('value', [
        'Length' => [
          'min' => 2,
          'max' => 100,
          'minMessage' => 'Your name is less than 2 symbols',
          'maxMessage' => 'Your name is longer than 100 symbols',
        ],
      ])
      ->setDisplayOptions('form', [
        'type' => 'string',
      ])
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['email'] = BaseFieldDefinition::create('email')
      ->setLabel(t('Email'))
      ->setDescription(t('User email'))
      ->setDefaultValue(NULL)
      ->setRequired(TRUE)
      ->setSetting('max_length', 60)
      ->setPropertyConstraints('value', [
        'Regex' => [
          'pattern' => '/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/',
          'message' => t('Please, enter a valid email'),
        ],
      ])
      ->setDisplayOptions('form', [
        'type' => 'email',
      ])
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'email',
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['phone'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Phone Number'))
      ->setDescription(t('User phone number'))
      ->setDefaultValue(NULL)
      ->setRequired(TRUE)
      ->setSetting('max_length', 15)
      ->setPropertyConstraints('value', [
        'Regex' => [
          'pattern' => '/(\+?( |-|\.)?\d{1,2}( |-|\.)?)?(\(?\d{3}\)?|\d{3})( |-|\.)?(\d{3}( |-|\.)?\d{4})/',
          'message' => 'Please, enter a valid phone number',
        ],
      ])
      ->setDisplayOptions('form', [
        'type' => 'string',
      ])
      ->setDisplayOptions('view', [
        'type' => 'string',
        'label' => 'hidden',
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['textmessage'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Message'))
      ->setDescription(t('User message'))
      ->setDefaultValue(NULL)
      ->setRequired(TRUE)
      ->setSetting('max_length', 1000)
      ->setPropertyConstraints('value', [
        'Length' => [
          'max' => 1000,
          'maxMessage' => 'Your message is longer than 1000 characters long',
        ],
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_long',
      ])
      ->setDisplayOptions('view', [
        'type' => 'text_default',
        'label' => 'hidden',
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['avatar'] = BaseFieldDefinition::create('image')
      ->setLabel(t('Avatar'))
      ->setDescription(t('User avatar'))
      ->setDefaultValue(NULL)
      ->setSettings([
        'file_extension' => 'png jpg jpeg',
        'file_location' => 'images/avatars/',
        'max_filesize' => 2097152,
        'alt_field' => FALSE,
      ])
      ->setDisplayOptions('form', [
        'type' => 'image',
      ])
      ->setDisplayOptions('view', [
        'type' => 'image',
        'label' => 'hidden',
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['image'] = BaseFieldDefinition::create('image')
      ->setLabel(t('Image'))
      ->setDescription(t('Review image'))
      ->setDefaultValue(NULL)
      ->setSettings([
        'file_extension' => 'png jpg jpeg',
        'file_location' => 'images/review_images',
        'max_filesize' => 5242880,
        'alt_field' => FALSE,
      ])
      ->setDisplayOptions('form', [
        'type' => 'image',
      ])
      ->setDisplayOptions('view', [
        'type' => 'image',
        'label' => 'hidden',
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['date'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Date'))
      ->setDescription(t('Date when the revue was created'))
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'datetime_custom',
        'settings' => [
          'data_format' => 'm-d-Y H:i:s',
        ],
      ])
      ->setDisplayConfigurable('view', TRUE);

    return $fields;
  }

}
