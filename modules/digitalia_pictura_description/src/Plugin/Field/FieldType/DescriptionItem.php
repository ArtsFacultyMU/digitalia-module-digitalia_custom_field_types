<?php

declare(strict_types=1);

namespace Drupal\digitalia_pictura_description\Plugin\Field\FieldType;

use Drupal\Component\Utility\Random;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\digitalia_custom_field_types\Plugin\Field\FieldType\AllowedLanguageValuesTrait;

/**
 * Defines the 'digitalia_pictura_description' field type.
 *
 * @FieldType(
 *   id = "digitalia_pictura_description",
 *   label = @Translation("Description"),
 *   description = @Translation("Some description."),
 *   default_widget = "digitalia_pictura_description",
 *   default_formatter = "digitalia_pictura_description_default",
 * )
 */
final class DescriptionItem extends FieldItemBase {

  use AllowedLanguageValuesTrait;

  /**
   * {@inheritdoc}
   */
  public function isEmpty(): bool {
    return $this->description === NULL && $this->language === NULL && $this->source === NULL && $this->source_id === NULL && $this->note === NULL && $this->system_note === NULL;
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition): array {

    $properties['description'] = DataDefinition::create('string')
      ->setLabel(t('Description'));
    $properties['language'] = DataDefinition::create('string')
      ->setLabel(t('Language'));
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

    $options['description']['NotBlank'] = [];

    $options['language']['AllowedValues'] = array_keys(DescriptionItem::allowedLanguageValues());

    $options['language']['NotBlank'] = [];

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
      'description' => [
        'type' => 'text',
        'size' => 'big',
      ],
      'language' => [
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

    $values['description'] = $random->paragraphs(5);

    $values['language'] = array_rand(self::allowedLanguageValues());

    $values['source'] = $random->paragraphs(5);

    $values['source_id'] = $random->word(mt_rand(1, 255));

    $values['note'] = $random->paragraphs(5);

    $values['system_note'] = $random->paragraphs(5);

    return $values;
  }

}
