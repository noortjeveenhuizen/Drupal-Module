<?php

namespace Drupal\thomas_more_ordering_form\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Ordering' Block.
 *
 * @Block(
 *   id = "thomas_more_ordering_form",
 *   admin_label = @Translation("Ordering form"),
 *   category = @Translation("Form"),
 * )
 */
class OrderingFormBlock extends BlockBase
{
    /**
     * {@inheritdoc}
     */
    public function build()
    {
        $OrderingForm = \Drupal::formBuilder()->getForm('Drupal\thomas_more_ordering_form\Form\FormOrderingForm');

        return [
            '#theme' => 'ordering-form',
            '#form' => $OrderingForm,
        ];
    }
}
