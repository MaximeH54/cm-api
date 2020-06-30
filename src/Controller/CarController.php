<?php

namespace App\Controller;

use App\Entity\Car;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CarController extends AbstractController
{
    /**
     * @Route("/car", name="app_car")
     */
    public function index()
    {
				$cars = $this->getDoctrine()
					->getRepository(Car::class)
					->findAll();

        return $this->render('car/index.html.twig', [
          	'cars' => $cars,
        ]);
    }
		/**
     * @Route("/car/new", name="app_car_new")
     */
		public function new(Request $request)
    {
				$car = new Car();
				$form = $this->createFormBuilder($car)
					->add('mark', TextType::class)
					->add('model', TextType::class)
					->add('year', IntegerType::class)
					->add('numberplate', TextType::class)
					->add('motorization', TextType::class)
					->add('kilometers', IntegerType::class)
					->add('maintenance', IntegerType::class)
					->getForm();

				$user = $this->getUser();
				$car->setUser($user);

				return $this->render('car/new.html.twig', [
         'form' => $form->createView(),
        ]);
    }
}
