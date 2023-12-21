<?php

namespace App\Form;

use App\Entity\Reviews;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatableMessage;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ReviewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'rating',
                ChoiceType::class,
                [
                    'constraints' => [
                        new NotBlank(['message' => "You cannot leave the input empty."]),
                    ],
                    // 'choice_label' => function ($choice, string $key, mixed $value): TranslatableMessage|string {
                    //     return '&#9734;';
                    // },
                    'label_html' => true,
                    'choices' => [
                        '1' => 1,
                        '2' => 2,
                        '3' => 3,
                        '4' => 4,
                        '5' => 5,
                    ],
                    'expanded' => true
                ]
            )

            ->add(
                'review',
                null,
                [
                    'constraints' => [
                        new NotBlank(['message' => "You cannot leave the input empty."]),
                        new Length(['min' => 3, 'minMessage' => "It must be 3 letters at least."]),
                    ],
                    'attr' => ['placeholder' => 'Please write a review.'],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reviews::class,
        ]);
    }
}
