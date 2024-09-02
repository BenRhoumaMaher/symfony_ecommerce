<?php

/**
 * StripeController
 *
 * Handles Stripe payment notifications and status updates, including success,
 * cancellation, and webhook notifications.
 *
 * @category Controllers
 * @package  App\Controller\Stripe
 * @author   Your Name <maherbenrhoumaaa@gmail.com>
 * @license  No license (Personal project)
 * @link     https://stripe.com/docs/payments/integration-builder
 */

namespace App\Controller;

use Stripe\Stripe;
use App\Service\Cart;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * StripeController
 *
 * Handles Stripe payment notifications and status updates, including success,
 * cancellation, and webhook notifications.
 *
 * @category Controllers
 * @package  App\Controller\Stripe
 * @author   Your Name <maherbenrhoumaaa@gmail.com>
 * @license  No license (Personal project)
 * @link     https://stripe.com/docs/payments/integration-builder
 */
class StripeController extends AbstractController
{
    /**
     * Displays the success page after a successful payment.
     *
     * @param Cart             $cart    The cart service to clear the cart after successful payment.
     * @param SessionInterface $session The session service to clear the cart data.

     * @return Response Renders the success page.
     */
    #[Route('/{_locale<%app.supported_locales%>}/pay/success', name: 'app_stripe_success')]
    public function success(Cart $cart, SessionInterface $session): Response
    {
        $session->set(
            'cart',
            []
        );
        return $this->render(
            'stripe/index.html.twig',
            [
                'controller_name' => 'StripeController',
            ]
        );
    }

    /**
     * Displays the cancellation page after a failed payment attempt.
     *
     * @return Response Renders the cancellation page.
     */
    #[Route('/{_locale<%app.supported_locales%>}/pay/cancel', name: 'app_stripe_cancel')]
    public function cancel(): Response
    {
        return $this->render(
            'stripe/index.html.twig',
            [
                'controller_name' => 'StripeController',
            ]
        );
    }

    /**
     * Processes Stripe webhook notifications.
     *
     * @param Request                $request         The current HTTP request containing the webhook payload.
     * @param OrderRepository        $orderRepository The repository to manage orders.
     * @param EntityManagerInterface $entityManager   The entity manager to persist changes to the database.

     * @return Response Responds to the webhook notification.
     */
    #[Route('/{_locale<%app.supported_locales%>}/stripe/notify', name: 'app_stripe_notify')]
    public function stripeNotify(
        Request $request,
        OrderRepository $orderRepository,
        EntityManagerInterface $entityManager
    ): Response {
        Stripe::setApiKey($_SERVER['STRIPE_SECRET']);
        $endpoint_secret = 'whsec_78d8b4ee4db22da481c1bbf5760d83a50976723025cdf3387257b229d66154ee';
        $payload = $request->getContent();
        $sig_header = $request->headers->get('stripe-signature');
        $event = null;
        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            return new Response('payload invalide', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return new Response('Signature invalid');
        }
        switch (
            $event->type
        ) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
                $fileName = 'stripe-details-' . uniqid() . 'txt';
                file_put_contents($fileName, $paymentIntent);
                break;
            case 'payment_method.attached':
                $paymentMethod = $event->data->object;
                break;
            default:
                break;
        }
        return new Response('evenement reçu', 200);
    }
}
