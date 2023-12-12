<?php

namespace App\Form;

use App\Entity\FkCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class FkCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', null, 
        [
            'constraints' => [
                new NotBlank(['message' => "You cannot leave the input empty."]),
                new Length(['min' => 3, 'minMessage' => "It must be 3 letters at least."]),
            ],
            'attr' => ['placeholder' => 'Please write a name.'],
        ])
        

        ->add('picture', FileType::class, [
            'attr' => ['class' => 'form-control', 'accept' => 'image/png , image/jpg, image/jpeg'],
            'label' => 'Category image',

            // unmapped means that this field is not associated to any entity property
            'mapped' => false,

            // make it optional so you don't have to re-upload the PDF file
            // every time you edit the Product details
            'required' => false,

            // unmapped fields can't define their validation using annotations
            // in the associated entity, so you can use the PHP constraint classes
            'constraints' => [
                new File([
                    'maxSize' => '1024k',
                    'mimeTypes' => [
                        'image/png',
                        'image/jpg',
                        'image/jpeg',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid image document'
                ])
            ],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FkCategory::class,
        ]);
    }
}
