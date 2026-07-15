<?php

declare(strict_types=1);

namespace Drupal\digitalia_field_links\Plugin\Field\FieldType;

use Drupal\Component\Utility\Random;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Defines the 'digitalia_field_links' field type.
 *
 * @FieldType(
 *   id = "digitalia_field_links",
 *   label = @Translation("Links"),
 *   description = @Translation("Some description."),
 *   default_widget = "digitalia_field_links",
 *   default_formatter = "digitalia_field_links_default",
 * )
 */
final class LinksItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public function isEmpty(): bool {
    return $this->link_type === NULL && $this->link_label === NULL && $this->url === NULL;
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition): array {

    $properties['link_type'] = DataDefinition::create('string')
      ->setLabel(t('Link type'));
    $properties['link_label'] = DataDefinition::create('string')
      ->setLabel(t('Link label'));
    $properties['url'] = DataDefinition::create('uri')
      ->setLabel(t('URL'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function getConstraints(): array {
    $constraints = parent::getConstraints();

    $options['link_type']['AllowedValues'] = array_keys(LinksItem::allowedLinkTypeValues());

    $options['link_label']['AllowedValues'] = array_keys(LinksItem::allowedLinkLabelValues());

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
      'link_type' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'link_label' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'url' => [
        'type' => 'varchar',
        'length' => 2048,
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

    $values['link_type'] = array_rand(self::allowedLinkTypeValues());

    $values['link_label'] = array_rand(self::allowedLinkLabelValues());

    $tlds = ['com', 'net', 'gov', 'org', 'edu', 'biz', 'info'];
    $domain_length = mt_rand(7, 15);
    $protocol = mt_rand(0, 1) ? 'https' : 'http';
    $www = mt_rand(0, 1) ? 'www' : '';
    $domain = $random->word($domain_length);
    $tld = $tlds[mt_rand(0, (count($tlds) - 1))];
    $values['url'] = "$protocol://$www.$domain.$tld";

    return $values;
  }

  /**
   * Returns allowed values for 'link_type' sub-field.
   */
  public static function allowedLinkTypeValues(): array {
    // @todo Update allowed values.
    return [
      'biograficky_zdroj' => t('biografický zdroj'),
    ];
  }

  /**
   * Returns allowed values for 'link_label' sub-field.
   */
  public static function allowedLinkLabelValues(): array {
    // @todo Update allowed values.
    return [
      'alpha' => t('Alpha'),
      'beta' => t('Beta'),
      'gamma' => t('Gamma'),
    ];
  }

}
