<?php

declare(strict_types=1);

namespace Drupal\digitalia_field_links\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\digitalia_field_links\Plugin\Field\FieldType\LinksItem;
use Symfony\Component\Validator\ConstraintViolationInterface;

/**
 * Defines the 'digitalia_field_links' field widget.
 *
 * @FieldWidget(
 *   id = "digitalia_field_links",
 *   label = @Translation("Links"),
 *   field_types = {"digitalia_field_links"},
 * )
 */
final class LinksWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state): array {

    $element['link_type'] = [
      '#type' => 'select',
      '#title' => $this->t('Link type'),
      '#options' => ['' => $this->t('- None -')] + LinksItem::allowedLinkTypeValues(),
      '#default_value' => $items[$delta]->link_type ?? NULL,
    ];

    $element['link_label'] = [
      '#type' => 'select',
      '#title' => $this->t('Link label'),
      '#options' => ['' => $this->t('- None -')] + LinksItem::allowedLinkLabelValues(),
      '#default_value' => $items[$delta]->link_label ?? NULL,
    ];

    $element['url'] = [
      '#type' => 'url',
      '#title' => $this->t('URL'),
      '#default_value' => $items[$delta]->url ?? NULL,
      '#size' => 20,
    ];

    $element['#theme_wrappers'] = ['container', 'form_element'];
    $element['#attributes']['class'][] = 'container-inline';
    $element['#attributes']['class'][] = 'digitalia-field-links-elements';
    $element['#attached']['library'][] = 'digitalia_field_links/digitalia_field_links';

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
      if ($value['link_type'] === '') {
        $values[$delta]['link_type'] = NULL;
      }
      if ($value['link_label'] === '') {
        $values[$delta]['link_label'] = NULL;
      }
      if ($value['url'] === '') {
        $values[$delta]['url'] = NULL;
      }
    }
    return $values;
  }

}
