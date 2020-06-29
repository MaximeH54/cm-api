<?php
namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/new", name="app_product_new")
     */
    public function new(Request $request, SluggerInterface $slugger)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request); // Appel de la methode handleRequest() afin de traiter les données

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $brochureFile */
            $file = $form->get('upload')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($file) {
							  //$file->getMimeType();
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
								$user = $this->getUser();

								// updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $product->setFilename($newFilename);
								$product->setUser($user);
								$product->setDate(new \DateTime());
								$product->setType($file->getMimeType());

                // Move the file to the directory where brochures are stored
                try {
                    $file->move(
                        $this->getParameter('upload_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
									return $this->render('product/new.html.twig', [
					           'form' => $form->createView(),
										 'error' => $e->getMessage(),
					        ]);
                    // ... handle exception if something happens during file upload
                }

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($product);
                $entityManager->flush();
            }

            // ... persist the $product variable or any other work

            return $this->redirect($this->generateUrl('app_product_list'));
        }

        return $this->render('product/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
		/**
		 * @Route("/product/delete/{id}", name="app_product_delete")
		 */
		public function delete($id)
		{
				$product = $this->getDoctrine()
					->getRepository(Product::class)
					->find($id);
				//appel de la méthode remove() de symfony sur l'$entityManager (outil de symfony pour modifier en base de donnée)



		    if (!$product) {
		        throw $this->createNotFoundException(
		            'No product found for id '.$id
		        );
		    }
				$entityManager = $this->getDoctrine()->getManager();
				$entityManager->remove($product);
				$entityManager->flush();
				
		    return $this->redirectToRoute('app_product_list');
		}

    /**
     * @Route("/product/list", name="app_product_list")
     */
    public function list()
    {
			$products = $this->getDoctrine()
				->getRepository(Product::class)
				->findAll(); //findAll renvoie un array.
      // recup les fichiers uploaded dans la BDD
     //afficher vues Twig
		 return $this->render('product/list.html.twig', [
			 'products' => $products,
		 ]);
    }
}
