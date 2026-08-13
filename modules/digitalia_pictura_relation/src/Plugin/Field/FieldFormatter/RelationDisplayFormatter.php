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
final class RelationDisplayFormatter extends FormatterBase {

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
        $allowed_values = RelationItem::allowedTypeValues();         
        $value .= $allowed_values[$item->type];
        $details .= '<div class="field field--label-inline"><div class="field__label">' . $this->t('Relation type') . '</div>' . $allowed_values[$item->type] . '</div>';
      }

      if ($item->name) {
        if ($value) {
          $value .= ' ';
        }
        $value .= $item->name;
        $details .= '<div class="field field--label-inline"><div class="field__label">' . $this->t('Name of related resource') . '</div>' . $item->name . '</div>';
      }

      /*
      if ($item->link) {
        $details .= '<div class="field field--label-inline"><div class="field__label">' . $this->t('ID of related resource') . '</div><a href=' . $item->link . '>' . $item->link . '</a></div>';
      }
      */

      if ($item->source_id) {
        $details .= '<div class="field field--label-inline"><div class="field__label">' . $this->t('Source ID') . '</div>' . $item->source_id . '</div>';
      }

      if ($item->source) {
        $details .= '<div class="field field--label-inline"><div class="field__label">' . $this->t('Source') . '</div>' . $item->source . '</div>';
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

      if (!empty($build)) {
        $element[$delta] = $build;
      }
    }

    return $element;
  }

}