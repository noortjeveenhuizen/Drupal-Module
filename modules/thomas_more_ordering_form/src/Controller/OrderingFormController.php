<?php

namespace Drupal\thomas_more_ordering_form\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * An example controller.
 */
class OrderingFormController extends ControllerBase
{
    /**
     * Returns a render-able array for a test page.
     */
    public static function saveOrder($choose, $topping, $taste)
    {
        $result = \Drupal::database()->insert('ordering_form')
        ->fields([
            'choose' => $choose,
            'topping' => $topping,
            'taste' => $taste,
        ])->execute();

        return $result;
    }

    public static function getOrder($choose, $limit)
    {
        $database = \Drupal::database();
        $query = $database->select('ordering_form', 'o');
        $query->condition('choose', $choose, '=');
        $query->fields('o', ['choose', 'topping', 'taste']);
        $query->orderBy('id', 'DESC');
        $query->range(0, $limit);
        $orders = $query->execute()->fetchAll();

        return $orders;
    }
}
