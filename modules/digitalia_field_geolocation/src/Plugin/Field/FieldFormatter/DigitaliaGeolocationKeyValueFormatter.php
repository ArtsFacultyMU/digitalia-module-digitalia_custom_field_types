<?php

declare(strict_types=1);

namespace Drupal\digitalia_field_geolocation\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\digitalia_field_geolocation\Plugin\Field\FieldType\DigitaliaGeolocationItem;

/**
 * Plugin implementation of the 'digitalia_field_geolocation_key_value' formatter.
 *
 * @FieldFormatter(
 *   id = "digitalia_field_geolocation_key_value",
 *   label = @Translation("Key-value"),
 *   field_types = {"digitalia_field_geolocation"},
 * )
 */
final class DigitaliaGeolocationKeyValueFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {

    $element = [];

    foreach ($items as $delta => $item) {
      $table = [
        '#type' => 'table',
      ];

      // Type.
      if ($item->type) {
        $allowed_values = DigitaliaGeolocationItem::allowedTypeValues();

        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('Type'),
              ],
            ],
            [
              'data' => [
                '#markup' => $allowed_values[$item->type],
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // Place.
      if ($item->place) {
        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('Place'),
              ],
            ],
            [
              'data' => [
                '#markup' => $item->place,
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // URL.
      if ($item->url) {
        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('URL'),
              ],
            ],
            [
              'data' => [
                '#markup' => $item->url,
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // Country.
      if ($item->country) {
        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('Country'),
              ],
            ],
            [
              'data' => [
                '#markup' => $item->country,
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // adm1.
      if ($item->adm1) {
        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('adm1'),
              ],
            ],
            [
              'data' => [
                '#markup' => $item->adm1,
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // adm2.
      if ($item->adm2) {
        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('adm2'),
              ],
            ],
            [
              'data' => [
                '#markup' => $item->adm2,
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // adm3.
      if ($item->adm3) {
        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('adm3'),
              ],
            ],
            [
              'data' => [
                '#markup' => $item->adm3,
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // adm4.
      if ($item->adm4) {
        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('adm4'),
              ],
            ],
            [
              'data' => [
                '#markup' => $item->adm4,
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // adm5.
      if ($item->adm5) {
        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('adm5'),
              ],
            ],
            [
              'data' => [
                '#markup' => $item->adm5,
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // Lat.
      if ($item->lat) {
        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('Lat'),
              ],
            ],
            [
              'data' => [
                '#markup' => $item->lat,
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // Long.
      if ($item->long) {
        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('Long'),
              ],
            ],
            [
              'data' => [
                '#markup' => $item->long,
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // Note.
      if ($item->note) {
        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('Note'),
              ],
            ],
            [
              'data' => [
                '#markup' => $item->note,
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // Note system.
      if ($item->note_system) {
        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('Note system'),
              ],
            ],
            [
              'data' => [
                '#markup' => $item->note_system,
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      $element[$delta] = $table;
    }

    return $element;
  }

}
