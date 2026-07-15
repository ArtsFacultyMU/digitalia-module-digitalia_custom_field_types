<?php

declare(strict_types=1);

namespace Drupal\digitalia_field_work_in_institutions\Plugin\Field\FieldType;

use Drupal\Component\Utility\Random;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Defines the 'digitalia_field_work_in_institutions' field type.
 *
 * @FieldType(
 *   id = "digitalia_field_work_in_institutions",
 *   label = @Translation("Work in Institutions"),
 *   description = @Translation("Some description."),
 *   default_widget = "digitalia_field_work_in_institutions",
 *   default_formatter = "digitalia_field_work_in_institutions_default",
 * )
 */
final class WorkInInstitutionsItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public function isEmpty(): bool {
    return $this->institution === NULL && $this->from_day === NULL && $this->from_month === NULL && $this->from_year === NULL && $this->to_day === NULL && $this->to_month === NULL && $this->to_year === NULL && $this->position === NULL;
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition): array {

    $properties['institution'] = DataDefinition::create('string')
      ->setLabel(t('Institution'));
    $properties['from_day'] = DataDefinition::create('integer')
      ->setLabel(t('From (day)'));
    $properties['from_month'] = DataDefinition::create('integer')
      ->setLabel(t('From (month)'));
    $properties['from_year'] = DataDefinition::create('integer')
      ->setLabel(t('From (year)'));
    $properties['to_day'] = DataDefinition::create('integer')
      ->setLabel(t('To (day)'));
    $properties['to_month'] = DataDefinition::create('integer')
      ->setLabel(t('To (month)'));
    $properties['to_year'] = DataDefinition::create('integer')
      ->setLabel(t('To (year)'));
    $properties['position'] = DataDefinition::create('string')
      ->setLabel(t('Position'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function getConstraints(): array {
    $constraints = parent::getConstraints();

    $options['from_day']['AllowedValues'] = array_keys(WorkInInstitutionsItem::allowedFromDayValues());

    $options['from_month']['AllowedValues'] = array_keys(WorkInInstitutionsItem::allowedFromMonthValues());

    $options['to_day']['AllowedValues'] = array_keys(WorkInInstitutionsItem::allowedToDayValues());

    $options['to_month']['AllowedValues'] = array_keys(WorkInInstitutionsItem::allowedToMonthValues());

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
      'institution' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'from_day' => [
        'type' => 'int',
        'size' => 'normal',
      ],
      'from_month' => [
        'type' => 'int',
        'size' => 'normal',
      ],
      'from_year' => [
        'type' => 'int',
        'size' => 'normal',
      ],
      'to_day' => [
        'type' => 'int',
        'size' => 'normal',
      ],
      'to_month' => [
        'type' => 'int',
        'size' => 'normal',
      ],
      'to_year' => [
        'type' => 'int',
        'size' => 'normal',
      ],
      'position' => [
        'type' => 'varchar',
        'length' => 255,
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

    $values['institution'] = $random->word(mt_rand(1, 255));

    $values['from_day'] = array_rand(self::allowedFromDayValues());

    $values['from_month'] = array_rand(self::allowedFromMonthValues());

    $values['from_year'] = mt_rand(-1000, 1000);

    $values['to_day'] = array_rand(self::allowedToDayValues());

    $values['to_month'] = array_rand(self::allowedToMonthValues());

    $values['to_year'] = mt_rand(-1000, 1000);

    $values['position'] = $random->word(mt_rand(1, 255));

    return $values;
  }

  /**
   * Returns allowed values for 'from_day' sub-field.
   */
  public static function allowedFromDayValues(): array {
    return self::getNumericValues(1, 31);
  }

  /**
   * Returns allowed values for 'from_month' sub-field.
   */
  public static function allowedFromMonthValues(): array {
    return self::getNumericValues(1, 12);
  }

  /**
   * Returns allowed values for 'to_day' sub-field.
   */
  public static function allowedToDayValues(): array {
    return self::getNumericValues(1, 31);
  }

  /**
   * Returns allowed values for 'to_month' sub-field.
   */
  public static function allowedToMonthValues(): array {
    return self::getNumericValues(1, 12);
  }

  public static function getNumericValues(int $min, int $max): array {
    $values = [];
    for ($i = $min; $i <= $max; $i++) {
      $values[$i] = $i;
    }
    return $values;
  }

}
