<?php

declare(strict_types=1);

namespace Drupal\digitalia_field_group_names\Plugin\Field\FieldType;

use Drupal\Component\Utility\Random;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Defines the 'digitalia_field_group_names' field type.
 *
 * @FieldType(
 *   id = "digitalia_field_group_names",
 *   label = @Translation("Group names"),
 *   description = @Translation("Some description."),
 *   default_widget = "digitalia_field_group_names",
 *   default_formatter = "digitalia_field_group_names_default",
 * )
 */
final class GroupNamesItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public function isEmpty(): bool {
    return $this->name_category === NULL && $this->name === NULL && $this->specification === NULL && $this->name_source === NULL && $this->name_note === NULL;
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition): array {

    $properties['name_category'] = DataDefinition::create('string')
      ->setLabel(t('Name category'));
    $properties['name'] = DataDefinition::create('string')
      ->setLabel(t('Name'));
    $properties['specification'] = DataDefinition::create('string')
      ->setLabel(t('Specification'));
    $properties['name_source'] = DataDefinition::create('string')
      ->setLabel(t('Name source'));
    $properties['name_note'] = DataDefinition::create('string')
      ->setLabel(t('Name note'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function getConstraints(): array {
    $constraints = parent::getConstraints();

    $options['name_category']['AllowedValues'] = array_keys(GroupNamesItem::allowedNameCategoryValues());

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
      'name_category' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'name' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'specification' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'name_source' => [
        'type' => 'text',
        'size' => 'big',
      ],
      'name_note' => [
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

    $values['name_category'] = array_rand(self::allowedNameCategoryValues());

    $values['name'] = $random->word(mt_rand(1, 255));

    $values['specification'] = $random->word(mt_rand(1, 255));

    $values['name_source'] = $random->paragraphs(5);

    $values['name_note'] = $random->paragraphs(5);

    return $values;
  }

  /**
   * Returns allowed values for 'name_category' sub-field.
   */
  public static function allowedNameCategoryValues(): array {
    // @todo Update allowed values.
    return [
      'preferred' => t('preferovaný název'),
      'variant' => t('variantní název'),
    ];
  }

}
