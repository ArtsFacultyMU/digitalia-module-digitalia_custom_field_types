<?php

declare(strict_types=1);

namespace Drupal\digitalia_pictura_date\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Render\Markup;
use Drupal\digitalia_pictura_date\Plugin\Field\FieldType\PicturaDateItem;

/**
 * Plugin implementation of the 'digitalia_pictura_date_display' formatter.
 *
 * @FieldFormatter(
 *   id = "digitalia_pictura_date_display",
 *   label = @Translation("Display"),
 *   field_types = {"digitalia_pictura_date"},
 * )
 */
final class PicturaDateDisplayFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $element = [];

    foreach ($items as $delta => $item) {
      $build = [];
      $details = "";

      if ($item->language) {
        $allowed_values = PicturaDateItem::allowedLanguageValues();
        $details .= '<div class="field field--label-inline"><div class="field__label">' . $this->t('Language') . '</div>' . $allowed_values[$item->language] . '</div>';
      }

      if ($item->earliest_year) {
        $details .= '<div class="field field--label-inline"><div class="field__label">' . $this->t('Earliest year') . '</div>' . $item->earliest_year . '</div>';
      }

      if ($item->latest_year) {
        $details .= '<div class="field field--label-inline"><div class="field__label">' . $this->t('Latest year') . '</div>' . $item->latest_year . '</div>';
      }

      if ($item->date_type) {
        $allowed_values = PicturaDateItem::allowedDateTypeValues();
        $details .= '<div class="field field--label-inline"><div class="field__label">' . $this->t('Date type') . '</div>' . $allowed_values[$item->date_type] . '</div>';
      }

      if ($item->source_id) {
        $details .= '<div class="field field--label-inline"><div class="field__label">' . $this->t('Source ID') . '</div>' . $item->source_id . '</div>';
      }

      if ($item->source) {
        $details .= '<div class="field field--label-inline"><div class="field__label">' . $this->t('Source') . '</div>' . $item->source . '</div>';
      }

      if ($item->note) {
        $details .= '<div class="field field--label-inline"><div class="field__label">' . $this->t('Note') . '</div>' . $item->note . '</div>';
      }

      if ($item->date) {
        $module_path = \Drupal::service('extension.list.module')->getPath('digitalia_custom_field_types');
        $img_src = '/' . $module_path . '/assets/info.svg';
        $build['#attached']['library'][] = 'digitalia_custom_field_types/display-details';

        $title = $item->date;
        if ($item->translations) {
          $title .= ' (' . $item->translations . ')';
          $details .= '<div class="field field--label-inline"><div class="field__label">' . $this->t('Translations') . '</div>' . $item->translations . '</div>';
        }

        $build['display_value'] = [
          '#type' => 'details',
          '#title' => Markup::create($allowed_values[$item->date_type] . ': ' . $title . ' <img src="' . $img_src . '" alt="' . $this->t('Info')->render() . '" class="digitalia-muni-pictura-nfields-info-icon" />'),
          '#open' => FALSE,
          'content' => [
            '#type' => 'item',
            '#markup' => $details,
          ],
          '#attributes' => [
            'class' => ['digitalia-muni-pictura-nfields-details']
          ],
        ];
      }

      $element[$delta] = $build;
    }

    return $element;
  }

}
