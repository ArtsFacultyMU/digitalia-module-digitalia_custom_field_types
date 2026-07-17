<?php

declare(strict_types=1);

namespace Drupal\digitalia_pictura_relation\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\digitalia_pictura_relation\Plugin\Field\FieldType\RelationItem;
use Symfony\Component\Validator\ConstraintViolationInterface;

/**
 * Defines the 'digitalia_pictura_relation' field widget.
 *
 * @FieldWidget(
 *   id = "digitalia_pictura_relation",
 *   label = @Translation("Relation"),
 *   field_types = {"digitalia_pictura_relation"},
 * )
 */
final class RelationWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state): array {

    $element['name'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Name'),
      '#default_value' => $items[$delta]->name ?? NULL,
    ];

    $element['type'] = [
      '#type' => 'select',
      '#title' => $this->t('Type'),
      '#options' => ['' => $this->t('- Select a value -')] + RelationItem::allowedTypeValues(),
      '#default_value' => $items[$delta]->type ?? NULL,
    ];

    $element['link'] = [
      '#type' => 'url',
      '#title' => $this->t('Link'),
      '#default_value' => $items[$delta]->link ?? NULL,
    ];

    $element['source'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Source'),
      '#default_value' => $items[$delta]->source ?? NULL,
    ];

    $element['source_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Value 5'),
      '#default_value' => $items[$delta]->source_id ?? NULL,
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
    $element['#attributes']['class'][] = 'digitalia-pictura-relation-elements';
    $element['#attached']['library'][] = 'digitalia_pictura_relation/digitalia_pictura_relation';

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
      if ($value['name'] === '') {
        $values[$delta]['name'] = NULL;
      }
      if ($value['type'] === '') {
        $values[$delta]['type'] = NULL;
      }
      if ($value['link'] === '') {
        $values[$delta]['link'] = NULL;
      }
      if ($value['source'] === '') {
        $values[$delta]['source'] = NULL;
      }
      if ($value['source_id'] === '') {
        $values[$delta]['source_id'] = NULL;
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
