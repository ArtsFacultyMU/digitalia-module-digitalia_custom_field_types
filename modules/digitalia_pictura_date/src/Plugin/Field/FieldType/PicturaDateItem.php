<?php

declare(strict_types=1);

namespace Drupal\digitalia_pictura_date\Plugin\Field\FieldType;

use Drupal\Component\Utility\Random;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\digitalia_custom_field_types\Plugin\Field\FieldType\AllowedLanguageValuesTrait;

/**
 * Defines the 'digitalia_pictura_date' field type.
 *
 * @FieldType(
 *   id = "digitalia_pictura_date",
 *   label = @Translation("Pictura Date"),
 *   description = @Translation("Some description."),
 *   default_widget = "digitalia_pictura_date",
 *   default_formatter = "digitalia_pictura_date_default",
 * )
 */
final class PicturaDateItem extends FieldItemBase {

  use AllowedLanguageValuesTrait;

  /**
   * {@inheritdoc}
   */
  public function isEmpty(): bool {
    return $this->date === NULL && $this->language === NULL && $this->earliest_year === NULL && $this->latest_year === NULL && $this->date_type === NULL && $this->translations === NULL && $this->source_id === NULL && $this->source === NULL && $this->note === NULL && $this->system_note === NULL;
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition): array {

    $properties['date'] = DataDefinition::create('string')
      ->setLabel(t('Date'));
    $properties['language'] = DataDefinition::create('string')
      ->setLabel(t('Language'));
    $properties['earliest_year'] = DataDefinition::create('integer')
      ->setLabel(t('Earliest year'));
    $properties['latest_year'] = DataDefinition::create('integer')
      ->setLabel(t('Latest year'));
    $properties['date_type'] = DataDefinition::create('string')
      ->setLabel(t('Date type'));
    $properties['translations'] = DataDefinition::create('string')
      ->setLabel(t('Translations'));
    $properties['source_id'] = DataDefinition::create('string')
      ->setLabel(t('Source ID'));
    $properties['source'] = DataDefinition::create('string')
      ->setLabel(t('Source'));
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

    $options['date']['NotBlank'] = [];

    $options['language']['AllowedValues'] = array_keys(self::allowedLanguageValues());

    $options['date_type']['AllowedValues'] = array_keys(PicturaDateItem::allowedDateTypeValues());

    $options['date_type']['NotBlank'] = [];

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
      'date' => [
        'type' => 'text',
        'size' => 'big',
      ],
      'language' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'earliest_year' => [
        'type' => 'int',
        'size' => 'normal',
      ],
      'latest_year' => [
        'type' => 'int',
        'size' => 'normal',
      ],
      'date_type' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'translations' => [
        'type' => 'text',
        'size' => 'big',
      ],
      'source_id' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'source' => [
        'type' => 'text',
        'size' => 'big',
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

    $values['date'] = $random->paragraphs(5);

    $values['language'] = array_rand(self::allowedLanguageValues());

    $values['earliest_year'] = mt_rand(-1000, 1000);

    $values['latest_year'] = mt_rand(-1000, 1000);

    $values['date_type'] = array_rand(self::allowedDateTypeValues());

    $values['translations'] = $random->paragraphs(5);

    $values['source_id'] = $random->word(mt_rand(1, 255));

    $values['source'] = $random->paragraphs(5);

    $values['note'] = $random->paragraphs(5);

    $values['system_note'] = $random->paragraphs(5);

    return $values;
  }

  /**
   * Returns allowed values for 'date_type' sub-field.
   */
  public static function allowedDateTypeValues(): array {
    return [
      'alteration' => t('Alteration'),
      'broadcast' => t('Broadcast'),
      'bulk' => t('Bulk'),
      'commission' => t('Commission'),
      'creation' => t('Creation'),
      'design' => t('Design'),
      'destruction' => t('Destruction'),
      'discovery' => t('Discovery'),
      'exhibition' => t('Exhibition'),
      'inclusive' => t('Inclusive'),
      'performance' => t('Performance'),
      'publication' => t('Publication'),
      'restoration' => t('Restoration'),
      'view' => t('View'),
      'other' => t('Other'),
    ];
  }

}
