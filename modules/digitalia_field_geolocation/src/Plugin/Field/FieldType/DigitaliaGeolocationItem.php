<?php

declare(strict_types=1);

namespace Drupal\digitalia_field_geolocation\Plugin\Field\FieldType;

use Drupal\Component\Utility\Random;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Defines the 'digitalia_field_geolocation' field type.
 *
 * @FieldType(
 *   id = "digitalia_field_geolocation",
 *   label = @Translation("Digitalia Geolocation"),
 *   description = @Translation("Some description."),
 *   default_widget = "digitalia_field_geolocation",
 *   default_formatter = "digitalia_field_geolocation_default",
 * )
 */
final class DigitaliaGeolocationItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultFieldSettings(): array {
    return [
      'allowed_type_values' => '',
    ] + parent::defaultFieldSettings();
  }
  
  /**
   * {@inheritdoc}
   */
  public function fieldSettingsForm(array $form, FormStateInterface $form_state): array {
    $settings = $this->getSettings();

    $element['allowed_type_values'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Allowed type values'),
      '#default_value' => $this->getSetting('allowed_type_values'),
      '#description' => $this->t('Enter one value per line.'),
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty(): bool {
    return $this->type === NULL && $this->place === NULL && $this->url === NULL && $this->country === NULL && $this->adm1 === NULL && $this->adm2 === NULL && $this->adm3 === NULL && $this->adm4 === NULL && $this->adm5 === NULL && $this->lat === NULL && $this->long === NULL && $this->note === NULL && $this->note_system === NULL;
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition): array {

    $properties['type'] = DataDefinition::create('string')
      ->setLabel(t('Type'));
    $properties['place'] = DataDefinition::create('string')
      ->setLabel(t('Place'));
    $properties['url'] = DataDefinition::create('uri')
      ->setLabel(t('URL'));
    $properties['country'] = DataDefinition::create('string')
      ->setLabel(t('Country'));
    $properties['adm1'] = DataDefinition::create('string')
      ->setLabel(t('adm1'));
    $properties['adm2'] = DataDefinition::create('string')
      ->setLabel(t('adm2'));
    $properties['adm3'] = DataDefinition::create('string')
      ->setLabel(t('adm3'));
    $properties['adm4'] = DataDefinition::create('string')
      ->setLabel(t('adm4'));
    $properties['adm5'] = DataDefinition::create('string')
      ->setLabel(t('adm5'));
    $properties['lat'] = DataDefinition::create('string')
      ->setLabel(t('Lat'));
    $properties['long'] = DataDefinition::create('string')
      ->setLabel(t('Long'));
    $properties['note'] = DataDefinition::create('string')
      ->setLabel(t('Note'));
    $properties['note_system'] = DataDefinition::create('string')
      ->setLabel(t('Note system'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function getConstraints(): array {
    $constraints = parent::getConstraints();

    $options['type']['AllowedValues'] = array_keys(DigitaliaGeolocationItem::allowedTypeValues());

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
      'type' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'place' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'url' => [
        'type' => 'varchar',
        'length' => 2048,
      ],
      'country' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'adm1' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'adm2' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'adm3' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'adm4' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'adm5' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'lat' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'long' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'note' => [
        'type' => 'text',
        'size' => 'big',
      ],
      'note_system' => [
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

    $values['type'] = array_rand(self::allowedTypeValues());

    $values['place'] = $random->word(mt_rand(1, 255));

    $tlds = ['com', 'net', 'gov', 'org', 'edu', 'biz', 'info'];
    $domain_length = mt_rand(7, 15);
    $protocol = mt_rand(0, 1) ? 'https' : 'http';
    $www = mt_rand(0, 1) ? 'www' : '';
    $domain = $random->word($domain_length);
    $tld = $tlds[mt_rand(0, (count($tlds) - 1))];
    $values['url'] = "$protocol://$www.$domain.$tld";

    $values['country'] = $random->word(mt_rand(1, 255));

    $values['adm1'] = $random->word(mt_rand(1, 255));

    $values['adm2'] = $random->word(mt_rand(1, 255));

    $values['adm3'] = $random->word(mt_rand(1, 255));

    $values['adm4'] = $random->word(mt_rand(1, 255));

    $values['adm5'] = $random->word(mt_rand(1, 255));

    $values['lat'] = $random->word(mt_rand(1, 255));

    $values['long'] = $random->word(mt_rand(1, 255));

    $values['note'] = $random->paragraphs(5);

    $values['note_system'] = $random->paragraphs(5);

    return $values;
  }

  /**
   * Returns allowed values for 'type' sub-field.
   */
  public static function allowedTypeValues(): array {
    // @todo Update allowed values.
    return [
      'alpha' => t('Alpha'),
      'beta' => t('Beta'),
      'gamma' => t('Gamma'),
    ];
  }

}
