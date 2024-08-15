<?php

/**
 * ProductController
 *
 * Manages product-related actions such as listing, creating, editing, deleting,
 * and managing stock history.
 *
 * @category Controllers
 * @package  App\Controller\Product
 * @author   Maher Ben Rhouma <maherbenrhoumaaa@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 */

namespace App\Controller;

use App\Entity\AddProductHistory;
use App\Entity\Product;
use App\Form\AddProductHistoryType;
use App\Form\ProductType;
use App\Form\ProductUpdateType;
use App\Repository\AddProductHistoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * ProductController
 *
 * Manages product-related actions such as listing, creating, editing, deleting,
 * and managing stock history.
 *
 * @category Controllers
 * @package  App\Controller\Product
 * @author   Maher Ben Rhouma <maherbenrhoumaaa@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 */
#[Route('/editor/product')]
class ProductController extends AbstractController
{
    /**
     * Lists all products.
     *
     * @param ProductRepository $productRepository The repository to fetch products from the database.

     * @return Response Renders the list of all products.
     */
    #[Route('/', name: 'app_product_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render(
            'product/index.html.twig',
            [
                'products' => $productRepository->findAll(),
            ]
        );
    }

    /**
     * Creates a new product.
     *
     * @param Request                $request       The current HTTP request.
     * @param EntityManagerInterface $entityManager The entity manager to persist entities.
     * @param SluggerInterface       $slugger       The slugger service to generate slugs.

     * @return Response Processes the creation of a new product and redirects to the product list.
     */
    #[Route('/new', name: 'app_product_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();
            if ($image) {
                $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFileName = $slugger->slug($originalName);
                $newFileName = $safeFileName . '-' . uniqid() . '.' . $image->guessExtension();

                try {
                    $image->move(
                        $this->getParameter('image_dir'),
                        $newFileName
                    );
                } catch (FileException $exception) {
                }
                $product->setImage($newFileName);
            }
            $entityManager->persist($product);
            $entityManager->flush();

            $stockHistory = new AddProductHistory();
            $stockHistory->setQte($product->getStock());
            $stockHistory->setProduct($product);
            $stockHistory->setCreatedAt(new \DateTimeImmutable());
            $entityManager->persist($stockHistory);
            $entityManager->flush();

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render(
            'product/new.html.twig',
            [
                'product' => $product,
                'form' => $form,
            ]
        );
    }

    /**
     * Shows a single product.
     *
     * @param Product $product The product to display.

     * @return Response Renders the details of the specified product.
     */
    #[Route('/{id}', name: 'app_product_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        return $this->render(
            'product/show.html.twig',
            [
                'product' => $product,
            ]
        );
    }

    /**
     * Edits a product.
     *
     * @param Request                $request       The current HTTP request.
     * @param Product                $product       The product being edited.
     * @param EntityManagerInterface $entityManager The entity manager to update entities.
     * @param SluggerInterface       $slugger       The slugger service to generate slugs.

     * @return Response Processes the update of the product and redirects to the product list.
     */
    #[Route('/{id}/edit', name: 'app_product_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ProductUpdateType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();
            if ($image) {
                $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFileName = $slugger->slug($originalName);
                $newFileName = $safeFileName . '-' . uniqid() . '.' . $image->guessExtension();

                try {
                    $image->move(
                        $this->getParameter('image_dir'),
                        $newFileName
                    );
                } catch (FileException $exception) {
                }
                $product->setImage($newFileName);
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render(
            'product/edit.html.twig',
            [
                'product' => $product,
                'form' => $form,
            ]
        );
    }

    /**
     * Deletes a product.
     *
     * @param Request                $request       The current HTTP request.
     * @param Product                $product       The product to delete.
     * @param EntityManagerInterface $entityManager The entity manager to remove entities.

     * @return Response Deletes the specified product and redirects to the product list.
     */
    #[Route('/{id}', name: 'app_product_delete', methods: ['POST'])]
    public function delete(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * Adds stock to a product.
     *
     * @param int                    $id                The ID of the product to add stock to.
     * @param EntityManagerInterface $entityManager     The entity manager to persist entities.
     * @param Request                $request           The current HTTP request.
     * @param ProductRepository      $productRepository The repository to fetch products from the database.

     * @return Response Processes the addition of stock to the specified product and redirects to the product list.
     */
    #[Route('/add/product/{id}/stock', name: 'app_product_stock_add', methods: ['POST', 'GET'])]
    public function addStock($id, EntityManagerInterface $entityManager, Request $request, ProductRepository $productRepository): Response
    {
        $addStock = new AddProductHistory();
        $form = $this->createForm(AddProductHistoryType::class, $addStock);
        $form->handleRequest($request);
        $product = $productRepository->find($id);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($addStock->getQte() > 0) {
                $newQte = $product->getStock() + $addStock->getQte();
                $product->setStock($newQte);
                $addStock->setCreatedAt(
                    new \DateTimeImmutable()
                );
                $addStock->setProduct($product);
                $entityManager->persist($addStock);
                $entityManager->flush();
                $this->addFlash('success', 'the product has been added');
                return $this->redirectToRoute('app_product_index');
            } else {
                $this->addFlash('danger', 'the quantity must be superior than 0');
                return $this->redirectToRoute(
                    'app_product_stock_add',
                    ['id' => $product->getId()]
                );
            }
        }

        return $this->render(
            'product/addStock.html.twig',
            [
                'form' => $form->createView(),
                'product' => $product,
            ]
        );
    }

    /**
     * Shows the stock history of a product.
     *
     * @param int                         $id                          The ID of the product whose stock history is to be shown.
     * @param ProductRepository           $productRepository           The repository to fetch products from the database.
     * @param AddProductHistoryRepository $addProductHistoryRepository The repository to fetch stock history records.

     * @return Response Renders the stock history of the specified product.
     */
    #[Route('/add/product/{id}/stock/history', name: 'app_product_stock_add_history', methods: ['GET'])]
    public function productAddHistory($id, ProductRepository $productRepository, AddProductHistoryRepository $addProductHistoryRepository): Response
    {

        $product = $productRepository->find($id);
        $addProductHistory = $addProductHistoryRepository->findBy(
            [
                'product' => $product
            ],
            ['id' => 'Desc']
        );

        return $this->render(
            'product/addedStockHistoryShow.html.twig',
            [
                'addProductHistory' => $addProductHistory
            ]
        );
    }
}
