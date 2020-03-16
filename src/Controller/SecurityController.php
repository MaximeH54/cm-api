<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login/google", name="google_login")
     */
    public function index()
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
    public function index()
    {
				$user = $this->getUser();

        return $this->json([
						'firstName' => $user->getFirstName(),
						'lastName' => $user->getLastName(),
				]);
    }
}
