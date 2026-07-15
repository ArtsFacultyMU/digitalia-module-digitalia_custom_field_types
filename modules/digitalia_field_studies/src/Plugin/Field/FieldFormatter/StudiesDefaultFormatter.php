<?php

declare(strict_types=1);

namespace Drupal\digitalia_field_studies\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\digitalia_field_studies\Plugin\Field\FieldType\StudiesItem;

/**
 * Plugin implementation of the 'digitalia_field_studies_default' formatter.
 *
 * @FieldFormatter(
 *   id = "digitalia_field_studies_default",
 *   label = @Translation("Default"),
 *   field_types = {"digitalia_field_studies"},
 * )
 */
final class StudiesDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $element = [];

    foreach ($items as $delta => $item) {

      if ($item->institution) {
        $element[$delta]['institution'] = [
          '#type' => 'item',
          '#title' => $this->t('Institution'),
          '#markup' => $item->institution,
        ];
      }

      if ($item->from_day) {
        $allowed_values = StudiesItem::allowedFromDayValues();
        $element[$delta]['from_day'] = [
          '#type' => 'item',
          '#title' => $this->t('From (day)'),
          '#markup' => $allowed_values[$item->from_day],
        ];
      }

      if ($item->from_month) {
        $allowed_values = StudiesItem::allowedFromMonthValues();
        $element[$delta]['from_month'] = [
          '#type' => 'item',
          '#title' => $this->t('From (month)'),
          '#markup' => $allowed_values[$item->from_month],
        ];
      }

      if ($item->from_year) {
        $element[$delta]['from_year'] = [
          '#type' => 'item',
          '#title' => $this->t('From (year)'),
          '#markup' => $item->from_year,
        ];
      }

      if ($item->to_day) {
        $allowed_values = StudiesItem::allowedToDayValues();
        $element[$delta]['to_day'] = [
          '#type' => 'item',
          '#title' => $this->t('To (day)'),
          '#markup' => $allowed_values[$item->to_day],
        ];
      }

      if ($item->to_month) {
        $allowed_values = StudiesItem::allowedToMonthValues();
        $element[$delta]['to_month'] = [
          '#type' => 'item',
          '#title' => $this->t('To (month)'),
          '#markup' => $allowed_values[$item->to_month],
        ];
      }

      if ($item->to_year) {
        $element[$delta]['to_year'] = [
          '#type' => 'item',
          '#title' => $this->t('To (year)'),
          '#markup' => $item->to_year,
        ];
      }

      if ($item->specialization) {
        $element[$delta]['specialization'] = [
          '#type' => 'item',
          '#title' => $this->t('Specialization'),
          '#markup' => $item->specialization,
        ];
      }

    }

    return $element;
  }

}
