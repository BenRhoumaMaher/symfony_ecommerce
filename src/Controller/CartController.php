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

use App\Repository\ProductRepository;
use App\Service\Cart;
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
     * Constructor to inject the ProductRepository.
     *
     * @param ProductRepository $productRepository The product repository service.
     */
    public function __construct(
        private readonly ProductRepository $productRepository
    ) {
    }

    /**
     * Displays the current state of the shopping cart.
     *
     * Fetches the cart data from the session, retrieves the cart products,
     * and passes them to the Twig template for rendering.
     *
     * @param SessionInterface $session The session interface to access session data.
     * @param Cart             $cart    The cart service to manage cart operations.

     * @return Response        A Symfony Response object that renders the cart view.
     */
    #[Route('/{_locale<%app.supported_locales%>}/cart', name: 'app_cart', methods: ['GET'])]
    public function index(SessionInterface $session, Cart $cart): Response
    {
        $data = $cart->getCart($session);
        $cartProducts = $data['cart'];
        // $products = [];
        // foreach ($cartProducts as $value) {

        // }
        return $this->render(
            'cart/index.html.twig',
            [
                'items' => $data['cart'],
                'total' => $data['total']
            ]
        );
    }

    /**
     * Adds a product to the cart.
     *
     * Increases the quantity of a product in the cart by 1 or adds the product
     * to the cart if it doesn't exist yet.
     *
     * @param int              $id      The ID of the product to add to the cart.
     * @param SessionInterface $session The session interface to access session data.

     * @return Response Redirects to the cart page after updating the cart.
     */
    #[Route('/{_locale<%app.supported_locales%>}/cart/add/{id}/', name: 'app_cart_new', methods: ['GET'])]
    public function addToCart(int $id, SessionInterface $session): Response
    {
        $cart = $session->get('cart', []);
        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }
        $session->set('cart', $cart);
        return $this->redirectToRoute('app_cart');
    }

    /**
     * Removes a product from the cart.
     *
     * Decreases the quantity of a product in the cart by 1 or removes the product
     * from the cart if its quantity reaches 0.
     *
     * @param int              $id      The ID of the product to remove
     *                                  from the cart.
     * @param SessionInterface $session The session interface to access session data.

     * @return Response Redirects to the cart page after updating the cart.
     */
    #[Route('/{_locale<%app.supported_locales%>}/cart/remove/{id}/', name: 'app_cart_product_remove', methods: ['GET'])]
    public function removeToCart($id, SessionInterface $session): Response
    {
        $cart = $session->get('cart', []);
        if (!empty(($cart[$id]))) {
            unset($cart[$id]);
        }
        $session->set('cart', $cart);
        return $this->redirectToRoute('app_cart');
    }

    /**
     * Clears the entire cart.
     *
     * Empties the cart stored in the session.
     *
     * @param SessionInterface $session The session interface to access session data.

     * @return Response        Redirects to the cart page after clearing the cart.
     */
    #[Route('/{_locale<%app.supported_locales%>}/cart/remove/', name: 'app_cart_remove', methods: ['GET'])]
    public function remove(SessionInterface $session): Response
    {
        $session->set('cart', []);
        return $this->redirectToRoute('app_cart');
    }
}
