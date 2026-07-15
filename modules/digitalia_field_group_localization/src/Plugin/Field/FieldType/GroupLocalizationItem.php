<?php

declare(strict_types=1);

namespace Drupal\digitalia_field_group_localization\Plugin\Field\FieldType;

use Drupal\Component\Utility\Random;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Defines the 'digitalia_field_group_localization' field type.
 *
 * @FieldType(
 *   id = "digitalia_field_group_localization",
 *   label = @Translation("Group localization"),
 *   description = @Translation("Some description."),
 *   default_widget = "digitalia_field_group_localization",
 *   default_formatter = "digitalia_field_group_localization_default",
 * )
 */
final class GroupLocalizationItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public function isEmpty(): bool {
    return $this->localization_type === NULL && $this->place === NULL && $this->identifier_scheme === NULL && $this->identifier === NULL && $this->localization_note === NULL;
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition): array {

    $properties['localization_type'] = DataDefinition::create('string')
      ->setLabel(t('Localization type'));
    $properties['place'] = DataDefinition::create('string')
      ->setLabel(t('Place'));
    $properties['identifier_scheme'] = DataDefinition::create('string')
      ->setLabel(t('Identifier scheme'));
    $properties['identifier'] = DataDefinition::create('string')
      ->setLabel(t('Identifier'));
    $properties['localization_note'] = DataDefinition::create('string')
      ->setLabel(t('Localization note'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function getConstraints(): array {
    $constraints = parent::getConstraints();

    $options['localization_type']['AllowedValues'] = array_keys(GroupLocalizationItem::allowedLocalizationTypeValues());

    $options['identifier_scheme']['AllowedValues'] = array_keys(GroupLocalizationItem::allowedIdentifierSchemeValues());

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
      'localization_type' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'place' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'identifier_scheme' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'identifier' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'localization_note' => [
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

    $values['localization_type'] = array_rand(self::allowedLocalizationTypeValues());

    $values['place'] = $random->word(mt_rand(1, 255));

    $values['identifier_scheme'] = array_rand(self::allowedIdentifierSchemeValues());

    $values['identifier'] = $random->word(mt_rand(1, 255));

    $values['localization_note'] = $random->paragraphs(5);

    return $values;
  }

  /**
   * Returns allowed values for 'localization_type' sub-field.
   */
  public static function allowedLocalizationTypeValues(): array {
    // @todo Update allowed values.
    return [
      'alpha' => t('Alpha'),
      'beta' => t('Beta'),
      'gamma' => t('Gamma'),
    ];
  }

  /**
   * Returns allowed values for 'identifier_scheme' sub-field.
   */
  public static function allowedIdentifierSchemeValues(): array {
    // @todo Update allowed values.
    return [
      'alpha' => t('Alpha'),
      'beta' => t('Beta'),
      'gamma' => t('Gamma'),
    ];
  }

}
