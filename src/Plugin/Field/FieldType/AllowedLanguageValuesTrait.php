<?php

declare(strict_types=1);

namespace Drupal\digitalia_custom_field_types\Plugin\Field\FieldType;

/**
 * Provides a shared list of allowed language values for field sub-fields.
 */
trait AllowedLanguageValuesTrait {

  /**
   * Returns allowed values for 'language' sub-field. ISO639-2.
   */
  public static function allowedLanguageValues(): array {
    return [
      'eng' => t('English'),
      'ces' => t('Czech'),
      'lat' => t('Latin'),
      'ger' => t('German'),
      'fre' => t('French'),
      'rus' => t('Russian'),
      'ita' => t('Italian'),
      'gre' => t('Modern Greek'),
      'pol' => t('Polish'),
      'spa' => t('Spanish'),
      'other' => t('other'),
    ];
  }

}
