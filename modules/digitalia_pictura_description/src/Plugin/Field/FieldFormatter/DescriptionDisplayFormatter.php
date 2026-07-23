<?php

declare(strict_types=1);

namespace Drupal\digitalia_pictura_description\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Markup;
use Drupal\digitalia_pictura_description\Plugin\Field\FieldType\DescriptionItem;

/**
 * Plugin implementation of the 'digitalia_pictura_description_display' formatter.
 *
 * @FieldFormatter(
 *   id = "digitalia_pictura_description_display",
 *   label = @Translation("Display"),
 *   field_types = {"digitalia_pictura_description"},
 * )
 */
final class DescriptionDisplayFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $element = [];

    foreach ($items as $delta => $item) {
      $build = [];
      $details = "";

      if ($item->language) {
        $allowed_values = DescriptionItem::allowedLanguageValues();         
        $details .= '<div class="field field--label-inline"><div class="field__label">' . $this->t('Language')  . '</div>' . $allowed_values[$item->language] . '</div>';
      }

      if ($item->source) {
        $details .= '<div class="field field--label-inline"><div class="field__label">' . $this->t('Source') . '</div>' . $item->source . '</div>';
      }

      if ($item->source_id) {
        $details .= '<div class="field field--label-inline"><div class="field__label">' . $this->t('Source ID') . '</div>' . $item->source_id . '</div>';
      }

      if ($item->note) {
        $details .= '<div class="field field--label-inline"><div class="field__label">' . $this->t('Note') . '</div>' . $item->note . '</div>';
      }

      if ($item->description) {
        $module_path = \Drupal::service('extension.list.module')->getPath('digitalia_custom_field_types');
        $img_src = '/' . $module_path . '/assets/info.svg';
        $build['#attached']['library'][] = 'digitalia_custom_field_types/display-details';

        $build['display_value'] = [
          '#type' => 'details',
          '#title' => Markup::create($item->description . ' <img src="' . $img_src . '" alt="' . $this->t('Info')->render() . '" class="digitalia-muni-pictura-nfields-info-icon" />'),
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