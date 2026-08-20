<?php

declare(strict_types=1);

namespace Drupal\digitalia_pictura_relation\Plugin\Field\FieldType;

use Drupal\Component\Utility\Random;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Defines the 'digitalia_pictura_relation' field type.
 *
 * @FieldType(
 *   id = "digitalia_pictura_relation",
 *   label = @Translation("Relation"),
 *   description = @Translation("Digitalia VRA Relation field type."),
 *   default_widget = "digitalia_pictura_relation",
 *   default_formatter = "digitalia_pictura_relation_default",
 * )
 */
final class RelationItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public function isEmpty(): bool {
    return $this->name === NULL && $this->type === NULL && $this->link === NULL && $this->source === NULL && $this->source_id === NULL && $this->note === NULL && $this->system_note === NULL;
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition): array {

    $properties['name'] = DataDefinition::create('string')
      ->setLabel(t('Name of related resource'));
    $properties['type'] = DataDefinition::create('string')
      ->setLabel(t('Relation type'));
    $properties['link'] = DataDefinition::create('uri')
      ->setLabel(t('ID of related resource')); // use source_id
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

    $options['type']['AllowedValues'] = array_keys(RelationItem::allowedTypeValues());

    //$options['name']['NotBlank'] = [];
    //$options['type']['NotBlank'] = [];

    $constraint_manager = \Drupal::typedDataManager()->getValidationConstraintManager();
    $constraints[] = $constraint_manager->create('ComplexData', $options);
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
      'type' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'link' => [
        'type' => 'varchar',
        'length' => 2048,
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

    $values['type'] = array_rand(self::allowedTypeValues());

    $tlds = ['com', 'net', 'gov', 'org', 'edu', 'biz', 'info'];
    $domain_length = mt_rand(7, 15);
    $protocol = mt_rand(0, 1) ? 'https' : 'http';
    $www = mt_rand(0, 1) ? 'www' : '';
    $domain = $random->word($domain_length);
    $tld = $tlds[mt_rand(0, (count($tlds) - 1))];
    $values['link'] = "$protocol://$www.$domain.$tld";

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
      'cartoonFor' => t('Cartoon for'),
      'cartoonIs' => t('Has cartoon'),
      'componentOf' => t('Component of'),
      'componentIs' => t('Has component'),
      'copyAfter' => t('Copy after'),
      'copyIs' => t('Has copy'),
      'counterProofFor' => t('Counterproof for'),
      'counterProofIs' => t('Has counterproof'),
      'depicts' => t('Depicts'),
      'depictedIn' => t('Depicted in'),
      'derivedFrom' => t('Derived from'),
      'sourceFor' => t('Source for'),
      'designedFor' => t('Designed for'),
      'contextIs' => t('Has context'),
      'exhibitedAt' => t('Exhibited at'),
      'venueFor' => t('Venue for'),
      'facsimileOf' => t('Facsimile of'),
      'facsimileIs' => t('Has facsimile'),
      'formerlyPartOf' => t('Formerly part of'),
      'formerlyLargerContextFor' => t('Formerly larger context for'),
      'imageOf' => t('Image of'),
      'imageIs' => t('Has image'),
      'mateOf' => t('Mate of'),
      'modelFor' => t('Model for'),
      'modelIs' => t('Has model'),
      'partOf' => t('Part of'),
      'largerContextFor' => t('Larger context for'),
      'partnerInSetWith' => t('Partner in set with'),
      'pendantOf' => t('Pendant of'),
      'planFor' => t('Plan for'),
      'planIs' => t('Has plan'),
      'preparatoryFor' => t('Preparatory for'),
      'basedOn' => t('Based on'),
      'printingPlateFor' => t('Printing plate for'),
      'printingPlateIs' => t('Has printing plate'),
      'prototypeFor' => t('Prototype for'),
      'prototypeIs' => t('Has prototype'),
      'relatedTo' => t('Related to'),
      'reliefFor' => t('Relief for'),
      'impressionIs' => t('Has impression', [], ['context' => 'digitalia_pictura_relation']),
      'replicaOf' => t('Replica of'),
      'replicaIs' => t('Has replica'),
      'studyFor' => t('Study for'),
      'studyIs' => t('Has study'),
      'versionOf' => t('Version of'),
      'versionIs' => t('Has version'),
      'textref' => t('Has text reference'), /* field textref, not resource in VRA */
    ];
  }

}
