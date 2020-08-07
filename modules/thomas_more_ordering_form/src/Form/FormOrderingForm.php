<?php

namespace Drupal\thomas_more_ordering_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\thomas_more_ordering_form\Controller\OrderingFormController;

class FormOrderingForm extends FormBase
{
    public function getFormId()
    {
        return 'thomas_more_ordering_form_settings';
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form['choose'] = [
            '#type' => 'select',
            '#title' => $this->t('Choose'),
            '#options' => [
                'iceCream' => $this->t('Ice'),
                'waffles' => $this->t('Waffles'),
              ],
        ];

        $form['taste'] = [
            '#type' => 'select',
            '#title' => $this->t('taste'),
            '#options' => [
                'choco' => $this->t('Choco'),
                'vanille' => $this->t('Vanille'),
              ],
            '#states' => [
                'invisible' => [
                  ':input[name="choose"]' => ['value' => 'waffles'],
                ],
                'visible' => [
                  ':input[name="choose"]' => ['value' => 'iceCream'],
                ],
            ],
        ];

        $form['topping'] = [
            '#type' => 'select',
            '#title' => $this->t('topping'),
            '#options' => [
                'cream' => $this->t('Cream'),
                'nuts' => $this->t('Nuts'),
                'choco' => $this->t('Choco'),
              ],
            '#states' => [
                'invisible' => [
                  ':input[name="choose"]' => ['value' => 'iceCream'],
                ],
                'visible' => [
                  ':input[name="choose"]' => ['value' => 'waffles'],
                ],
            ],
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
        if ($form_state->getValue('choose') === 'waffles') {
            OrderingFormController::saveOrder($form_state->getValue('choose'), $form_state->getValue('topping'), '');
            $counterWaffles = \Drupal::state()->get('counter_waffles');
            ++$counterWaffles;
            \Drupal::state()->set('counter_waffles', $counterWaffles);
            if ($counterWaffles >= \Drupal::state()->get('waffles')) {
                $orderWaffles = OrderingFormController::getOrder('waffles', \Drupal::state()->get('waffles'));
                $counterWaffles = 0;
                \Drupal::state()->set('counter_waffles', $counterWaffles);
                $number = 0;
                foreach ($orderWaffles as $order) {
                    ++$number;
                    $this->messenger()->addStatus($this->t($number.'@order', ['@order' => $order->topping]));
                }
            } else {
                $ordersNeeded = \Drupal::state()->get('waffles') - $counterWaffles;
                $this->messenger()->addStatus($this->t('@todo more orders needed ', ['@todo' => $ordersNeeded]));
            }
        } elseif ($form_state->getValue('choose') === 'iceCream') {
            OrderingFormController::saveOrder($form_state->getValue('choose'), '', $form_state->getValue('taste'));
            $counterIce = \Drupal::state()->get('counter_ice');
            ++$counterIce;
            \Drupal::state()->set('counter_ice', $counterIce);
            if ($counterIce >= \Drupal::state()->get('iceCream')) {
                $orderIce = OrderingFormController::getOrder('iceCream', \Drupal::state()->get('iceCream'));
                $counterIce = 0;
                \Drupal::state()->set('counter_ice', $counterIce);
                $number = 0;
                foreach ($orderIce as $order) {
                    ++$number;
                    $this->messenger()->addStatus($this->t($number.'@order', ['@order' => $order->taste]));
                }
            } else {
                $ordersNeeded = \Drupal::state()->get('iceCream') - $counterIce;
                $this->messenger()->addStatus($this->t('@todo more orders needed ', ['@todo' => $ordersNeeded]));
            }
        }
    }
}
