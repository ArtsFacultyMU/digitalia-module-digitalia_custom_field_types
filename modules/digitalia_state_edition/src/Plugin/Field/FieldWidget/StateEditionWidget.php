<?php

declare(strict_types=1);

namespace Drupal\digitalia_state_edition\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\digitalia_state_edition\Plugin\Field\FieldType\StateEditionItem;
use Symfony\Component\Validator\ConstraintViolationInterface;

/**
 * Defines the 'digitalia_state_edition' field widget.
 *
 * @FieldWidget(
 *   id = "digitalia_state_edition",
 *   label = @Translation("State Edition"),
 *   field_types = {"digitalia_state_edition"},
 * )
 */
final class StateEditionWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state): array {

    $element['name'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Name'),
      '#default_value' => $items[$delta]->name ?? NULL,
    ];

    $element['description'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Description'),
      '#default_value' => $items[$delta]->description ?? NULL,
    ];

    $element['type'] = [
      '#type' => 'select',
      '#title' => $this->t('Type'),
      '#options' => ['' => $this->t('- None -')] + StateEditionItem::allowedTypeValues(),
      '#default_value' => $items[$delta]->type ?? NULL,
    ];

    $element['num'] = [
      '#type' => 'number',
      '#title' => $this->t('Number'),
      '#default_value' => $items[$delta]->num ?? NULL,
    ];

    $element['count'] = [
      '#type' => 'number',
      '#title' => $this->t('Count'),
      '#default_value' => $items[$delta]->count ?? NULL,
    ];

    $element['source'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Source'),
      '#default_value' => $items[$delta]->source ?? NULL,
      '#rows' => 2,
      '#attributes' => [
        'class' => ['digitalia-editor', 'quill-editor-initialized'],
      ],
    ];

    $element['source_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Source ID'),
      '#default_value' => $items[$delta]->source_id ?? NULL,
    ];
    /*
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
    */
    $element['#theme_wrappers'] = ['container', 'form_element'];
    $element['#attributes']['class'][] = 'digitalia-state-edition-elements';
    $element['#attached']['library'][] = 'digitalia_state_edition/digitalia_state_edition';
    $element['#attached']['library'][] = 'digitalia_custom_field_types/editor';

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
      if ($value['description'] === '') {
        $values[$delta]['description'] = NULL;
      }
      if ($value['type'] === '') {
        $values[$delta]['type'] = NULL;
      }
      if ($value['num'] === '') {
        $values[$delta]['num'] = NULL;
      }
      if ($value['count'] === '') {
        $values[$delta]['count'] = NULL;
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
