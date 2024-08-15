<?php

/**
 * CategoryController
 *
 * Manages categories in the admin panel, allowing for listing, creating,
 * updating, and deleting categories.
 *
 * @category Controllers
 * @package  App\Controller\Category
 * @author   Maher Ben Rhouma <maherbenrhoumaaa@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 */

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryFormType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * CategoryController
 *
 * Manages categories in the admin panel, allowing for listing, creating,
 * updating, and deleting categories.
 *
 * @category Controllers
 * @package  App\Controller\Category
 * @author   Maher Ben Rhouma <maherbenrhoumaaa@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 */

class CategoryController extends AbstractController
{
    /**
     * Lists all categories ordered by their IDs in ascending order.
     *
     * @param CategoryRepository $categoryRepository The repository to fetch categories
     *                                               from the database.

     * @return Response Renders the list of categories.
     */
    #[Route('/admin/category', name: 'app_category')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findBy([], ['id' => "ASC"]);
        return $this->render(
            'category/index.html.twig',
            [
                'categories' => $categories,
            ]
        );
    }

    /**
     * Creates a new category.
     *
     * Initializes a form with a new Category entity, handles the submission,
     * persists the entity to the database, and redirects to the category list upon success.
     *
     * @param EntityManagerInterface $entityManager The entity manager to persist entities.
     * @param Request                $request       The current HTTP request.

     * @return Response Redirects to the category list after successful creation.
     */
    #[Route('/admin/category/new', name: 'app_category_new')]
    public function addCategory(EntityManagerInterface $entityManager, Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();
            $this->addFlash('success', 'votre category a été crée');
            return $this->redirectToRoute('app_category');
        }

        return $this->render(
            'category/new.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * Updates an existing category.
     *
     * Initializes a form with the given Category entity, handles the submission,
     * updates the entity in the database,
     * and redirects to the category list upon success.
     *
     * @param Category               $category      The category to update.
     * @param EntityManagerInterface $entityManager The entity manager to persist entities.
     * @param Request                $request       The current HTTP request.

     * @return Response              Redirects to the category list after successful update.
     */
    #[Route('/admin/category/{id}/update', name: 'app_category_update')]
    public function update(Category $category, EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'votre category a été modifier');
            return $this->redirectToRoute('app_category');
        }

        return $this->render(
            'category/update.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * Deletes a category.
     *
     * Removes the given Category entity from the database
     * and redirects to the category list.
     *
     * @param Category               $category      The category to delete.
     * @param EntityManagerInterface $entityManager The entity manager to remove entities.

     * @return Response Redirects to the category list after successful deletion.
     */
    #[Route('/admin/category/{id}/delete', name: 'app_category_delete')]
    public function delete(Category $category, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($category);
        $entityManager->flush();

        $this->addFlash('danger', 'votre category a été supprimer');
        return $this->redirectToRoute('app_category');
    }
}
