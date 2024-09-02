<?php

/**
 * RegistrationController
 *
 * Handles user registration by creating a new user account,
 * hashing the user's password, persisting the user to the database, and logging the user in.
 *
 * @category Controllers
 * @package  App\Controller\Registration
 * @author   Your Name <maherbenrhoumaaa@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\SecurityAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

/**
 * RegistrationController
 *
 * Handles user registration by creating a new user account,
 * hashing the user's password, persisting the user to the database, and logging the user in.
 *
 * @category Controllers
 * @package  App\Controller\Registration
 * @author   Your Name <maherbenrhoumaaa@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 */

class RegistrationController extends AbstractController
{
    /**
     * Registers a new user.
     *
     * @param Request                     $request            The current HTTP request.
     * @param UserPasswordHasherInterface $userPasswordHasher Service to hash the user's password.
     * @param Security                    $security           The security service to handle user login.
     * @param EntityManagerInterface      $entityManager      The entity manager to interact with the database.

     * @return Response Returns the registration form if the form is not submitted or invalid, otherwise logs the user in and redirects them.
     */
    #[Route('/{_locale<%app.supported_locales%>}/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $security->login($user, SecurityAuthenticator::class, 'main');
        }

        return $this->render(
            'registration/register.html.twig',
            [
                'registrationForm' => $form,
            ]
        );
    }
}
