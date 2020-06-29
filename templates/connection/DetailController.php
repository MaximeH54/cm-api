<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Mark;
use App\Entity\Article;
use App\Entity\Detail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DetailController extends AbstractController
{
    /**
     * @Route("/detail", name="detail")
     */
    public function index()
    {
				$detail = new Detail();

				$form = $this->createFormBuilder($detail)
						->add('reference', TextType::class)
						->add('quantity', NumberType::class)
						->add('name', TextType::class)
						->add('description', TextareaType::class)
						->add('mark', EntityType::class, [
							'class' => Mark::class,
							'choice_label' => 'name',
						])
						->add('category', EntityType::class, [
							'class' => Category::class,
							'choice_label' => 'name',
						])
						->add('save', SubmitType::class, ['label' => 'Add an article'])
						->getForm();

        return $this->render('detail/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
