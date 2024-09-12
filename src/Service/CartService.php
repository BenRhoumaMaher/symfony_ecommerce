<?php

namespace App\Service;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    public function __construct(
        private ProductRepository $productRepository,
        private SessionInterface $session
    ) {
    }

    public function getCart(array $session = null): array
    {
        if ($session === null) {
            $session = $this->session;
        }

        $cart = $session->get('cart', []);
        $cartWithData = [];
        foreach ($cart as $id => $quantity) {
            $cartWithData[] = [
                'product' => $this->productRepository->find($id),
                'quantity' => $quantity
            ];
        }
        $total = array_sum(
            array_map(
                function ($item) {
                    return $item['product']->getPrice() * $item['quantity'];
                },
                $cartWithData
            )
        );
        return [
            'cart' => $cartWithData,
            'total' => $total
        ];
    }
    public function addToCart(int $id): void
    {
        $cartData = $this->session->get('cart', []);
        if (!isset($cartData[$id])) {
            $cartData[$id] = 1;
        } else {
            $cartData[$id]++;
        }
        $this->session->set('cart', $cartData);
    }

    public function removeFromCart(int $id): void
    {
        $cartData = $this->session->get('cart', []);
        unset($cartData[$id]);
        $this->session->set('cart', $cartData);
    }

    public function clearCart(): void
    {
        $this->session->set('cart', []);
    }
}