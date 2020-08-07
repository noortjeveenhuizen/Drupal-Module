<?php

namespace Drupal\thomas_more_ordering_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class SettingsOrderingForm extends FormBase
{
    public function getFormId()
    {
        return 'thomas_more_ordering_form_admin';
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form['iceCream'] = [
            '#type' => 'number',
            '#title' => $this->t('Minimum amount of ice cream'),
            '#default_value' => \Drupal::state()->get('iceCream'),
        ];

        $form['waffles'] = [
            '#type' => 'number',
            '#title' => $this->t('Minimum amount of waffles'),
            '#default_value' => \Drupal::state()->get('waffles'),
        ];

        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = [
           '#type' => 'submit',
           '#value' => $this->t('Save'),
           '#button_type' => 'primary',
       ];

        return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        \Drupal::state()->set('iceCream', $form_state->getValue('iceCream'));
        \Drupal::state()->set('waffles', $form_state->getValue('waffles'));
    }
}
