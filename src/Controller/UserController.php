<?php

/**
 * UserController
 *
 * Manages users within the admin panel, including listing, changing roles,
 * removing roles, and deleting users.
 *
 * @category Controllers
 * @package  App\Controller\User
 * @author   Your Name <maherbenrhoumaaa@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 */

namespace App\Controller;

use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * UserController
 *
 * Manages users within the admin panel, including listing, changing roles,
 * removing roles, and deleting users.
 *
 * @category Controllers
 * @package  App\Controller\User
 * @author   Your Name <maherbenrhoumaaa@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 */
class UserController extends AbstractController
{
    /**
     * Lists all users.
     *
     * @param UserRepository $userRepository The repository to fetch all users.

     * @return Response Renders the list of users.
     */
    #[Route('/admin/user', name: 'app_user')]
    public function index(
        UserRepository $userRepository,
        CategoryRepository $categoryRepository
    ): Response {
        return $this->render(
            'user/index.html.twig',
            [
                'users' => $userRepository->findAll(),
                'categories' => $categoryRepository->findAll(),
            ]
        );
    }

    /**
     * Changes a user's role to editor.
     *
     * @param EntityManagerInterface $entityManager The entity manager to persist changes.
     * @param User                   $user          The user whose role is being changed.

     * @return Response Redirects to the user index page after updating the user's role.
     */
    #[Route('/admin/user/{id}/to/editor', name: 'app_user_to_editor')]
    public function changeRole(EntityManagerInterface $entityManager, User $user): Response
    {
        $user->setRoles(["ROLE_EDITOR", "ROLE_USER"]);
        $entityManager->flush();
        $this->addFlash('success', 'the editor role has been added to this user');
        return $this->redirectToRoute('app_user');
    }

    /**
     * Removes the editor role from a user.
     *
     * @param EntityManagerInterface $entityManager The entity manager to persist changes.
     * @param User                   $user          The user whose role is being modified.

     * @return Response Redirects to the user index page after updating the user's role.
     */
    #[Route('/admin/user/{id}/remove/editor/role', name: 'app_user_remove_editor_role')]
    public function editorRoleRemove(EntityManagerInterface $entityManager, User $user): Response
    {
        $user->setRoles([]);
        $entityManager->flush();
        return $this->redirectToRoute('app_user');
    }

    /**
     * Deletes a specific user.
     *
     * @param EntityManagerInterface $entityManager  The entity manager to remove the user.
     * @param int                    $id             The ID of the user to delete.
     * @param UserRepository         $userRepository The repository to find the user by ID.

     * @return Response Redirects to the user index page after deletion.
     */
    #[Route('/admin/user/{id}/remove', name: 'app_user_remove')]
    public function userRemove(EntityManagerInterface $entityManager, $id, UserRepository $userRepository): Response
    {
        $userFind = $userRepository->find($id);
        $entityManager->remove($userFind);
        $entityManager->flush();
        return $this->redirectToRoute('app_user');
    }
}
