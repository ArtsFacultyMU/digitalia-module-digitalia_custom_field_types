<?php

declare(strict_types=1);

namespace Drupal\digitalia_muni_pictura_nfields_title\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Markup;
use Drupal\digitalia_muni_pictura_nfields_title\Plugin\Field\FieldType\StructuredTitleItem;

/**
 * Plugin implementation of the 'digitalia_muni_pictura_nfields_title_display' formatter.
 *
 * @FieldFormatter(
 *   id = "digitalia_muni_pictura_nfields_title_display",
 *   label = @Translation("Display"),
 *   field_types = {"digitalia_muni_pictura_nfields_title"},
 * )
 */
final class StructuredTitleDisplayFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $element = [];

    foreach ($items as $delta => $item) {
      $build = [];
      $details = "";

      if ($item->title_type) {
        $allowed_values = StructuredTitleItem::allowedTitleTypeValues();
        $details .= '<div class="field field--label-inline"><div class="field__label">' . $this->t('Title type') . '</div>' . $allowed_values[$item->title_type] . '</div>';
      }

      if ($item->language) {
        $allowed_values = StructuredTitleItem::allowedLanguageValues();         
        $details .= '<div class="field field--label-inline"><div class="field__label">' . $this->t('Language')  . '</div>' . $allowed_values[$item->language] . '</div>';
      }

      if ($item->source) {
        $details .= '<div class="field field--label-inline"><div class="field__label">' . $this->t('Source') . '</div>' . $item->source . '</div>';
      }

      if ($item->source_id) {
        $source_id_type = "";
        if ($item->id_type) {
          $allowed_values_id = StructuredTitleItem::allowedTitleIDTypeValues();
          $source_id_type = " (" . $allowed_values_id[$item->id_type] . ")";
        }
        $details .= '<div class="field field--label-inline"><div class="field__label">' . $this->t('Source ID') . '</div>' . $item->source_id . $source_id_type . '</div>';
      }

      if ($item->note) {
        $details .= '<div class="field field--label-inline"><div class="field__label">' . $this->t('Note') . '</div>' . $item->note . '</div>';
      } 

      if ($item->title) {
        $module_path = \Drupal::service('extension.list.module')->getPath('digitalia_muni_pictura_nfields_title');
        $img_src = '/' . $module_path . '/assets/info.svg';

        $build['#attached']['library'][] = 'digitalia_muni_pictura_nfields_title/display-details';

        $build['display_value'] = [
          '#type' => 'details',
          '#title' => Markup::create($item->title . ' <img src="' . $img_src . '" alt="' . $this->t('Info')->render() . '" class="digitalia-muni-pictura-nfields-info-icon" />'),
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
