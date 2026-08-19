<?php

declare(strict_types=1);

namespace Drupal\digitalia_field_geolocation\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\digitalia_field_geolocation\Plugin\Field\FieldType\DigitaliaGeolocationItem;

/**
 * Plugin implementation of the 'digitalia_field_geolocation_table' formatter.
 *
 * @FieldFormatter(
 *   id = "digitalia_field_geolocation_table",
 *   label = @Translation("Table"),
 *   field_types = {"digitalia_field_geolocation"},
 * )
 */
final class DigitaliaGeolocationTableFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {

    $header[] = '#';
    $header[] = $this->t('Type');
    $header[] = $this->t('Place');
    $header[] = $this->t('URL');
    $header[] = $this->t('Country');
    $header[] = $this->t('adm1');
    $header[] = $this->t('adm2');
    $header[] = $this->t('adm3');
    $header[] = $this->t('adm4');
    $header[] = $this->t('adm5');
    $header[] = $this->t('Lat');
    $header[] = $this->t('Long');
    $header[] = $this->t('Note');
    $header[] = $this->t('Note system');

    $table = [
      '#type' => 'table',
      '#header' => $header,
    ];

    foreach ($items as $delta => $item) {
      $row = [];

      $row[]['#markup'] = $delta + 1;

      if ($item->type) {
        $allowed_values = DigitaliaGeolocationItem::allowedTypeValues();
        $row[]['#markup'] = $allowed_values[$item->type];
      }
      else {
        $row[]['#markup'] = '';
      }

      $row[]['#markup'] = $item->place;

      $row[]['#markup'] = $item->url;

      $row[]['#markup'] = $item->country;

      $row[]['#markup'] = $item->adm1;

      $row[]['#markup'] = $item->adm2;

      $row[]['#markup'] = $item->adm3;

      $row[]['#markup'] = $item->adm4;

      $row[]['#markup'] = $item->adm5;

      $row[]['#markup'] = $item->lat;

      $row[]['#markup'] = $item->long;

      $row[]['#markup'] = $item->note;

      $row[]['#markup'] = $item->note_system;

      $table[$delta] = $row;
    }

    return [$table];
  }

}
