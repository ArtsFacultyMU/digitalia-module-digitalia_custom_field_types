<?php

declare(strict_types=1);

namespace Drupal\digitalia_pictura_relation\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Url;
use Drupal\Core\Render\Markup;
use Drupal\digitalia_pictura_relation\Plugin\Field\FieldType\RelationItem;

/**
 * Plugin implementation of the 'digitalia_pictura_relation_display' formatter.
 *
 * @FieldFormatter(
 *   id = "digitalia_pictura_relation_display",
 *   label = @Translation("Display"),
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
      $build = [];
      $details = "";
      $value = "";

      if ($item->type) {
        $allowed_values = RelationItem::allowedLanguageValues();         
        $value .= $allowed_values[$item->type] . " ";
      }

      if ($item->link) {
        $value .= '<a href=" . $item->link . '>' . (!empty($item->name)) ? $item->name : $item->link . '</a>';
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

      if ($value) {
        $module_path = \Drupal::service('extension.list.module')->getPath('digitalia_custom_field_types');
        $img_src = '/' . $module_path . '/assets/info.svg';
        $build['#attached']['library'][] = 'digitalia_custom_field_types/display-details';

        $build['display_value'] = [
          '#type' => 'details',
          '#title' => Markup::create($value . ' <img src="' . $img_src . '" alt="' . $this->t('Info')->render() . '" class="digitalia-muni-pictura-nfields-info-icon" />'),
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