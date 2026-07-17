<?php

declare(strict_types=1);

namespace Drupal\digitalia_pictura_description\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\digitalia_pictura_description\Plugin\Field\FieldType\DescriptionItem;
use Symfony\Component\Validator\ConstraintViolationInterface;

/**
 * Defines the 'digitalia_pictura_description' field widget.
 *
 * @FieldWidget(
 *   id = "digitalia_pictura_description",
 *   label = @Translation("Description"),
 *   field_types = {"digitalia_pictura_description"},
 * )
 */
final class DescriptionWidget extends WidgetBase {

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
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state): array {

    $element['description'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Description'),
      '#default_value' => $items[$delta]->description ?? NULL,
      '#rows' => 5,
      '#attributes' => [
        'class' => ['quill-editor-initialized'],
      ],
    ];

    $element['language'] = [
      '#type' => 'select',
      '#title' => $this->t('Language'),
      '#options' => ['' => $this->t('- Select a value -')] + DescriptionItem::allowedLanguageValues(),
      '#default_value' => $items[$delta]->language ?? NULL,
    ];

    $element['source'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Source'),
      '#default_value' => $items[$delta]->source ?? NULL,
      '#rows' => 2,
      '#attributes' => [
        'class' => ['quill-editor-initialized'],
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
      '#rows' => 2,
    ];

    $element['system_note'] = [
      '#type' => 'textarea',
      '#title' => $this->t('System note'),
      '#default_value' => $items[$delta]->system_note ?? NULL,
    ];
    */

    $element['#theme_wrappers'] = ['container', 'form_element'];
    $element['#attributes']['class'][] = 'digitalia-pictura-description-elements';
    $element['#attached']['library'][] = 'digitalia_pictura_description/digitalia_pictura_description';
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
      if ($value['description'] === '') {
        $values[$delta]['description'] = NULL;
      }
      if ($value['language'] === '') {
        $values[$delta]['language'] = NULL;
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
