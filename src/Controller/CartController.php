<?php

/**
 * CartController
 *
 * Handles cart-related actions such as viewing the cart contents,
 * adding items to the cart, and removing items from the cart.
 *
 * @category Controllers
 * @package  App\Controller\Cart
 * @author   Maher Ben Rhouma <maherbenrhoumaaa@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 */

namespace App\Controller;

use App\Service\CartService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * CartController
 *
 * Handles cart-related actions such as viewing the cart contents,
 * adding items to the cart, and removing items from the cart.
 *
 * @category Controllers
 * @package  App\Controller\Cart
 * @author   Maher Ben Rhouma <maherbenrhoumaaa@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 */
class CartController extends AbstractController
{
    /**
     * Displays the current state of the shopping cart.
     *
     * Fetches the cart data from the session, retrieves the cart products,
     * and passes them to the Twig template for rendering.
     *
     * @param CartService $cartService The cart service to manage cart operations.

     * @return Response        A Symfony Response object that renders the cart view.
     */
    #[Route('/{_locale<%app.supported_locales%>}/cart', name: 'app_cart', methods: ['GET'])]
    public function index(CartService $cartService): Response
    {
        return $this->render(
            'cart/index.html.twig',
            [
                'items' => $cartService->getCartItems(),
                'total' => $cartService->getTotal(),
            ]
        );
    }

    /**
     * Adds a product to the cart.
     *
     * Increases the quantity of a product in the cart by 1 or adds the product
     * to the cart if it doesn't exist yet.
     *
     * @param int         $id          The ID of the product to add to the cart.
     * @param CartService $cartService The cart service to manage cart operations.

     * @return Response Redirects to the cart page after updating the cart.
     */
    #[Route('/{_locale<%app.supported_locales%>}/cart/add/{id}/', name: 'app_cart_new', methods: ['GET'])]
    public function addToCart(int $id, CartService $cartService): Response
    {
        $cartService->addToCart($id);
        return $this->redirectToRoute('app_cart');
    }

    /**
     * Removes a product from the cart.
     *
     * Decreases the quantity of a product in the cart by 1 or removes the product
     * from the cart if its quantity reaches 0.
     *
     * @param int         $id          The ID of the product to remove from the cart.
     * @param CartService $cartService The cart service to manage cart operations.

     * @return Response Redirects to the cart page after updating the cart.
     */
    #[Route('/{_locale<%app.supported_locales%>}/cart/remove/{id}/', name: 'app_cart_product_remove', methods: ['GET'])]
    public function removeToCart(
        int $id,
        CartService $cartService
    ): Response {
        $cartService->removeFromCart($id);
        return $this->redirectToRoute('app_cart');
    }

    /**
     * Clears the entire cart.
     *
     * Empties the cart stored in the session.
     *
     * @param CartService $cartService The cart service to manage cart operations.

     * @return Response Redirects to the cart page after updating the cart.      $cartService The cart service to manage cart operations.
     */
    #[Route('/{_locale<%app.supported_locales%>}/cart/remove/', name: 'app_cart_remove', methods: ['GET'])]
    public function remove(CartService $cartService): Response
    {
        $cartService->clearCart();
        return $this->redirectToRoute('app_cart');
    }
}