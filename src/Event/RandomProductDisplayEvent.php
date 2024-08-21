<?php

/**
 * RandomProductDisplayEvent
 *
 * Represents an event for displaying a random product.
 *
 * @category Events
 * @package  App\Event
 * @author   Maher Ben Rhouma <maherbenrhoumaaa@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/events.html
 */

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

/**
 * RandomProductDisplayEvent
 *
 * Represents an event for displaying a random product.
 *
 * @category Events
 * @package  App\Event
 * @author   Maher Ben Rhouma <maherbenrhoumaaa@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/events.html
 */
class RandomProductDisplayEvent extends Event
{
    public const NAME = 'random.product.display';

    private $product;

    /**
     * Constructor.
     *
     * Initializes the event with a product.
     *
     * @param mixed $product The product associated with the event. This can be any object representing a product.
     */
    public function __construct($product)
    {
        $this->product = $product;
    }

    /**
     * Gets the product associated with the event.
     *
     * @return mixed The product associated with the event.
     */
    public function getProduct()
    {
        return $this->product;
    }
}
