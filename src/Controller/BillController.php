<?php

/**
 * BillController.php
 *
 * This file contains the definition of the BillController class, which handles
 * actions related to the bill in the application.
 *
 * @category Controllers
 * @package  App\Controller\Bill
 * @author   Maher Ben Rhouma <maherbenrhoumaaa@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 * @since    PHP 8.2
 */

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * BillController
 *
 * @category Controllers
 *
 * @package App\Controller\Bill
 *
 * @author Maher Ben Rhouma <maherbenrhoumaaa@gmail.com>
 *
 * @license No license (Personal project)
 *
 * @link https://symfony.com/doc/current/controller.html
 */
class BillController extends AbstractController
{
    #[Route('/{_locale<%app.supported_locales%>}/editor/order/{id}/bill', name: 'app_bill')]

    /**
     * Generates and streams a PDF bill for a given order
     *
     * @param int             $id              The ID of the order for which the bill should be generated.
     * @param OrderRepository $orderRepository Service responsible for fetching orders from the database.

     * @return Response A Symfony Response object that streams
     * the generated PDF to the client.
     */
    public function index($id, OrderRepository $orderRepository): Response
    {

        $order = $orderRepository->find($id);

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $domPdf = new Dompdf($pdfOptions);
        $html = $this->renderView(
            'bill/index.html.twig',
            [
                'order' => $order
            ]
        );
        $domPdf->loadHtml($html);
        $domPdf->render();
        $domPdf->stream(
            "M&Code-symfony-bill-" . $order->getId() . ' .pdf',
            [
                'Attachment' => false,
            ]
        );
        return new Response(
            '',
            200,
            [
                'Content-type' => 'application/pdf',
            ]
        );
    }
}
