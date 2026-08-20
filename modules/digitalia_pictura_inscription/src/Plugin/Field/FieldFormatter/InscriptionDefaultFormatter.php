<?php

declare(strict_types=1);

namespace Drupal\digitalia_pictura_inscription\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\digitalia_pictura_inscription\Plugin\Field\FieldType\InscriptionItem;

/**
 * Plugin implementation of the 'digitalia_pictura_inscription_default' formatter.
 *
 * @FieldFormatter(
 *   id = "digitalia_pictura_inscription_default",
 *   label = @Translation("Default"),
 *   field_types = {"digitalia_pictura_inscription"},
 * )
 */
final class InscriptionDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $element = [];

    foreach ($items as $delta => $item) {

      if ($item->text) {
        $element[$delta]['text'] = [
          '#type' => 'item',
          '#title' => $this->t('Text'),
          '#markup' => $item->text,
        ];
      }

      if ($item->language) {
        $allowed_values = InscriptionItem::allowedLanguageValues();
        $element[$delta]['language'] = [
          '#type' => 'item',
          '#title' => $this->t('Language'),
          '#markup' => $allowed_values[$item->language],
        ];
      }

      if ($item->en_translation) {
        $element[$delta]['en_translation'] = [
          '#type' => 'item',
          '#title' => $this->t('English translation'),
          '#markup' => $item->en_translation,
        ];
      }

      if ($item->cs_translation) {
        $element[$delta]['cs_translation'] = [
          '#type' => 'item',
          '#title' => $this->t('Czech translation'),
          '#markup' => $item->cs_translation,
        ];
      }

      if ($item->position) {
        $element[$delta]['position'] = [
          '#type' => 'item',
          '#title' => $this->t('Position'),
          '#markup' => $item->position,
        ];
      }

      if ($item->author) {
        $element[$delta]['author'] = [
          '#type' => 'item',
          '#title' => $this->t('Author'),
          '#markup' => $item->author,
        ];
      }

      if ($item->author_vocab) {
        $allowed_values = InscriptionItem::allowedAuthorIDTypeValues();
        $element[$delta]['author_vocab'] = [
          '#type' => 'item',
          '#title' => $this->t('Author ID type'),
          '#markup' => $allowed_values[$item->author_vocab],
        ];
      }

      if ($item->author_id) {
        $element[$delta]['author_id'] = [
          '#type' => 'item',
          '#title' => $this->t('Author ID'),
          '#markup' => $item->author_id,
        ];
      }

      if ($item->source) {
        $element[$delta]['source'] = [
          '#type' => 'item',
          '#title' => $this->t('Source'),
          '#markup' => $item->source,
        ];
      }

      if ($item->source_id) {
        $element[$delta]['source_id'] = [
          '#type' => 'item',
          '#title' => $this->t('Source ID'),
          '#markup' => $item->source_id,
        ];
      }

      if ($item->note) {
        $element[$delta]['note'] = [
          '#type' => 'item',
          '#title' => $this->t('Note'),
          '#markup' => $item->note,
        ];
      }

      if ($item->system_note) {
        $element[$delta]['system_note'] = [
          '#type' => 'item',
          '#title' => $this->t('System note'),
          '#markup' => $item->system_note,
        ];
      }

    }

    return $element;
  }

}
