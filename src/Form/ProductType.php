<?php
namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ...
            ->add('upload', FileType::class, [
                'label' => 'Téléchargez un fichier de type PDF',

                // unmapped signifie que ce champ n'est associé à aucune propriété d'entité
                'mapped' => false,

                // rendre facultatif pour ne pas avoir à télécharger à nouveau le fichier PDF
                 // chaque fois que je modifie les détails du produit
                'required' => true,

                // les champs non mappés ne peuvent pas définir leur validation à l'aide d'annotations
                 // dans l'entité associée, vous pouvez donc utiliser les classes de contraintes PHP
                'constraints' => [
                    new File([
                        'maxSize' => '5m',
                        'mimeTypes' => [
														'application/msword',
                            'application/pdf',
														'application/vnd.ms-excel',
														'application/vnd.ms-powerpoint',
														'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
														'image/gif',
                            'image/jpeg',
                            'image/png',
														'text/plain',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger un document valide.',
                    ])
                ],
            ])
            // ...
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
