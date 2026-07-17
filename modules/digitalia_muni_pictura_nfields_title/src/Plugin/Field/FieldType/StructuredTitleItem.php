<?php

declare(strict_types=1);

namespace Drupal\digitalia_muni_pictura_nfields_title\Plugin\Field\FieldType;

use Drupal\Component\Utility\Random;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\digitalia_custom_field_types\Plugin\Field\FieldType\AllowedLanguageValuesTrait;

/**
 * Defines the 'digitalia_muni_pictura_nfields_title' field type.
 *
 * @FieldType(
 *   id = "digitalia_muni_pictura_nfields_title",
 *   label = @Translation("Structured title"),
 *   description = @Translation("Some description."),
 *   default_widget = "digitalia_muni_pictura_nfields_title",
 *   default_formatter = "digitalia_muni_pictura_nfields_title_default",
 * )
 */
final class StructuredTitleItem extends FieldItemBase {

  use AllowedLanguageValuesTrait;

  /**
   * {@inheritdoc}
   */
  public static function defaultFieldSettings(): array {
    $settings = ['bar' => 'example'];
    return $settings + parent::defaultFieldSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function fieldSettingsForm(array $form, FormStateInterface $form_state): array {
    $settings = $this->getSettings();

    $element['bar'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Bar'),
      '#default_value' => $settings['bar'],
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty(): bool {
    return $this->title === NULL && $this->title_type === NULL && $this->language === NULL && $this->id === NULL && $this->id_type === NULL && $this->source === NULL && $this->source_id === NULL && $this->note === NULL && $this->system_note === NULL;
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition): array {

    $properties['title'] = DataDefinition::create('string')
      ->setLabel(t('Title'));
    $properties['title_type'] = DataDefinition::create('string')
      ->setLabel(t('Title type'));
    $properties['language'] = DataDefinition::create('string')
      ->setLabel(t('Language'));
    $properties['id'] = DataDefinition::create('string')
      ->setLabel(t('Title ID'));
    $properties['id_type'] = DataDefinition::create('string')
      ->setLabel(t('Title ID type'));
    $properties['source'] = DataDefinition::create('string')
      ->setLabel(t('Source'));
    $properties['source_id'] = DataDefinition::create('string')
      ->setLabel(t('source_id'));
    $properties['note'] = DataDefinition::create('string')
      ->setLabel(t('Note'));
    $properties['system_note'] = DataDefinition::create('string')
      ->setLabel(t('System note'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function getConstraints(): array {
    $constraints = parent::getConstraints();

    $options['title']['NotBlank'] = [];

    $options['title_type']['AllowedValues'] = array_keys(self::allowedTitleTypeValues());

    $options['title_type']['NotBlank'] = [];

    $options['language']['AllowedValues'] = array_keys(self::allowedLanguageValues());

    $options['language']['NotBlank'] = [];

    $options['id_type']['AllowedValues'] = array_keys(self::allowedTitleIDTypeValues());

    $constraint_manager = \Drupal::typedDataManager()->getValidationConstraintManager();
    $constraints[] = $constraint_manager->create('ComplexData', $options);
    // @todo Add more constraints here.
    return $constraints;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition): array {

    $columns = [
      'title' => [
        'type' => 'text',
        'size' => 'big',
      ],
      'title_type' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'language' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'id' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'id_type' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'source' => [
        'type' => 'text',
        'size' => 'big',
      ],
      'source_id' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'note' => [
        'type' => 'text',
        'size' => 'big',
      ],
      'system_note' => [
        'type' => 'text',
        'size' => 'big',
      ],
    ];

    $schema = [
      'columns' => $columns,
      // @DCG Add indexes here if necessary.
    ];

    return $schema;
  }

  /**
   * {@inheritdoc}
   */
  public static function generateSampleValue(FieldDefinitionInterface $field_definition): array {

    $random = new Random();

    $values['title'] = $random->paragraphs(5);

    $values['title_type'] = array_rand(self::allowedTitleTypeValues());

    $values['language'] = array_rand(self::allowedLanguageValues());

    $values['id'] = $random->word(mt_rand(1, 255));

    $values['id_type'] = array_rand(self::allowedTitleIDTypeValues());

    $values['source'] = $random->paragraphs(5);

    $values['source_id'] = $random->word(mt_rand(1, 255));

    $values['note'] = $random->paragraphs(5);

    $values['system_note'] = $random->paragraphs(5);

    return $values;
  }

  /**
   * Returns allowed values for 'title_type' sub-field.
   */
  public static function allowedTitleTypeValues(): array {
    return [
      'brandName' => t('brand name'),
      'cited' => t('cited'),
      'creator' => t('creator'),
      'descriptive' => t('descriptive'),
      'former' => t('former'),
      'generalView' => t('general view'),
      'inscribed' => t('inscribed'),
      'owner' => t('owner'),
      'partialView' => t('partial view'),
      'popular' => t('popular'),
      'repository' => t('repository'),
      'translated' => t('translated'),
      'other' => t('other'),
    ];
  }

  /**
   * Returns allowed values for 'id_type' sub-field.
   */
  public static function allowedTitleIDTypeValues(): array {
    return [
      'ISBN' => t('ISBN'),
      'ISSN' => t('ISSN'),
      'URI' => t('URI'),
      'DOI' => t('DOI'),
      'other' => t('other'),
    ];
  }

}
