<?php

declare(strict_types=1);

namespace Drupal\digitalia_field_group_names\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\digitalia_field_group_names\Plugin\Field\FieldType\GroupNamesItem;

/**
 * Plugin implementation of the 'digitalia_field_group_names_default' formatter.
 *
 * @FieldFormatter(
 *   id = "digitalia_field_group_names_default",
 *   label = @Translation("Default"),
 *   field_types = {"digitalia_field_group_names"},
 * )
 */
final class GroupNamesDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $element = [];

    foreach ($items as $delta => $item) {

      if ($item->name_category) {
        $allowed_values = GroupNamesItem::allowedNameCategoryValues();
        $element[$delta]['name_category'] = [
          '#type' => 'item',
          '#title' => $this->t('Name category'),
          '#markup' => $allowed_values[$item->name_category],
        ];
      }

      if ($item->name) {
        $element[$delta]['name'] = [
          '#type' => 'item',
          '#title' => $this->t('Name'),
          '#markup' => $item->name,
        ];
      }

      if ($item->specification) {
        $element[$delta]['specification'] = [
          '#type' => 'item',
          '#title' => $this->t('Specification'),
          '#markup' => $item->specification,
        ];
      }

      if ($item->name_source) {
        $element[$delta]['name_source'] = [
          '#type' => 'item',
          '#title' => $this->t('Name source'),
          '#markup' => $item->name_source,
        ];
      }

      if ($item->name_note) {
        $element[$delta]['name_note'] = [
          '#type' => 'item',
          '#title' => $this->t('Name note'),
          '#markup' => $item->name_note,
        ];
      }

    }

    return $element;
  }

}
