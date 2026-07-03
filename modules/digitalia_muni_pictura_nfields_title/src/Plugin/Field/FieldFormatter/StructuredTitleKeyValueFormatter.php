<?php

declare(strict_types=1);

namespace Drupal\digitalia_muni_pictura_nfields_title\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\digitalia_muni_pictura_nfields_title§\Plugin\Field\FieldType\StructuredTitleItem;

/**
 * Plugin implementation of the 'digitalia_muni_pictura_nfields_title_key_value' formatter.
 *
 * @FieldFormatter(
 *   id = "digitalia_muni_pictura_nfields_title_key_value",
 *   label = @Translation("Key-value"),
 *   field_types = {"digitalia_muni_pictura_nfields_title"},
 * )
 */
final class StructuredTitleKeyValueFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {

    $element = [];

    foreach ($items as $delta => $item) {
      $table = [
        '#type' => 'table',
      ];

      // Title.
      if ($item->title) {
        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('Title'),
              ],
            ],
            [
              'data' => [
                '#markup' => $item->title,
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // Title type.
      if ($item->title_type) {
        $allowed_values = StructuredTitleItem::allowedTitleTypeValues();

        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('Title type'),
              ],
            ],
            [
              'data' => [
                '#markup' => $allowed_values[$item->title_type],
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // Language.
      if ($item->language) {
        $allowed_values = StructuredTitleItem::allowedLanguageValues();

        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('Language'),
              ],
            ],
            [
              'data' => [
                '#markup' => $allowed_values[$item->language],
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // Title ID.
      if ($item->id) {
        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('Title ID'),
              ],
            ],
            [
              'data' => [
                '#markup' => $item->id,
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // Title ID type.
      if ($item->id_type) {
        $allowed_values = StructuredTitleItem::allowedTitleIDTypeValues();

        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('Title ID type'),
              ],
            ],
            [
              'data' => [
                '#markup' => $allowed_values[$item->id_type],
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // Source.
      if ($item->source) {
        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('Source'),
              ],
            ],
            [
              'data' => [
                '#markup' => $item->source,
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // source_id.
      if ($item->source_id) {
        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('source_id'),
              ],
            ],
            [
              'data' => [
                '#markup' => $item->source_id,
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

      // System note.
      if ($item->system_note) {
        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('System note'),
              ],
            ],
            [
              'data' => [
                '#markup' => $item->system_note,
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
