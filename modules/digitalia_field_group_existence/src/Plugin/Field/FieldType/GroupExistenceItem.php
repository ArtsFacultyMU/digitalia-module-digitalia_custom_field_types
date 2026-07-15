<?php

declare(strict_types=1);

namespace Drupal\digitalia_field_group_existence\Plugin\Field\FieldType;

use Drupal\Component\Utility\Random;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Defines the 'digitalia_field_group_existence' field type.
 *
 * @FieldType(
 *   id = "digitalia_field_group_existence",
 *   label = @Translation("Group existence"),
 *   description = @Translation("Some description."),
 *   default_widget = "digitalia_field_group_existence",
 *   default_formatter = "digitalia_field_group_existence_default",
 * )
 */
final class GroupExistenceItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public function isEmpty(): bool {
    return $this->existence_type === NULL && $this->from === NULL && $this->to === NULL;
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition): array {

    $properties['existence_type'] = DataDefinition::create('string')
      ->setLabel(t('Type of existence'));
    $properties['from'] = DataDefinition::create('integer')
      ->setLabel(t('From'));
    $properties['to'] = DataDefinition::create('integer')
      ->setLabel(t('To'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function getConstraints(): array {
    $constraints = parent::getConstraints();

    $options['existence_type']['AllowedValues'] = array_keys(GroupExistenceItem::allowedTypeOfExistenceValues());

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
      'existence_type' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'from' => [
        'type' => 'int',
        'size' => 'normal',
      ],
      'to' => [
        'type' => 'int',
        'size' => 'normal',
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

    $values['existence_type'] = array_rand(self::allowedTypeOfExistenceValues());

    $values['from'] = mt_rand(-1000, 1000);

    $values['to'] = mt_rand(-1000, 1000);

    return $values;
  }

  /**
   * Returns allowed values for 'existence_type' sub-field.
   */
  public static function allowedTypeOfExistenceValues(): array {
    // @todo Update allowed values.
    return [
      'alpha' => t('Alpha'),
      'beta' => t('Beta'),
      'gamma' => t('Gamma'),
    ];
  }

}
