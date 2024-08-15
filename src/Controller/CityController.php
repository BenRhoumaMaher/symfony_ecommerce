<?php

/**
 * CityController
 *
 * Manages cities in the editor, allowing for listing, creating, showing,
 * editing, and deleting cities.
 *
 * @category Controllers
 * @package  App\Controller\City
 * @author   Maher Ben Rhouma <maherbenrhoumaaa@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 */

namespace App\Controller;

use App\Entity\City;
use App\Form\CityType;
use App\Repository\CityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * CityController
 *
 * Manages cities in the editor, allowing for listing, creating, showing,
 * editing, and deleting cities.
 *
 * @category Controllers
 * @package  App\Controller\City
 * @author   Maher Ben Rhouma <maherbenrhoumaaa@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 */
#[Route('/editor/city')]
class CityController extends AbstractController
{
    /**
     * Lists all cities.
     *
     * @param CityRepository $cityRepository The repository to fetch
     *                                       cities from the database.

     * @return Response Renders the list of cities.
     */
    #[Route('/', name: 'app_city_index', methods: ['GET'])]
    public function index(CityRepository $cityRepository): Response
    {
        return $this->render(
            'city/index.html.twig',
            [
                'cities' => $cityRepository->findAll(),
            ]
        );
    }

    /**
     * Creates a new city.
     *
     * Initializes a form with a new City entity, handles the submission,
     * persists the entity to the database,
     * and redirects to the city list upon success.
     *
     * @param Request                $request       The current HTTP request.
     * @param EntityManagerInterface $entityManager The entity manager to persist entities.

     * @return Response Redirects to the city list after successful creation.
     */
    #[Route('/new', name: 'app_city_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $city = new City();
        $form = $this->createForm(CityType::class, $city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($city);
            $entityManager->flush();

            return $this->redirectToRoute('app_city_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render(
            'city/new.html.twig',
            [
                'city' => $city,
                'form' => $form,
            ]
        );
    }

    /**
     * Shows a single city.
     *
     * @param City $city The city to display.

     * @return Response Renders the city details.
     */
    #[Route('/{id}', name: 'app_city_show', methods: ['GET'])]
    public function show(City $city): Response
    {
        return $this->render(
            'city/show.html.twig',
            [
                'city' => $city,
            ]
        );
    }

    /**
     * Edits a city.
     *
     * Initializes a form with the given City entity, handles the submission,
     * updates the entity in the database,
     * and redirects to the city list upon success.
     *
     * @param Request                $request       The current HTTP request.
     * @param City                   $city          The city to update.
     * @param EntityManagerInterface $entityManager The entity manager to persist entities.

     * @return Response Redirects to the city list after successful update.
     */
    #[Route('/{id}/edit', name: 'app_city_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, City $city, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CityType::class, $city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_city_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render(
            'city/edit.html.twig',
            [
                'city' => $city,
                'form' => $form,
            ]
        );
    }

    /**
     * Deletes a city.
     *
     * Validates CSRF token, removes the given City entity from the database,
     * and redirects to the city list.
     *
     * @param Request                $request       The current HTTP request.
     * @param City                   $city          The city to delete.
     * @param EntityManagerInterface $entityManager The entity manager to remove entities.

     * @return Response Redirects to the city list after successful deletion.
     */
    #[Route('/{id}', name: 'app_city_delete', methods: ['POST'])]
    public function delete(Request $request, City $city, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $city->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($city);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_city_index', [], Response::HTTP_SEE_OTHER);
    }
}
