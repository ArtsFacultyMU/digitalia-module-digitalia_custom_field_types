<?php

declare(strict_types=1);

namespace Drupal\digitalia_field_geolocation\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Render\Markup;
use Drupal\Core\Url;
use Drupal\digitalia_field_geolocation\Plugin\Field\FieldType\DigitaliaGeolocationItem;

/**
 * Plugin implementation of the 'digitalia_field_geolocation_display' formatter.
 *
 * @FieldFormatter(
 *   id = "digitalia_field_geolocation_display",
 *   label = @Translation("Display"),
 *   field_types = {"digitalia_field_geolocation"},
 * )
 */
final class DigitaliaGeolocationDisplayFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $element = [];

    foreach ($items as $delta => $item) {
      $build = [];
      $details = "";

      // Prepare header label: prefer place, otherwise the highest-numbered adm.
      $label = null;
      if (!empty($item->place)) {
        $label = $item->place;
      }
      else {
        for ($i = 5; $i >= 1; $i--) {
          $adm = 'adm' . $i;
          if (!empty($item->{$adm})) {
            $label = $item->{$adm};
            break;
          }
        }
      }

      // If there's no place/adm to show in the header, skip rendering.
      if ($label === null) {
        continue;
      }

      // Type label
      $allowed_values = DigitaliaGeolocationItem::allAllowedTypeValues();
      $type_label = '';
      if (!empty($item->type) && isset($allowed_values[$item->type])) {
        $type_label = $allowed_values[$item->type];
        $details .= '<div class="field field--label-inline"><div class="field__label">' . $this->t('Type') . '</div>' . $type_label . '</div>';
      }

      if (!empty($item->place)) {
        $details .= '<div class="field field--label-inline"><div class="field__label">' . $this->t('Place') . '</div>' . $item->place . '</div>';
      }

      if (!empty($item->country)) {
        $details .= '<div class="field field--label-inline"><div class="field__label">' . $this->t('Country') . '</div>' . $item->country . '</div>';
      }

      for ($i = 1; $i <= 5; $i++) {
        $adm = 'adm' . $i;
        if (!empty($item->{$adm})) {
          $details .= '<div class="field field--label-inline"><div class="field__label">' . $this->t($adm) . '</div>' . $item->{$adm} . '</div>';
        }
      }

      if (!empty($item->lat)) {
        $details .= '<div class="field field--label-inline"><div class="field__label">' . $this->t('Lat') . '</div>' . $item->lat . '</div>';
      }

      if (!empty($item->long)) {
        $details .= '<div class="field field--label-inline"><div class="field__label">' . $this->t('Long') . '</div>' . $item->long . '</div>';
      }

      if (!empty($item->url)) {
        $details .= '<div class="field field--label-inline"><div class="field__label">' . $this->t('URL') . '</div><a href="' . $item->url . '">' . $item->url . '</a></div>';
      }

      if (!empty($item->note)) {
        $details .= '<div class="field field--label-inline"><div class="field__label">' . $this->t('Note') . '</div>' . $item->note . '</div>';
      }

      // Build the details render element.
      $module_path = \Drupal::service('extension.list.module')->getPath('digitalia_custom_field_types');
      $img_src = '/' . $module_path . '/assets/info.svg';
      $build['#attached']['library'][] = 'digitalia_custom_field_types/display-details';

      $header_title = $type_label ? $type_label . ': ' . $label : $label;

      $build['display_value'] = [
        '#type' => 'details',
        '#title' => Markup::create($header_title . ' <img src="' . $img_src . '" alt="' . $this->t('Info')->render() . '" class="digitalia-muni-pictura-nfields-info-icon" />'),
        '#open' => FALSE,
        'content' => [
          '#type' => 'item',
          '#markup' => $details,
        ],
        '#attributes' => [
          'class' => ['digitalia-muni-pictura-nfields-details'],
        ],
      ];

      $element[$delta] = $build;
    }

    return $element;
  }

}