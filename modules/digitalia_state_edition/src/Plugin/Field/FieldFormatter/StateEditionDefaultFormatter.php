<?php

declare(strict_types=1);

namespace Drupal\digitalia_state_edition\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\digitalia_state_edition\Plugin\Field\FieldType\StateEditionItem;

/**
 * Plugin implementation of the 'digitalia_state_edition_default' formatter.
 *
 * @FieldFormatter(
 *   id = "digitalia_state_edition_default",
 *   label = @Translation("Default"),
 *   field_types = {"digitalia_state_edition"},
 * )
 */
final class StateEditionDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $element = [];

    foreach ($items as $delta => $item) {

      if ($item->name) {
        $element[$delta]['name'] = [
          '#type' => 'item',
          '#title' => $this->t('Name'),
          '#markup' => $item->name,
        ];
      }

      if ($item->description) {
        $element[$delta]['description'] = [
          '#type' => 'item',
          '#title' => $this->t('Description'),
          '#markup' => $item->description,
        ];
      }

      if ($item->type) {
        $allowed_values = StateEditionItem::allowedTypeValues();
        $element[$delta]['type'] = [
          '#type' => 'item',
          '#title' => $this->t('Type'),
          '#markup' => $allowed_values[$item->type],
        ];
      }

      if ($item->num) {
        $element[$delta]['num'] = [
          '#type' => 'item',
          '#title' => $this->t('Number'),
          '#markup' => $item->num,
        ];
      }

      if ($item->count) {
        $element[$delta]['count'] = [
          '#type' => 'item',
          '#title' => $this->t('Count'),
          '#markup' => $item->count,
        ];
      }

      if ($item->source) {
        $element[$delta]['source'] = [
          '#type' => 'item',
          '#title' => $this->t('Source'),
          '#markup' => $item->source,
        ];
      }

      if ($item->source_id) {
        $element[$delta]['source_id'] = [
          '#type' => 'item',
          '#title' => $this->t('Source ID'),
          '#markup' => $item->source_id,
        ];
      }

      if ($item->note) {
        $element[$delta]['note'] = [
          '#type' => 'item',
          '#title' => $this->t('Note'),
          '#markup' => $item->note,
        ];
      }

      if ($item->system_note) {
        $element[$delta]['system_note'] = [
          '#type' => 'item',
          '#title' => $this->t('System note'),
          '#markup' => $item->system_note,
        ];
      }

    }

    return $element;
  }

}
