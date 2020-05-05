<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    /**
     * @Route("/connection", name="connection")
     */
    public function index()
    {
        return $this->render('connection/connection.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }
    /**
     * @Route("/pdf", name="pdf")
     */
    public function getPdf()
    {
        return $this->render('app/pdf.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }
}
