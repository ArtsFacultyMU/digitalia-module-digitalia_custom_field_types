<?php

declare(strict_types=1);

namespace Drupal\digitalia_field_group_localization\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\digitalia_field_group_localization\Plugin\Field\FieldType\GroupLocalizationItem;

/**
 * Plugin implementation of the 'digitalia_field_group_localization_default' formatter.
 *
 * @FieldFormatter(
 *   id = "digitalia_field_group_localization_default",
 *   label = @Translation("Default"),
 *   field_types = {"digitalia_field_group_localization"},
 * )
 */
final class GroupLocalizationDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $element = [];

    foreach ($items as $delta => $item) {

      if ($item->localization_type) {
        $allowed_values = GroupLocalizationItem::allowedLocalizationTypeValues();
        $element[$delta]['localization_type'] = [
          '#type' => 'item',
          '#title' => $this->t('Localization type'),
          '#markup' => $allowed_values[$item->localization_type],
        ];
      }

      if ($item->place) {
        $element[$delta]['place'] = [
          '#type' => 'item',
          '#title' => $this->t('Place'),
          '#markup' => $item->place,
        ];
      }

      if ($item->identifier_scheme) {
        $allowed_values = GroupLocalizationItem::allowedIdentifierSchemeValues();
        $element[$delta]['identifier_scheme'] = [
          '#type' => 'item',
          '#title' => $this->t('Identifier scheme'),
          '#markup' => $allowed_values[$item->identifier_scheme],
        ];
      }

      if ($item->identifier) {
        $element[$delta]['identifier'] = [
          '#type' => 'item',
          '#title' => $this->t('Identifier'),
          '#markup' => $item->identifier,
        ];
      }

      if ($item->localization_note) {
        $element[$delta]['localization_note'] = [
          '#type' => 'item',
          '#title' => $this->t('Localization note'),
          '#markup' => $item->localization_note,
        ];
      }

    }

    return $element;
  }

}
