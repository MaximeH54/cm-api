<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class SecurityController extends AbstractController
{
    /**
     * @Route("/", name="login")
     */
    public function login()
    {
        return $this->render('security/login.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    /**
     * @Route("/login/google", name="google_login")
     */
    public function indexGoogle()
    {
				$user = $this->getUser();

        return $this->json([
						'firstName' => $user->getFirstName(),
						'lastName' => $user->getLastName(),
				]);
    }
		/**
     * @Route("/login/facebook", name="facebook_login")
     */
    public function indexFacebook(ClientRegistry $clientRegistry)
    {

        return $this->json(true);
    }
}
