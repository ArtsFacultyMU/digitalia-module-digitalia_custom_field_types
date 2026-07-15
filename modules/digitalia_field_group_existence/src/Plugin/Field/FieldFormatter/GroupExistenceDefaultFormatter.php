<?php

declare(strict_types=1);

namespace Drupal\digitalia_field_group_existence\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\digitalia_field_group_existence\Plugin\Field\FieldType\GroupExistenceItem;

/**
 * Plugin implementation of the 'digitalia_field_group_existence_default' formatter.
 *
 * @FieldFormatter(
 *   id = "digitalia_field_group_existence_default",
 *   label = @Translation("Default"),
 *   field_types = {"digitalia_field_group_existence"},
 * )
 */
final class GroupExistenceDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $element = [];

    foreach ($items as $delta => $item) {

      if ($item->existence_type) {
        $allowed_values = GroupExistenceItem::allowedTypeOfExistenceValues();
        $element[$delta]['existence_type'] = [
          '#type' => 'item',
          '#title' => $this->t('Type of existence'),
          '#markup' => $allowed_values[$item->existence_type],
        ];
      }

      if ($item->from) {
        $element[$delta]['from'] = [
          '#type' => 'item',
          '#title' => $this->t('From'),
          '#markup' => $item->from,
        ];
      }

      if ($item->to) {
        $element[$delta]['to'] = [
          '#type' => 'item',
          '#title' => $this->t('To'),
          '#markup' => $item->to,
        ];
      }

    }

    return $element;
  }

}
