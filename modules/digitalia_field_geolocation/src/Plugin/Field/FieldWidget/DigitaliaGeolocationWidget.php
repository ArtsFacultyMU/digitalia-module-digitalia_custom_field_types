<?php

declare(strict_types=1);

namespace Drupal\digitalia_field_geolocation\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\digitalia_field_geolocation\Plugin\Field\FieldType\DigitaliaGeolocationItem;
use Symfony\Component\Validator\ConstraintViolationInterface;

/**
 * Defines the 'digitalia_field_geolocation' field widget.
 *
 * @FieldWidget(
 *   id = "digitalia_field_geolocation",
 *   label = @Translation("Digitalia Geolocation"),
 *   field_types = {"digitalia_field_geolocation"},
 * )
 */
final class DigitaliaGeolocationWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings(): array {
    return ['display_type' => FALSE] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state): array {
    $element['display_type'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Display type'),
      '#default_value' => $this->getSetting('display_type'),
      '#return_value' => 1,
      '#description' => $this->t('If checked, type field will be displayed.'),
    ];
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary(): array {
    return [
      $this->t('Display type: @type_value', ['@type_value' => $this->getSetting('display_type')]),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state): array {
    $schema = $this->fieldDefinition->getSetting('allowed_type_schema') ?? '';
    switch ($schema) {
      case "VRA":
        $allowed_type_values = DigitaliaGeolocationItem::allowedVraTypeValues();
        break;
      case "CCMM":
        $allowed_type_values = DigitaliaGeolocationItem::allowedCcmmTypeValues();
        break;
      case "custom":
        $allowed_type_values = DigitaliaGeolocationItem::formatAllowedTypeValues($this->fieldDefinition->getSetting('allowed_type_custom_values') ?? '');
        break;
      default:
        $allowed_type_values = [];
        break;
    }

    if (filter_var($this->getSetting('display_type'), FILTER_VALIDATE_BOOLEAN)) {
      $element['type'] = [
        '#type' => 'select',
        '#title' => $this->t('Type'),
        '#options' => ['' => $this->t('- None -')] + $allowed_type_values,
        '#default_value' => $items[$delta]->type ?? NULL,
      ];
    }

    $element['place'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Place'),
      '#default_value' => $items[$delta]->place ?? NULL,
    ];

    $element['url'] = [
      '#type' => 'url',
      '#title' => $this->t('GeoNames URL'),
      '#default_value' => $items[$delta]->url ?? NULL,
    ];

    $element['country'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Country'),
      '#default_value' => $items[$delta]->country ?? NULL,
      '#disabled' => TRUE,
    ];

    $element['adm1'] = [
      '#type' => 'textfield',
      '#title' => $this->t('adm1'),
      '#default_value' => $items[$delta]->adm1 ?? NULL,
      '#disabled' => TRUE,
    ];

    $element['adm2'] = [
      '#type' => 'textfield',
      '#title' => $this->t('adm2'),
      '#default_value' => $items[$delta]->adm2 ?? NULL,
      '#disabled' => TRUE,
    ];

    $element['adm3'] = [
      '#type' => 'textfield',
      '#title' => $this->t('adm3'),
      '#default_value' => $items[$delta]->adm3 ?? NULL,
      '#disabled' => TRUE,
    ];

    $element['adm4'] = [
      '#type' => 'textfield',
      '#title' => $this->t('adm4'),
      '#default_value' => $items[$delta]->adm4 ?? NULL,
      '#disabled' => TRUE,
    ];

    $element['adm5'] = [
      '#type' => 'textfield',
      '#title' => $this->t('adm5'),
      '#default_value' => $items[$delta]->adm5 ?? NULL,
      '#disabled' => TRUE,
    ];

    $element['lat'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Lat'),
      '#default_value' => $items[$delta]->lat ?? NULL,
      '#disabled' => TRUE,
    ];

    $element['long'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Long'),
      '#default_value' => $items[$delta]->long ?? NULL,
      '#disabled' => TRUE,
    ];

    $element['note'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Note'),
      '#default_value' => $items[$delta]->note ?? NULL,
      '#rows' => 2,
    ];
    /*
    $element['note_system'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Note system'),
      '#default_value' => $items[$delta]->note_system ?? NULL,
      '#rows' => 2,
    ];
    */
    $element['#theme_wrappers'] = ['container', 'form_element'];
    $element['#attributes']['class'][] = 'digitalia-field-geolocation-elements';
    $element['#attached']['library'][] = 'digitalia_field_geolocation/digitalia_field_geolocation';

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
      if ($value['type'] === '') {
        $values[$delta]['type'] = NULL;
      }
      if ($value['place'] === '') {
        $values[$delta]['place'] = NULL;
      }
      if ($value['url'] === '') {
        $values[$delta]['url'] = NULL;
      }
      if ($value['country'] === '') {
        $values[$delta]['country'] = NULL;
      }
      if ($value['adm1'] === '') {
        $values[$delta]['adm1'] = NULL;
      }
      if ($value['adm2'] === '') {
        $values[$delta]['adm2'] = NULL;
      }
      if ($value['adm3'] === '') {
        $values[$delta]['adm3'] = NULL;
      }
      if ($value['adm4'] === '') {
        $values[$delta]['adm4'] = NULL;
      }
      if ($value['adm5'] === '') {
        $values[$delta]['adm5'] = NULL;
      }
      if ($value['lat'] === '') {
        $values[$delta]['lat'] = NULL;
      }
      if ($value['long'] === '') {
        $values[$delta]['long'] = NULL;
      }
      if ($value['note'] === '') {
        $values[$delta]['note'] = NULL;
      }
      if ($value['note_system'] === '') {
        $values[$delta]['note_system'] = NULL;
      }
    }
    return $values;
  }

}
