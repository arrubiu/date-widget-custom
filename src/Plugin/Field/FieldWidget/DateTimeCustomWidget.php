<?php

namespace Drupal\date_widget_custom\Plugin\Field\FieldWidget;
use Drupal\Core\Datetime;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\datetime\Plugin\Field\FieldWidget;

/**
 * Plugin implementation of the 'datetime_custom' widget.
 *
 * @FieldWidget(
 *   id = "datetime_custom",
 *   label = @Translation("Custom format"),
 *   field_types = {
 *     "datetime"
 *   },
 *   list_class = "\Drupal\datetime\Plugin\Field\FieldType\DateTimeFieldItemList",
 * )
 */
class DateTimeCustomWidget extends FieldWidget\DateTimeWidgetBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
      'custom_format' => 'm/d/Y',
    ) + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);

    $element['value'] = array(
        '#type' => 'datetime',
        '#date_time_element' => 'none',
        '#date_date_element' => 'text',
        '#date_date_format' => $this->getSetting('custom_format'),
      ) + $element['value'];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  function settingsForm(array $form, FormStateInterface $form_state) {
    $element = parent::settingsForm($form, $form_state);

    $element['custom_format'] = array(
      '#type' => 'textfield',
      '#title' => t('Custom format'),
      '#default_value' => $this->getSetting('custom_format'),
      '#description' => t('Insert a custom date format. See PHP <a href="@link">date()</a> documentation for details.', array('@link' => 'http://php.net/manual/en/function.date.php')),
    );

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = array();

    $summary[] = t('Format: @format', array('@format' => $this->getSetting('custom_format')));

    return $summary;
  }

}
