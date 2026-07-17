<?php

declare(strict_types=1);

namespace Drupal\digitalia_state_edition\Plugin\Field\FieldType;

use Drupal\Component\Utility\Random;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Defines the 'digitalia_state_edition' field type.
 *
 * @FieldType(
 *   id = "digitalia_state_edition",
 *   label = @Translation("State Edition"),
 *   description = @Translation("Digitalia VRA State Edition field type."),
 *   default_widget = "digitalia_state_edition",
 *   default_formatter = "digitalia_state_edition_default",
 * )
 */
final class StateEditionItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public function isEmpty(): bool {
    return $this->name === NULL && $this->description === NULL && $this->type === NULL && $this->num === NULL && $this->count === NULL && $this->source === NULL && $this->source_id === NULL && $this->note === NULL && $this->system_note === NULL;
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition): array {

    $properties['name'] = DataDefinition::create('string')
      ->setLabel(t('Name'));
    $properties['description'] = DataDefinition::create('string')
      ->setLabel(t('Description'));
    $properties['type'] = DataDefinition::create('string')
      ->setLabel(t('Type'));
    $properties['num'] = DataDefinition::create('integer')
      ->setLabel(t('Number'));
    $properties['count'] = DataDefinition::create('integer')
      ->setLabel(t('Count'));
    $properties['source'] = DataDefinition::create('string')
      ->setLabel(t('Source'));
    $properties['source_id'] = DataDefinition::create('string')
      ->setLabel(t('Source ID'));
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

    $options['type']['AllowedValues'] = array_keys(StateEditionItem::allowedTypeValues());

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
      'name' => [
        'type' => 'text',
        'size' => 'big',
      ],
      'description' => [
        'type' => 'text',
        'size' => 'big',
      ],
      'type' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'num' => [
        'type' => 'int',
        'size' => 'normal',
      ],
      'count' => [
        'type' => 'int',
        'size' => 'normal',
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

    $values['name'] = $random->paragraphs(5);

    $values['description'] = $random->paragraphs(5);

    $values['type'] = array_rand(self::allowedTypeValues());

    $values['num'] = mt_rand(-1000, 1000);

    $values['count'] = mt_rand(-1000, 1000);

    $values['source'] = $random->paragraphs(5);

    $values['source_id'] = $random->word(mt_rand(1, 255));

    $values['note'] = $random->paragraphs(5);

    $values['system_note'] = $random->paragraphs(5);

    return $values;
  }

  /**
   * Returns allowed values for 'type' sub-field.
   */
  public static function allowedTypeValues(): array {
    return [
      'signature' => t('Signature'),
      'mark' => t('Mark'),
      'caption' => t('Caption'),
      'date' => t('Date'),
      'text' => t('Text'),
      'translation' => t('Translation'),
      'other' => t('Other'),
    ];
  }

}
