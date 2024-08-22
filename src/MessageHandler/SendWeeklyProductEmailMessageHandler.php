<?php

/**
 * SendWeeklyProductEmailMessageHandler
 *
 * Handles the sending of weekly product update emails.
 *
 * @category MessageHandler
 * @package  App\MessageHandler
 * @author   Maher Ben Rhouma <maherbenrhoumaaa@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/messenger.html
 */

namespace App\MessageHandler;

use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use App\Repository\ProductRepository;
use Symfony\Component\Mailer\MailerInterface;
use App\Message\SendWeeklyProductEmailMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Twig\Environment as TwigEnvironment;

/**
 * SendWeeklyProductEmailMessageHandler
 *
 * Handles the sending of weekly product update emails.
 *
 * @category MessageHandler
 * @package  App\MessageHandler
 * @author   Maher Ben Rhouma <maherbenrhoumaaa@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/messenger.html
 */
#[AsMessageHandler]
final class SendWeeklyProductEmailMessageHandler
{
    /**
     * Constructor
     *
     * @param ProductRepository $productRepository The repository used to fetch the latest products.
     * @param UserRepository    $userRepository    The repository used to fetch all users.
     * @param MailerInterface   $mailer            The mailer service used to send emails.
     * @param TwigEnvironment   $twig              The Twig environment used to render email templates.
     */
    public function __construct(
        private ProductRepository $productRepository,
        private UserRepository $userRepository,
        private MailerInterface $mailer,
        private TwigEnvironment $twig
    ) {
    }

    /**
     * Handles the message for sending weekly product update emails.
     *
     * Retrieves the latest products, renders the email content
     * using a Twig template,
     * and sends the email to all users.
     *
     * @param SendWeeklyProductEmailMessage $message The message
     *                                               containing data for the email.
     *
     * @return void
     */
    public function __invoke(SendWeeklyProductEmailMessage $message): void
    {
        $latestProducts = $this->productRepository->findBy([], ['id' => 'DESC'], 10);

        // Get all users
        $users = $this->userRepository->findAll();

        // Render the email content
        $html = $this->twig->render(
            'mail/latest_products.html.twig',
            ['products' => $latestProducts]
        );

        foreach ($users as $user) {
            $email = (new Email())
                ->from('M&CodeShop@gmail.com')
                ->to($user->getEmail())
                ->subject('Weekly Update: Latest Products')
                ->html($html);

            $this->mailer->send($email);
        }
    }
}
