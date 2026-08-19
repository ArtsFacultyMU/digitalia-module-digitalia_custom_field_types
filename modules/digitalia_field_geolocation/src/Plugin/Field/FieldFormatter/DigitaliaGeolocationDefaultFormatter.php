<?php

declare(strict_types=1);

namespace Drupal\digitalia_field_geolocation\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\digitalia_field_geolocation\Plugin\Field\FieldType\DigitaliaGeolocationItem;

/**
 * Plugin implementation of the 'digitalia_field_geolocation_default' formatter.
 *
 * @FieldFormatter(
 *   id = "digitalia_field_geolocation_default",
 *   label = @Translation("Default"),
 *   field_types = {"digitalia_field_geolocation"},
 * )
 */
final class DigitaliaGeolocationDefaultFormatter extends FormatterBase {

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

      if ($item->type) {
        $allowed_values = DigitaliaGeolocationItem::allowedTypeValues();
        $element[$delta]['type'] = [
          '#type' => 'item',
          '#title' => $this->t('Type'),
          '#markup' => $allowed_values[$item->type],
        ];
      }

      if ($item->place) {
        $element[$delta]['place'] = [
          '#type' => 'item',
          '#title' => $this->t('Place'),
          '#markup' => $item->place,
        ];
      }

      if ($item->url) {
        $element[$delta]['url'] = [
          '#type' => 'item',
          '#title' => $this->t('URL'),
          'content' => [
            '#type' => 'link',
            '#title' => $item->url,
            '#url' => Url::fromUri($item->url),
          ],
        ];
      }

      if ($item->country) {
        $element[$delta]['country'] = [
          '#type' => 'item',
          '#title' => $this->t('Country'),
          '#markup' => $item->country,
        ];
      }

      if ($item->adm1) {
        $element[$delta]['adm1'] = [
          '#type' => 'item',
          '#title' => $this->t('adm1'),
          '#markup' => $item->adm1,
        ];
      }

      if ($item->adm2) {
        $element[$delta]['adm2'] = [
          '#type' => 'item',
          '#title' => $this->t('adm2'),
          '#markup' => $item->adm2,
        ];
      }

      if ($item->adm3) {
        $element[$delta]['adm3'] = [
          '#type' => 'item',
          '#title' => $this->t('adm3'),
          '#markup' => $item->adm3,
        ];
      }

      if ($item->adm4) {
        $element[$delta]['adm4'] = [
          '#type' => 'item',
          '#title' => $this->t('adm4'),
          '#markup' => $item->adm4,
        ];
      }

      if ($item->adm5) {
        $element[$delta]['adm5'] = [
          '#type' => 'item',
          '#title' => $this->t('adm5'),
          '#markup' => $item->adm5,
        ];
      }

      if ($item->lat) {
        $element[$delta]['lat'] = [
          '#type' => 'item',
          '#title' => $this->t('Lat'),
          '#markup' => $item->lat,
        ];
      }

      if ($item->long) {
        $element[$delta]['long'] = [
          '#type' => 'item',
          '#title' => $this->t('Long'),
          '#markup' => $item->long,
        ];
      }

      if ($item->note) {
        $element[$delta]['note'] = [
          '#type' => 'item',
          '#title' => $this->t('Note'),
          '#markup' => $item->note,
        ];
      }

      if ($item->note_system) {
        $element[$delta]['note_system'] = [
          '#type' => 'item',
          '#title' => $this->t('Note system'),
          '#markup' => $item->note_system,
        ];
      }

    }

    return $element;
  }

}
