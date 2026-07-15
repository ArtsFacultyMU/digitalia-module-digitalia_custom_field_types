<?php

declare(strict_types=1);

namespace Drupal\digitalia_field_links\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\digitalia_field_links\Plugin\Field\FieldType\LinksItem;

/**
 * Plugin implementation of the 'digitalia_field_links_default' formatter.
 *
 * @FieldFormatter(
 *   id = "digitalia_field_links_default",
 *   label = @Translation("Default"),
 *   field_types = {"digitalia_field_links"},
 * )
 */
final class LinksDefaultFormatter extends FormatterBase {

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

      if ($item->link_type) {
        $allowed_values = LinksItem::allowedLinkTypeValues();
        $element[$delta]['link_type'] = [
          '#type' => 'item',
          '#title' => $this->t('Link type'),
          '#markup' => $allowed_values[$item->link_type],
        ];
      }

      if ($item->link_label) {
        $allowed_values = LinksItem::allowedLinkLabelValues();
        $element[$delta]['link_label'] = [
          '#type' => 'item',
          '#title' => $this->t('Link label'),
          '#markup' => $allowed_values[$item->link_label],
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

    }

    return $element;
  }

}
