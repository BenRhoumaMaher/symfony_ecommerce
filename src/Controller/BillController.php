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

use App\Entity\Order;
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
    public function index(
        Order $order,
        OrderRepository $orderRepository
    ): Response {
        return $this->streamBill($order, $orderRepository);
    }

    /**
     * Renders the bill HTML template and generates the PDF bill
     *
     * @param Order           $order           The order entity containing details about the order.
     * @param OrderRepository $orderRepository Service responsible for fetching orders from the database.
     *
     * @return Response A Symfony Response object that streams the generated PDF to the client.
     */
    private function streamBill(
        Order $order,
        OrderRepository $orderRepository
    ): Response {

        $pdfOptions = $this->createPdfOptions();
        $domPdf = new Dompdf($pdfOptions);

        $html = $this->renderView(
            'bill/index.html.twig',
            [
                'order' => $order
            ]
        );

        $domPdf->loadHtml($html);
        $domPdf->render();

        return $this->streamPDF($domPdf, $order);
    }

    /**
     * Creates options for PDF generation using Dompdf
     *
     * @return Options The Dompdf Options object configured with default font settings.
     */
    private function createPdfOptions(): Options
    {
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        return $options;
    }

    /**
     * Streams the generated PDF bill to the client
     *
     * @param Dompdf $domPdf The Dompdf instance containing the rendered PDF content.
     * @param Order  $order  The order entity containing details about the order.
     *
     * @return Response A Symfony Response object that streams the generated PDF to the client.
     */
    private function streamPDF(
        Dompdf $domPdf,
        Order $order
    ): Response {

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