<?php

declare(strict_types=1);

namespace Drupal\digitalia_muni_pictura_nfields_title\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\digitalia_muni_pictura_nfields_title\Plugin\Field\FieldType\StructuredTitleItem;

/**
 * Plugin implementation of the 'digitalia_muni_pictura_nfields_title_default' formatter.
 *
 * @FieldFormatter(
 *   id = "digitalia_muni_pictura_nfields_title_default",
 *   label = @Translation("Default"),
 *   field_types = {"digitalia_muni_pictura_nfields_title"},
 * )
 */
final class StructuredTitleDefaultFormatter extends FormatterBase {


  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $element = [];

    foreach ($items as $delta => $item) {

      if ($item->title) {
        $element[$delta]['title'] = [
          '#type' => 'item',
          '#title' => $this->t('Title'),
          '#markup' => $item->title,
        ];
      }

      if ($item->title_type) {
        $allowed_values = StructuredTitleItem::allowedTitleTypeValues();
        $element[$delta]['title_type'] = [
          '#type' => 'item',
          '#title' => $this->t('Title type'),
          '#markup' => $allowed_values[$item->title_type],
        ];
      }

      if ($item->language) {
        $allowed_values = StructuredTitleItem::allowedLanguageValues();
        $element[$delta]['language'] = [
          '#type' => 'item',
          '#title' => $this->t('Language'),
          '#markup' => $allowed_values[$item->language],
        ];
      }

      if ($item->id) {
        $element[$delta]['id'] = [
          '#type' => 'item',
          '#title' => $this->t('Title ID'),
          '#markup' => $item->id,
        ];
      }

      if ($item->id_type) {
        $allowed_values = StructuredTitleItem::allowedTitleIDTypeValues();
        $element[$delta]['id_type'] = [
          '#type' => 'item',
          '#title' => $this->t('Title ID type'),
          '#markup' => $allowed_values[$item->id_type],
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
          '#title' => $this->t('source_id'),
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
