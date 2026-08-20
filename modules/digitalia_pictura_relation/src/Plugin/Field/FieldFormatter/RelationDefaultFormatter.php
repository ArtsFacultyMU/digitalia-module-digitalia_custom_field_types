<?php

declare(strict_types=1);

namespace Drupal\digitalia_pictura_relation\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Url;
use Drupal\digitalia_pictura_relation\Plugin\Field\FieldType\RelationItem;

/**
 * Plugin implementation of the 'digitalia_pictura_relation_default' formatter.
 *
 * @FieldFormatter(
 *   id = "digitalia_pictura_relation_default",
 *   label = @Translation("Default"),
 *   field_types = {"digitalia_pictura_relation"},
 * )
 */
final class RelationDefaultFormatter extends FormatterBase {

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

      if ($item->type) {
        $allowed_values = RelationItem::allowedTypeValues();
        $element[$delta]['type'] = [
          '#type' => 'item',
          '#title' => $this->t('Type'),
          '#markup' => $allowed_values[$item->type],
        ];
      }

      if ($item->link) {
        $element[$delta]['link'] = [
          '#type' => 'item',
          '#title' => $this->t('Link'),
          'content' => [
            '#type' => 'link',
            '#title' => $item->link,
            '#url' => Url::fromUri($item->link),
          ],
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
          '#title' => $this->t('Value 5'),
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
