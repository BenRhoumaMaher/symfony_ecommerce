<?php

/**
 * RandomProductListener
 *
 * Listens for the event that triggers the display of a random product.
 *
 * This class handles the `RandomProductDisplayEvent` to process and return product details as JSON data.
 *
 * @category EventListeners
 * @package  App\EventListener
 * @author   Maher Ben Rhouma <maherbenrhoumaaa@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/event_dispatcher.html
 */

namespace App\EventListener;

use App\Event\RandomProductDisplayEvent;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * RandomProductListener
 *
 * Listens for the event that triggers the display of a random product.
 *
 * This class handles the `RandomProductDisplayEvent` to process and return product details as JSON data.
 *
 * @category EventListeners
 * @package  App\EventListener
 * @author   Maher Ben Rhouma <maherbenrhoumaaa@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/event_dispatcher.html
 */
class RandomProductListener
{
    /**
     * Handles the event for displaying a random product.
     *
     * This method processes the `RandomProductDisplayEvent` to extract product details and return them as JSON data.
     *
     * @param RandomProductDisplayEvent $event The event object containing the random product.
     *
     * @return JsonResponse             A JSON response containing the details of the product.
     */
    public function onRandomProductDisplay(RandomProductDisplayEvent $event)
    {
        $product = $event->getProduct();

        return new JsonResponse(
            [
            'name' => $product->getName(),
            'description' => $product->getDescription(),
            'price' => $product->getPrice(),
            'image' => $product->getImage(), ]
        );
    }
}
