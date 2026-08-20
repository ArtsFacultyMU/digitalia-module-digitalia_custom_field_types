<?php

declare(strict_types=1);

namespace Drupal\digitalia_pictura_description\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\digitalia_pictura_description\Plugin\Field\FieldType\DescriptionItem;

/**
 * Plugin implementation of the 'digitalia_pictura_description_default' formatter.
 *
 * @FieldFormatter(
 *   id = "digitalia_pictura_description_default",
 *   label = @Translation("Default"),
 *   field_types = {"digitalia_pictura_description"},
 * )
 */
final class DescriptionDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings(): array {
    return ['foo' => 'bar'] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state): array {
    $element['foo'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Foo'),
      '#default_value' => $this->getSetting('foo'),
    ];
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary(): array {
    return [
      $this->t('Foo: @foo', ['@foo' => $this->getSetting('foo')]),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $element = [];

    foreach ($items as $delta => $item) {

      if ($item->description) {
        $element[$delta]['description'] = [
          '#type' => 'item',
          '#title' => $this->t('Description'),
          '#markup' => $item->description,
        ];
      }

      if ($item->language) {
        $allowed_values = DescriptionItem::allowedLanguageValues();
        $element[$delta]['language'] = [
          '#type' => 'item',
          '#title' => $this->t('Language'),
          '#markup' => $allowed_values[$item->language],
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
