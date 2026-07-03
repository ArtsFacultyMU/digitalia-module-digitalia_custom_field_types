<?php

declare(strict_types=1);

namespace Drupal\digitalia_muni_pictura_nfields_title\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\digitalia_muni_pictura_nfields_title\Plugin\Field\FieldType\StructuredTitleItem;
use Symfony\Component\Validator\ConstraintViolationInterface;

/**
 * Defines the 'digitalia_muni_pictura_nfields_title' field widget.
 *
 * @FieldWidget(
 *   id = "digitalia_muni_pictura_nfields_title",
 *   label = @Translation("Structured title"),
 *   field_types = {"digitalia_muni_pictura_nfields_title"},
 * )
 */
final class StructuredTitleWidget extends WidgetBase {

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

    $element['title'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Title'),
      '#default_value' => $items[$delta]->title ?? NULL,
      '#rows' => 2,
    ];

    $element['title_type'] = [
      '#type' => 'select',
      '#title' => $this->t('Title type'),
      '#options' => ['' => $this->t('- Select a value -')] + StructuredTitleItem::allowedTitleTypeValues(),
      '#default_value' => $items[$delta]->title_type ?? NULL,
    ];

    $element['language'] = [
      '#type' => 'select',
      '#title' => $this->t('Language of title'),
      '#options' => ['' => $this->t('- Select a value -')] + StructuredTitleItem::allowedLanguageValues(),
      '#default_value' => $items[$delta]->language ?? NULL,
    ];

    /*
    $element['id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Internal Source ID'),
      '#default_value' => $items[$delta]->id ?? NULL,
    ];
    */

    $element['id_type'] = [
      '#type' => 'select',
      '#title' => $this->t('Source ID type'),
      '#options' => ['' => $this->t('- None -')] + StructuredTitleItem::allowedTitleIDTypeValues(),
      '#default_value' => $items[$delta]->id_type ?? NULL,
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
      '#rows' => 2,
    ];

    $element['note'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Note'),
      '#default_value' => $items[$delta]->note ?? NULL,
      '#rows' => 2,
    ];

    /*
    $element['system_note'] = [
      '#type' => 'textarea',
      '#title' => $this->t('System note'),
      '#default_value' => $items[$delta]->system_note ?? NULL,
    ];
    */

    $element['#theme_wrappers'] = ['container', 'form_element'];
    $element['#attributes']['class'][] = 'digitalia-muni-pictura-nfields-title-elements';
    $element['#attached']['library'][] = 'digitalia_muni_pictura_nfields_title/digitalia_muni_pictura_nfields_title';
    $element['#attached']['library'][] = 'digitalia_muni_pictura_nfields/editor';
    
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
      if ($value['title'] === '') {
        $values[$delta]['title'] = NULL;
      }
      if ($value['title_type'] === '') {
        $values[$delta]['title_type'] = NULL;
      }
      if ($value['language'] === '') {
        $values[$delta]['language'] = NULL;
      }
      if ($value['id'] === '') {
        $values[$delta]['id'] = NULL;
      }
      if ($value['id_type'] === '') {
        $values[$delta]['id_type'] = NULL;
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
