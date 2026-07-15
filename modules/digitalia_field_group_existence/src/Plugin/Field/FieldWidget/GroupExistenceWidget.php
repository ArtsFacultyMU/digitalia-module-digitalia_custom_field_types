<?php

declare(strict_types=1);

namespace Drupal\digitalia_field_group_existence\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\digitalia_field_group_existence\Plugin\Field\FieldType\GroupExistenceItem;
use Symfony\Component\Validator\ConstraintViolationInterface;

/**
 * Defines the 'digitalia_field_group_existence' field widget.
 *
 * @FieldWidget(
 *   id = "digitalia_field_group_existence",
 *   label = @Translation("Group existence"),
 *   field_types = {"digitalia_field_group_existence"},
 * )
 */
final class GroupExistenceWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state): array {

    $element['existence_type'] = [
      '#type' => 'select',
      '#title' => $this->t('Type of existence'),
      '#options' => ['' => $this->t('- None -')] + GroupExistenceItem::allowedTypeOfExistenceValues(),
      '#default_value' => $items[$delta]->existence_type ?? NULL,
    ];

    $element['from'] = [
      '#type' => 'number',
      '#title' => $this->t('From'),
      '#default_value' => $items[$delta]->from ?? NULL,
    ];

    $element['to'] = [
      '#type' => 'number',
      '#title' => $this->t('To'),
      '#default_value' => $items[$delta]->to ?? NULL,
    ];

    $element['#theme_wrappers'] = ['container', 'form_element'];
    $element['#attributes']['class'][] = 'container-inline';
    $element['#attributes']['class'][] = 'digitalia-field-group-existence-elements';
    $element['#attached']['library'][] = 'digitalia_field_group_existence/digitalia_field_group_existence';

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
      if ($value['existence_type'] === '') {
        $values[$delta]['existence_type'] = NULL;
      }
      if ($value['from'] === '') {
        $values[$delta]['from'] = NULL;
      }
      if ($value['to'] === '') {
        $values[$delta]['to'] = NULL;
      }
    }
    return $values;
  }

}
