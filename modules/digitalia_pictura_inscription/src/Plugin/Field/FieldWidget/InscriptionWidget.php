<?php

declare(strict_types=1);

namespace Drupal\digitalia_pictura_inscription\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\digitalia_pictura_inscription\Plugin\Field\FieldType\InscriptionItem;
use Symfony\Component\Validator\ConstraintViolationInterface;

/**
 * Defines the 'digitalia_pictura_inscription' field widget.
 *
 * @FieldWidget(
 *   id = "digitalia_pictura_inscription",
 *   label = @Translation("Inscription"),
 *   field_types = {"digitalia_pictura_inscription"},
 * )
 */
final class InscriptionWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state): array {

    $element['text'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Text'),
      '#default_value' => $items[$delta]->text ?? NULL,
    ];

    $element['language'] = [
      '#type' => 'select',
      '#title' => $this->t('Language'),
      '#options' => ['' => $this->t('- None -')] + InscriptionItem::allowedLanguageValues(),
      '#default_value' => $items[$delta]->language ?? NULL,
    ];

    $element['en_translation'] = [
      '#type' => 'textarea',
      '#title' => $this->t('English translation'),
      '#default_value' => $items[$delta]->en_translation ?? NULL,
    ];

    $element['cs_translation'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Czech translation'),
      '#default_value' => $items[$delta]->cs_translation ?? NULL,
    ];

    $element['position'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Position'),
      '#default_value' => $items[$delta]->position ?? NULL,
    ];

    $element['author'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Author'),
      '#default_value' => $items[$delta]->author ?? NULL,
    ];

    $element['author_vocab'] = [
      '#type' => 'select',
      '#title' => $this->t('Author ID type'),
      '#options' => ['' => $this->t('- None -')] + InscriptionItem::allowedAuthorIDTypeValues(),
      '#default_value' => $items[$delta]->author_vocab ?? NULL,
    ];

    $element['author_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Author ID'),
      '#default_value' => $items[$delta]->author_id ?? NULL,
    ];

    $element['source'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Source'),
      '#default_value' => $items[$delta]->source ?? NULL,
    ];

    $element['source_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Source ID'),
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
    $element['#attributes']['class'][] = 'digitalia-pictura-inscription-elements';
    $element['#attached']['library'][] = 'digitalia_pictura_inscription/digitalia_pictura_inscription';

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
      if ($value['text'] === '') {
        $values[$delta]['text'] = NULL;
      }
      if ($value['language'] === '') {
        $values[$delta]['language'] = NULL;
      }
      if ($value['en_translation'] === '') {
        $values[$delta]['en_translation'] = NULL;
      }
      if ($value['cs_translation'] === '') {
        $values[$delta]['cs_translation'] = NULL;
      }
      if ($value['position'] === '') {
        $values[$delta]['position'] = NULL;
      }
      if ($value['author'] === '') {
        $values[$delta]['author'] = NULL;
      }
      if ($value['author_vocab'] === '') {
        $values[$delta]['author_vocab'] = NULL;
      }
      if ($value['author_id'] === '') {
        $values[$delta]['author_id'] = NULL;
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
