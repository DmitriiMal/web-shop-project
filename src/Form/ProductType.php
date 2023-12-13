<?php

namespace App\Form;

use App\Entity\FkCategory;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

use Symfony\Component\Form\Extension\Core\Type\NumberType;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class ProductType extends AbstractType
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

            ->add('description', null, 
                [
                    'constraints' => [
                    new NotBlank(['message' => "You cannot leave the input empty."]),
                    new Length(['min' => 3, 'minMessage' => "It must be 3 letters at least."]),
                ],
                'attr' => ['placeholder' => 'Please write a description.'],
            ])
            
            ->add('picture', FileType::class, [
                'attr' => ['class' => 'form-control', 'accept' => 'image/png , image/jpg, image/jpeg'],
                'label' => 'Product image',

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

            ->add('price', NumberType::class, 
                [
                    'constraints' => [
                    new NotBlank(['message' => "You cannot leave the input empty."])
                ],
                'attr' => ['value' => '0', 'min' => '0'],
            ])

            ->add('quantity', null, 
                [
                    'constraints' => [
                    new NotBlank(['message' => "You cannot leave the input empty."]),
                ],
                'attr' => ['value' => '0', 'min' => '0', 'max' => '10000'],
            ])
            
            ->add('fk_categoryID', EntityType::class, [
                'class' => FkCategory::class,
                'choice_label' => 'name',
                'label' => 'Category',
                'placeholder'=> '(Choose one)',
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('f')
                        ->orderBy('f.name', 'ASC');
                },
            ])

            // yesterday I need a thing, I search order_by in websote, I not found it.... you show me that it is easy

            ->add('availability',null,[
                'attr' => ['class' => 'form-check-input'],
                'label' => 'Available'
            ])

            ->add('shown_hidden',null,[
                'attr' => ['class' => 'form-check-input'],
                'label' => 'Hidden'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
