<?php


/**
 * SecurityController
 *
 * Manages user authentication by handling login and logout actions.
 *
 * @category Controllers
 * @package  App\Controller\Security
 * @author   Your Name <your.email@example.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/security.html
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * SecurityController
 *
 * Manages user authentication by handling login and logout actions.
 *
 * @category Controllers
 * @package  App\Controller\Security
 * @author   Your Name <your.email@example.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/security.html
 */
class SecurityController extends AbstractController
{
    /**
     * Displays the login form.
     *
     * @param AuthenticationUtils $authenticationUtils Utility service to retrieve the last username and authentication errors.
     
     * @return Response Renders the login form with the last entered username and any authentication errors.
     */
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * Logs out the user.
     *
     * @return void This method intentionally left blank; the logout process is managed by the security configuration.
     */
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
