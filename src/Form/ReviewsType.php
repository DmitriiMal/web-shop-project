<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Reviews;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ReviewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('rating', RadioType::class, 
            [
                'constraints' => [
                    new NotBlank(['message' => "You cannot leave the input empty."]),
                ],
                'attr' => ['placeholder' => '0', 'min' => '0', 'max' => '5'],
            ])

        
            ->add('review', null, 
            [
                'constraints' => [
                    new NotBlank(['message' => "You cannot leave the input empty."]),
                     new Length(['min' => 3, 'minMessage' => "It must be 3 letters at least."]),
                ],
                'attr' => ['placeholder' => 'Please write a review.'],
            ])

//             ->add('fk_user', EntityType::class, [
//                 'class' => User::class,
// 'choice_label' => 'id',
//             ])

//             ->add('fk_product', EntityType::class, [
//                 'class' => Product::class,
// 'choice_label' => 'id',
//             ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reviews::class,
        ]);
    }
}
