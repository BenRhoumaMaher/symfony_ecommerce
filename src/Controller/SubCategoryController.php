<?php

/**
 * SubCategoryController
 *
 * Manages subcategories within the admin panel, including listing, creating, editing, showing details, and deleting subcategories.
 *
 * @category Controllers
 * @package  App\Controller\SubCategory
 * @author   Your Name <maherbenrhoumaaa@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 */

namespace App\Controller;

use App\Entity\SubCategory;
use App\Form\SubCategoryType;
use App\Repository\CategoryRepository;
use App\Repository\SubCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * SubCategoryController
 *
 * Manages subcategories within the admin panel, including listing, creating, editing, showing details, and deleting subcategories.
 *
 * @category Controllers
 * @package  App\Controller\SubCategory
 * @author   Your Name <maherbenrhoumaaa@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 */
#[Route('/{_locale<%app.supported_locales%>}/admin/sub/category')]
class SubCategoryController extends AbstractController
{
    /**
     * Lists all subcategories.
     *
     * @param SubCategoryRepository $subCategoryRepository The repository to fetch all subcategories.

     * @return Response Renders the list of subcategories.
     */
    #[Route('/', name: 'app_sub_category_index', methods: ['GET'])]
    public function index(
        SubCategoryRepository $subCategoryRepository,
        CategoryRepository $categoryRepository
    ): Response {
        return $this->render(
            'sub_category/index.html.twig',
            [
                'sub_categories' => $subCategoryRepository->findAll(),
                'categories' => $categoryRepository->findAll(),
            ]
        );
    }

    /**
     * Creates a new subcategory.
     *
     * @param Request                $request       The current HTTP request.
     * @param EntityManagerInterface $entityManager The entity manager to persist the new subcategory.

     * @return Response Redirects to the subcategory index page after successful creation.
     */
    #[Route('/new', name: 'app_sub_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $subCategory = new SubCategory();
        $form = $this->createForm(SubCategoryType::class, $subCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($subCategory);
            $entityManager->flush();

            return $this->redirectToRoute('app_sub_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render(
            'sub_category/new.html.twig',
            [
                'sub_category' => $subCategory,
                'form' => $form,
            ]
        );
    }

    /**
     * Shows the detail of a specific subcategory.
     *
     * @param SubCategory $subCategory The subcategory to display.

     * @return Response Renders the subcategory detail page.
     */
    #[Route('/{id}', name: 'app_sub_category_show', methods: ['GET'])]
    public function show(SubCategory $subCategory): Response
    {
        return $this->render(
            'sub_category/show.html.twig',
            [
                'sub_category' => $subCategory,
            ]
        );
    }

    /**
     * Edits a specific subcategory.
     *
     * @param Request                $request       The current HTTP request.
     * @param SubCategory            $subCategory   The subcategory to edit.
     * @param EntityManagerInterface $entityManager The entity manager to update the subcategory.

     * @return Response Redirects to the subcategory index page after successful update.
     */
    #[Route('/{id}/edit', name: 'app_sub_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SubCategory $subCategory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SubCategoryType::class, $subCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_sub_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render(
            'sub_category/edit.html.twig',
            [
                'sub_category' => $subCategory,
                'form' => $form,
            ]
        );
    }

    /**
     * Deletes a specific subcategory.
     *
     * @param Request                $request       The current HTTP request.
     * @param SubCategory            $subCategory   The subcategory to delete.
     * @param EntityManagerInterface $entityManager The entity manager to remove the subcategory.

     * @return Response Redirects to the subcategory index page after deletion.
     */
    #[Route('/{id}', name: 'app_sub_category_delete', methods: ['POST'])]
    public function delete(Request $request, SubCategory $subCategory, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $subCategory->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($subCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_sub_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
