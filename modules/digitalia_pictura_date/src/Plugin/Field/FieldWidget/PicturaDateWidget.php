<?php

declare(strict_types=1);

namespace Drupal\digitalia_pictura_date\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\digitalia_pictura_date\Plugin\Field\FieldType\PicturaDateItem;
use Symfony\Component\Validator\ConstraintViolationInterface;

/**
 * Defines the 'digitalia_pictura_date' field widget.
 *
 * @FieldWidget(
 *   id = "digitalia_pictura_date",
 *   label = @Translation("Pictura Date"),
 *   field_types = {"digitalia_pictura_date"},
 * )
 */
final class PicturaDateWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state): array {

    $element['date'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Date'),
      '#default_value' => $items[$delta]->date ?? NULL,
    ];

    $element['language'] = [
      '#type' => 'select',
      '#title' => $this->t('Language'),
      '#options' => ['' => $this->t('- None -')] + PicturaDateItem::allowedLanguageValues(),
      '#default_value' => $items[$delta]->language ?? NULL,
    ];

    $element['earliest_year'] = [
      '#type' => 'number',
      '#title' => $this->t('Earliest year'),
      '#default_value' => $items[$delta]->earliest_year ?? NULL,
    ];

    $element['latest_year'] = [
      '#type' => 'number',
      '#title' => $this->t('Latest year'),
      '#default_value' => $items[$delta]->latest_year ?? NULL,
    ];

    $element['date_type'] = [
      '#type' => 'select',
      '#title' => $this->t('Date type'),
      '#options' => ['' => $this->t('- Select a value -')] + PicturaDateItem::allowedDateTypeValues(),
      '#default_value' => $items[$delta]->date_type ?? NULL,
    ];

    $element['translations'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Translations'),
      '#default_value' => $items[$delta]->translations ?? NULL,
    ];

    $element['source_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Source ID'),
      '#default_value' => $items[$delta]->source_id ?? NULL,
    ];

    $element['source'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Source'),
      '#default_value' => $items[$delta]->source ?? NULL,
    ];

    $element['note'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Note'),
      '#default_value' => $items[$delta]->note ?? NULL,
    ];

    $element['system_note'] = [
      '#type' => 'textarea',
      '#title' => $this->t('System note'),
      '#default_value' => $items[$delta]->system_note ?? NULL,
    ];

    $element['#theme_wrappers'] = ['container', 'form_element'];
    $element['#attributes']['class'][] = 'digitalia-pictura-date-elements';
    $element['#attached']['library'][] = 'digitalia_pictura_date/digitalia_pictura_date';

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function errorElement(array $element, ConstraintViolationInterface $error, array $form, FormStateInterface $form_state): array|bool {
    $element = parent::errorElement($element, $error, $form, $form_state);
    if ($element === FALSE) {
      return FALSE;
    }
    $error_property = explode('.', $error->getPropertyPath())[1];
    return $element[$error_property];
  }

  /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state): array {
    foreach ($values as $delta => $value) {
      if ($value['date'] === '') {
        $values[$delta]['date'] = NULL;
      }
      if ($value['language'] === '') {
        $values[$delta]['language'] = NULL;
      }
      if ($value['earliest_year'] === '') {
        $values[$delta]['earliest_year'] = NULL;
      }
      if ($value['latest_year'] === '') {
        $values[$delta]['latest_year'] = NULL;
      }
      if ($value['date_type'] === '') {
        $values[$delta]['date_type'] = NULL;
      }
      if ($value['translations'] === '') {
        $values[$delta]['translations'] = NULL;
      }
      if ($value['source_id'] === '') {
        $values[$delta]['source_id'] = NULL;
      }
      if ($value['source'] === '') {
        $values[$delta]['source'] = NULL;
      }
      if ($value['note'] === '') {
        $values[$delta]['note'] = NULL;
      }
      if ($value['system_note'] === '') {
        $values[$delta]['system_note'] = NULL;
      }
    }
    return $values;
  }

}
