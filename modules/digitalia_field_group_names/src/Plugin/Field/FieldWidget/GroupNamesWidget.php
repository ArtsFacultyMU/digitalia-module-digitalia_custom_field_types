<?php

declare(strict_types=1);

namespace Drupal\digitalia_field_group_names\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\digitalia_field_group_names\Plugin\Field\FieldType\GroupNamesItem;
use Symfony\Component\Validator\ConstraintViolationInterface;

/**
 * Defines the 'digitalia_field_group_names' field widget.
 *
 * @FieldWidget(
 *   id = "digitalia_field_group_names",
 *   label = @Translation("Group names"),
 *   field_types = {"digitalia_field_group_names"},
 * )
 */
final class GroupNamesWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state): array {

    $element['name_category'] = [
      '#type' => 'select',
      '#title' => $this->t('Name category'),
      '#options' => ['' => $this->t('- None -')] + GroupNamesItem::allowedNameCategoryValues(),
      '#default_value' => $items[$delta]->name_category ?? NULL,
    ];

    $element['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#default_value' => $items[$delta]->name ?? NULL,
    ];

    $element['specification'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Specification'),
      '#default_value' => $items[$delta]->specification ?? NULL,
    ];

    $element['name_source'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Name source'),
      '#default_value' => $items[$delta]->name_source ?? NULL,
    ];

    $element['name_note'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Name note'),
      '#default_value' => $items[$delta]->name_note ?? NULL,
    ];

    $element['#theme_wrappers'] = ['container', 'form_element'];
    $element['#attributes']['class'][] = 'digitalia-field-group-names-elements';
    $element['#attached']['library'][] = 'digitalia_field_group_names/digitalia_field_group_names';

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
      if ($value['name_category'] === '') {
        $values[$delta]['name_category'] = NULL;
      }
      if ($value['name'] === '') {
        $values[$delta]['name'] = NULL;
      }
      if ($value['specification'] === '') {
        $values[$delta]['specification'] = NULL;
      }
      if ($value['name_source'] === '') {
        $values[$delta]['name_source'] = NULL;
      }
      if ($value['name_note'] === '') {
        $values[$delta]['name_note'] = NULL;
      }
    }
    return $values;
  }

}
