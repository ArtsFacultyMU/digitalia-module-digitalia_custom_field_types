<?php

declare(strict_types=1);

namespace Drupal\digitalia_field_group_localization\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\digitalia_field_group_localization\Plugin\Field\FieldType\GroupLocalizationItem;
use Symfony\Component\Validator\ConstraintViolationInterface;

/**
 * Defines the 'digitalia_field_group_localization' field widget.
 *
 * @FieldWidget(
 *   id = "digitalia_field_group_localization",
 *   label = @Translation("Group localization"),
 *   field_types = {"digitalia_field_group_localization"},
 * )
 */
final class GroupLocalizationWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state): array {

    $element['localization_type'] = [
      '#type' => 'select',
      '#title' => $this->t('Localization type'),
      '#options' => ['' => $this->t('- None -')] + GroupLocalizationItem::allowedLocalizationTypeValues(),
      '#default_value' => $items[$delta]->localization_type ?? NULL,
    ];

    $element['place'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Place'),
      '#default_value' => $items[$delta]->place ?? NULL,
    ];

    $element['identifier_scheme'] = [
      '#type' => 'select',
      '#title' => $this->t('Identifier scheme'),
      '#options' => ['' => $this->t('- None -')] + GroupLocalizationItem::allowedIdentifierSchemeValues(),
      '#default_value' => $items[$delta]->identifier_scheme ?? NULL,
    ];

    $element['identifier'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Identifier'),
      '#default_value' => $items[$delta]->identifier ?? NULL,
    ];

    $element['localization_note'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Localization note'),
      '#default_value' => $items[$delta]->localization_note ?? NULL,
    ];

    $element['#theme_wrappers'] = ['container', 'form_element'];
    $element['#attributes']['class'][] = 'digitalia-field-group-localization-elements';
    $element['#attached']['library'][] = 'digitalia_field_group_localization/digitalia_field_group_localization';

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
      if ($value['localization_type'] === '') {
        $values[$delta]['localization_type'] = NULL;
      }
      if ($value['place'] === '') {
        $values[$delta]['place'] = NULL;
      }
      if ($value['identifier_scheme'] === '') {
        $values[$delta]['identifier_scheme'] = NULL;
      }
      if ($value['identifier'] === '') {
        $values[$delta]['identifier'] = NULL;
      }
      if ($value['localization_note'] === '') {
        $values[$delta]['localization_note'] = NULL;
      }
    }
    return $values;
  }

}
