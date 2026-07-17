<?php

declare(strict_types=1);

namespace Drupal\digitalia_pictura_inscription\Plugin\Field\FieldType;

use Drupal\Component\Utility\Random;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\digitalia_custom_field_types\Plugin\Field\FieldType\AllowedLanguageValuesTrait;

/**
 * Defines the 'digitalia_pictura_inscription' field type.
 *
 * @FieldType(
 *   id = "digitalia_pictura_inscription",
 *   label = @Translation("Inscription"),
 *   description = @Translation("VRA Inscription field type."),
 *   default_widget = "digitalia_pictura_inscription",
 *   default_formatter = "digitalia_pictura_inscription_default",
 * )
 */
final class InscriptionItem extends FieldItemBase {

  use AllowedLanguageValuesTrait;

  /**
   * {@inheritdoc}
   */
  public function isEmpty(): bool {
    return $this->text === NULL && $this->language === NULL && $this->en_translation === NULL && $this->cs_translation === NULL && $this->position === NULL && $this->author === NULL && $this->author_vocab === NULL && $this->author_id === NULL && $this->source === NULL && $this->source_id === NULL && $this->note === NULL && $this->system_note === NULL;
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition): array {

    $properties['text'] = DataDefinition::create('string')
      ->setLabel(t('Text'));
    $properties['language'] = DataDefinition::create('string')
      ->setLabel(t('Language'));
    $properties['en_translation'] = DataDefinition::create('string')
      ->setLabel(t('English translation'));
    $properties['cs_translation'] = DataDefinition::create('string')
      ->setLabel(t('Czech translation'));
    $properties['position'] = DataDefinition::create('string')
      ->setLabel(t('Position'));
    $properties['author'] = DataDefinition::create('string')
      ->setLabel(t('Author'));
    $properties['author_vocab'] = DataDefinition::create('string')
      ->setLabel(t('Author ID type'));
    $properties['author_id'] = DataDefinition::create('string')
      ->setLabel(t('Author ID'));
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

    $options['language']['AllowedValues'] = array_keys(self::allowedLanguageValues());

    $options['author_vocab']['AllowedValues'] = array_keys(self::allowedAuthorIDTypeValues());

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
      'text' => [
        'type' => 'text',
        'size' => 'big',
      ],
      'language' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'en_translation' => [
        'type' => 'text',
        'size' => 'big',
      ],
      'cs_translation' => [
        'type' => 'text',
        'size' => 'big',
      ],
      'position' => [
        'type' => 'text',
        'size' => 'big',
      ],
      'author' => [
        'type' => 'text',
        'size' => 'big',
      ],
      'author_vocab' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'author_id' => [
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

    $values['text'] = $random->paragraphs(5);

    $values['language'] = array_rand(self::allowedLanguageValues());

    $values['en_translation'] = $random->paragraphs(5);

    $values['cs_translation'] = $random->paragraphs(5);

    $values['position'] = $random->paragraphs(5);

    $values['author'] = $random->paragraphs(5);

    $values['author_vocab'] = array_rand(self::allowedAuthorIDTypeValues());

    $values['author_id'] = $random->word(mt_rand(1, 255));

    $values['source'] = $random->paragraphs(5);

    $values['source_id'] = $random->word(mt_rand(1, 255));

    $values['note'] = $random->paragraphs(5);

    $values['system_note'] = $random->paragraphs(5);

    return $values;
  }


  /**
   * Returns allowed values for 'author_vocab' sub-field.
   */
  public static function allowedAuthorIDTypeValues(): array {
    return [
      'ulan' => t('ULAN'),
      'wikidata' => t('WikiData'),
      'viaf' => t('VIAF'),
    ];
  }

}
