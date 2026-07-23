<?php

declare(strict_types=1);

namespace Drupal\digitalia_pictura_inscription\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\digitalia_pictura_inscription\Plugin\Field\FieldType\InscriptionItem;
use Drupal\Core\Render\Markup;

/**
 * Plugin implementation of the 'digitalia_pictura_inscription_display' formatter.
 *
 * @FieldFormatter(
 *   id = "digitalia_pictura_inscription_display",
 *   label = @Translation("Display"),
 *   field_types = {"digitalia_pictura_inscription"},
 * )
 */
final class InscriptionDisplayFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $element = [];

    foreach ($items as $delta => $item) {
    $build = [];
      $details = "";

      if ($item->language) {
        $allowed_values = InscriptionItem::allowedLanguageValues();         
        $details .= '<div class="field field--label-inline"><div class="field__label">' . $this->t('Language')  . '</div>' . $allowed_values[$item->language] . '</div>';
      }

      if ($item->en_translation) {
        $details .= '<div class="field field--label-inline"><div class="field__label">' . $this->t('English translation') . '</div>' . $item->en_translation . '</div>';
      }

      if ($item->cs_translation) {
        $details .= '<div class="field field--label-inline"><div class="field__label">' . $this->t('Czech translation') . '</div>' . $item->cs_translation . '</div>';
      }

      if ($item->position) {
        $details .= '<div class="field field--label-inline"><div class="field__label">' . $this->t('Position') . '</div>' . $item->position . '</div>';
      }

      if ($item->author) {
        $details .= '<div class="field field--label-inline"><div class="field__label">' . $this->t('Author') . '</div>' . $item->author . '</div>';
      }

      if ($item->author_id) {
        if ($item->author_vocab) {
          $allowed_values = InscriptionItem::allowedLanguageValues();
          $author_id_type = $allowed_values[$item->author_vocab] . ": ";
        }       
        $details .= '<div class="field field--label-inline"><div class="field__label">' . $this->t('Author ID')  . '</div>' . $author_id_type . $item->author_id .'</div>';
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

      if ($item->text) {
        $module_path = \Drupal::service('extension.list.module')->getPath('digitalia_custom_field_types');
        $img_src = '/' . $module_path . '/assets/info.svg';

        $build['#attached']['library'][] = 'digitalia_custom_field_types/display-details';

        $build['display_value'] = [
          '#type' => 'details',
          '#title' => Markup::create($item->text . ' <img src="' . $img_src . '" alt="' . $this->t('Info')->render() . '" class="digitalia-muni-pictura-nfields-info-icon" />'),
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