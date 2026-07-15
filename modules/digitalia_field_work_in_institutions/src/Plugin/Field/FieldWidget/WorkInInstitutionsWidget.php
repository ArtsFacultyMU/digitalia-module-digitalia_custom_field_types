<?php

declare(strict_types=1);

namespace Drupal\digitalia_field_work_in_institutions\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\digitalia_field_work_in_institutions\Plugin\Field\FieldType\WorkInInstitutionsItem;
use Symfony\Component\Validator\ConstraintViolationInterface;

/**
 * Defines the 'digitalia_field_work_in_institutions' field widget.
 *
 * @FieldWidget(
 *   id = "digitalia_field_work_in_institutions",
 *   label = @Translation("Work in Institutions"),
 *   field_types = {"digitalia_field_work_in_institutions"},
 * )
 */
final class WorkInInstitutionsWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state): array {

    $element['institution'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Institution'),
      '#default_value' => $items[$delta]->institution ?? NULL,
      '#size' => 50,
    ];


    $element['from'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('FROM'),
    ];

    $element['from']['from_day'] = [
      '#type' => 'select',
      '#title' => $this->t('Day'),
      '#options' => ['' => $this->t(' - ')] + WorkInInstitutionsItem::allowedFromDayValues(),
      '#default_value' => $items[$delta]->from_day ?? NULL,
    ];

    $element['from']['from_month'] = [
      '#type' => 'select',
      '#title' => $this->t('Month'),
      '#options' => ['' => $this->t(' - ')] + WorkInInstitutionsItem::allowedFromMonthValues(),
      '#default_value' => $items[$delta]->from_month ?? NULL,
    ];

    $element['from']['from_year'] = [
      '#type' => 'number',
      '#title' => $this->t('Year'),
      '#default_value' => $items[$delta]->from_year ?? NULL,
      '#size' => 4,
    ];

    $element['to'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('TO'),
    ];

    $element['to']['to_day'] = [
      '#type' => 'select',
      '#title' => $this->t('Day'),
      '#options' => ['' => $this->t(' - ')] + WorkInInstitutionsItem::allowedToDayValues(),
      '#default_value' => $items[$delta]->to_day ?? NULL,

    ];

    $element['to']['to_month'] = [
      '#type' => 'select',
      '#title' => $this->t('Month'),
      '#options' => ['' => $this->t(' - ')] + WorkInInstitutionsItem::allowedToMonthValues(),
      '#default_value' => $items[$delta]->to_month ?? NULL,
    ];

    $element['to']['to_year'] = [
      '#type' => 'number',
      '#title' => $this->t('Year'),
      '#default_value' => $items[$delta]->to_year ?? NULL,
      '#size' => 4,
    ];

    $element['position'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Position'),
      '#default_value' => $items[$delta]->position ?? NULL,
      '#size' => 50,
    ];

    $element['#theme_wrappers'] = ['container', 'form_element'];
    $element['#attributes']['class'][] = 'container-inline';
    $element['#attributes']['class'][] = 'digitalia-field-work-in-institutions-elements';
    $element['#attached']['library'][] = 'digitalia_field_work_in_institutions/digitalia_field_work_in_institutions';

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
      if ($value['institution'] === '') {
        $values[$delta]['institution'] = NULL;
      }
      if ($value['from']['from_day'] === '') {
        $values[$delta]['from']['from_day'] = NULL;
      }
      if ($value['from']['from_month'] === '') {
        $values[$delta]['from']['from_month'] = NULL;
      }
      if ($value['from']['from_year'] === '') {
        $values[$delta]['from']['from_year'] = NULL;
      }
      if ($value['to']['to_day'] === '') {
        $values[$delta]['to']['to_day'] = NULL;
      }
      if ($value['to']['to_month'] === '') {
        $values[$delta]['to']['to_month'] = NULL;
      }
      if ($value['to']['to_year'] === '') {
        $values[$delta]['to']['to_year'] = NULL;
      }
      if ($value['position'] === '') {
        $values[$delta]['position'] = NULL;
      }
    }
    return $values;
  }

}
