<?php

namespace App\Controller;

use App\Entity\Car;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * @IsGranted("ROLE_USER")
 */
class CarController extends AbstractController
{
    /**
     * @Route("/car", name="app_car")
     */
    public function index()
    {
				$cars = $this->getDoctrine()
					->getRepository(Car::class)
					->findBy([
						'user'=> $this->getUser()
					]);

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
					->add('year', DateType::class)
					->add('numberplate', TextType::class)
					->add('motorization', TextType::class)
					->add('kilometers', IntegerType::class)
					->add('maintenance', IntegerType::class)
					->getForm();

					  $form->handleRequest($request);

				if ($form->isSubmitted() && $form->isValid()) {
					$user = $this->getUser();
					$car->setUser($user);
					$entityManager = $this->getDoctrine()->getManager();
					$entityManager->persist($car);
					$entityManager->flush();
				}
        //todo reste à récupérer les données du formulaire, vérifier validité
				return $this->render('car/new.html.twig', [
         'form' => $form->createView(),
        ]);
    }

		/**
		 * @Route("/car/delete/{id}", name="app_car_delete")
		 */
		public function delete($id)
		{
				$car = $this->getDoctrine()
					->getRepository(Car::class)
					->find($id);
				//appel de la méthode remove() de symfony sur l'$entityManager (outil de symfony pour modifier en base de donnée)

		    if (!$car) {
		        throw $this->createNotFoundException(
		            'No product found for id '.$id
		        );
		    }
				$entityManager = $this->getDoctrine()->getManager();
				$entityManager->remove($car);
				$entityManager->flush();

		    return $this->redirectToRoute('app_car_new');
		}
}
