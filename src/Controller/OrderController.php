<?php

/**
 * OrderController
 *
 * Handles orders, including placing new orders, viewing all orders, marking orders as completed,
 * removing orders, and calculating shipping costs.
 *
 * @category Controllers
 * @package  App\Controller\Order
 * @author   Maher Ben Rhouma <maherbenrhoumaaa@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 */

namespace App\Controller;

use App\Entity\City;
use App\Entity\Order;
use App\Service\Cart;
use DateTimeImmutable;
use App\Form\OrderType;
use App\Entity\OrderProducts;
use App\Service\StripePayment;
use Symfony\Component\Mime\Email;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * OrderController
 *
 * Handles orders, including placing new orders, viewing all orders, marking orders as completed,
 * removing orders, and calculating shipping costs.
 *
 * @category Controllers
 * @package  App\Controller\Order
 * @author   Maher Ben Rhouma <maherbenrhoumaaa@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 */
class OrderController extends AbstractController
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    /**
     * Displays the order form and processes the order submission.
     *
     * @param Request                $request           The current HTTP request.
     * @param SessionInterface       $session           The session object to manage cart data.
     * @param ProductRepository      $productRepository The repository to fetch products from the database.
     * @param EntityManagerInterface $entityManager     The entity manager to persist entities.
     * @param Cart                   $cart              The shopping cart service.
     * @param OrderRepository        $orderRepository   The repository to fetch orders from the database.

     * @return Response Renders the order form and processes the order submission.
     */
    #[Route('/order', name: 'app_order')]
    public function index(
        Request $request,
        SessionInterface $session,
        ProductRepository $productRepository,
        EntityManagerInterface $entityManager,
        Cart $cart,
        OrderRepository $orderRepository
    ): Response {

        $data = $cart->getCart($session);

        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (!empty($data['total'])) {
                $totalPrice = $data['total'] + $order->getCity()->getShippingCost();
                $order->setTotalPrice($totalPrice);
                $order->setCreatedAt(new DateTimeImmutable());
                $entityManager->persist($order);
                $entityManager->flush();

                foreach ($data['cart'] as $value) {
                    $orderProduct = new OrderProducts();
                    $orderProduct->setOrder($order);
                    $orderProduct->setProduct($value['product']);
                    $orderProduct->setQte($value['quantity']);
                    $entityManager->persist($orderProduct);
                }
                $entityManager->flush();
                if ($order->isPayOnDelivery()) {
                    $session->set('cart', []);

                    $entityManager->refresh($order);

                    $html = $this->renderView(
                        'mail/orderConfirm.html.twig',
                        [
                            'order' => $order,
                        ]
                    );
                    $email = (new Email())
                        ->from('M&CodeShop@gmail.com')
                        ->to($order->getEmail())
                        ->subject('Confirmation de commande')
                        ->html($html);
                    $this->mailer->send($email);
                    return $this->redirectToRoute('order_ok_message');
                }
                $payment = new StripePayment();
                $shippingCost = $order->getCity()->getShippingCost();
                $payment->startPayment($data, $shippingCost, $order->getId());
                $stripeRedirectUrl = $payment->getStripeRedirectUrl();
                return $this->redirect($stripeRedirectUrl);
            }
        }

        return $this->render(
            'order/index.html.twig',
            [
                'form' => $form->createView(),
                'total' => $data['total'],
            ]
        );
    }

    /**
     * Retrieves all orders based on completion status.
     *
     * @param string             $type            The type of orders to retrieve ('is-completed' or 'is-not-completed').
     * @param OrderRepository    $orderRepository The repository to fetch orders from the database.
     * @param Request            $request         The current HTTP request.
     * @param PaginatorInterface $paginator       The paginator service to paginate the orders.

     * @return Response Renders the list of orders based on the specified type.
     */

    #[Route("/editor/order/{type}", name: 'app_orders_show')]
    public function getAllOrder($type, OrderRepository $orderRepository, Request $request, PaginatorInterface $paginator): Response
    {
        if ($type === 'is-completed') {
            $data = $orderRepository->findBy(
                ['isCompleted' => 1],
                ['id' => 'ASC']
            );
        } elseif ($type === 'is-not-completed') {
            $data = $orderRepository->findBy(
                ['isCompleted' => null],
                ['id' => 'ASC']
            );
        }
        $order = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render(
            'order/order.html.twig',
            [
                'orders' => $order,
            ]
        );
    }

    /**
     * Marks an order as completed.
     *
     * @param int                    $id              The ID of the order to mark as completed.
     * @param OrderRepository        $orderRepository The repository to fetch orders from the database.
     * @param EntityManagerInterface $entityManager   The entity manager to persist entities.
     * @param Request                $request         The current HTTP request.

     * @return Response Redirects back to the referring page with a success flash message.
     */
    #[Route('/editor/order/{id}/is-completed/update', name: 'app_orders_is_completed_update')]
    public function isCompletedUpdate(
        $id,
        OrderRepository $orderRepository,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {
        $order = $orderRepository->find($id);
        $order->setCompleted(true);
        $entityManager->flush();
        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * Removes an order.
     *
     * @param Order                  $order         The order to remove.
     * @param EntityManagerInterface $entityManager The entity manager to remove entities.

     * @return Response Redirects to the orders list with a danger flash message.
     */
    #[Route('/editor/order/{id}/remove', name: 'app_orders_remove')]
    public function removeOrder(Order $order, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($order);
        $entityManager->flush();
        return $this->redirectToRoute('app_orders_show');
    }

    /**
     * Displays a confirmation message after successfully placing an order.
     *
     * @return Response Renders the confirmation message.
     */
    #[Route("/order-ok-message", name: 'order_ok_message')]
    public function orderMessage(): Response
    {
        return $this->render('order/order_message.twig');
    }

    /**
     * Calculates the shipping cost for a city.
     *
     * @param City $city The city for which to calculate the shipping cost.

     * @return Response Returns the shipping cost as JSON.
     */
    #[Route('/city/{id}/shipping/cost', name: 'app_city_shipping_cost')]
    public function cityShippingCost(City $city): Response
    {
        $cityShippingPrice = $city->getShippingCost();
        return new Response(
            json_encode(
                [
                    'status' => 200,
                    "message" => 'on',
                    'content' => $cityShippingPrice
                ]
            )
        );
    }
}
