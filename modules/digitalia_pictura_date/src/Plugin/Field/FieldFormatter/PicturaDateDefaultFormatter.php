<?php

declare(strict_types=1);

namespace Drupal\digitalia_pictura_date\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\digitalia_pictura_date\Plugin\Field\FieldType\PicturaDateItem;

/**
 * Plugin implementation of the 'digitalia_pictura_date_default' formatter.
 *
 * @FieldFormatter(
 *   id = "digitalia_pictura_date_default",
 *   label = @Translation("Default"),
 *   field_types = {"digitalia_pictura_date"},
 * )
 */
final class PicturaDateDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $element = [];

    foreach ($items as $delta => $item) {

      if ($item->date) {
        $element[$delta]['date'] = [
          '#type' => 'item',
          '#title' => $this->t('Date'),
          '#markup' => $item->date,
        ];
      }

      if ($item->language) {
        $allowed_values = PicturaDateItem::allowedLanguageValues();
        $element[$delta]['language'] = [
          '#type' => 'item',
          '#title' => $this->t('Language'),
          '#markup' => $allowed_values[$item->language],
        ];
      }

      if ($item->earliest_year) {
        $element[$delta]['earliest_year'] = [
          '#type' => 'item',
          '#title' => $this->t('Earliest year'),
          '#markup' => $item->earliest_year,
        ];
      }

      if ($item->latest_year) {
        $element[$delta]['latest_year'] = [
          '#type' => 'item',
          '#title' => $this->t('Latest year'),
          '#markup' => $item->latest_year,
        ];
      }

      if ($item->date_type) {
        $allowed_values = PicturaDateItem::allowedDateTypeValues();
        $element[$delta]['date_type'] = [
          '#type' => 'item',
          '#title' => $this->t('Date type'),
          '#markup' => $allowed_values[$item->date_type],
        ];
      }

      if ($item->translations) {
        $element[$delta]['translations'] = [
          '#type' => 'item',
          '#title' => $this->t('Translations'),
          '#markup' => $item->translations,
        ];
      }

      if ($item->source_id) {
        $element[$delta]['source_id'] = [
          '#type' => 'item',
          '#title' => $this->t('Source ID'),
          '#markup' => $item->source_id,
        ];
      }

      if ($item->source) {
        $element[$delta]['source'] = [
          '#type' => 'item',
          '#title' => $this->t('Source'),
          '#markup' => $item->source,
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
