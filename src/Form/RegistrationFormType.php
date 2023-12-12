<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', null, [
                'attr' => ['placeholder' => 'Please enter e-mail'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a e-mail'
                    ])
                ]
            ])
            ->add('first_name', null, [
                'attr' => ['placeholder' => 'Please enter first name'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your first name'
                    ])
                ]
            ])
            ->add('last_name', null, [
                'attr' => ['placeholder' => 'Please enter last name'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your last name'
                    ])
                ]
            ])
            ->add('country', null, [
                'attr' => ['placeholder' => 'Please enter your country'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your country'
                    ])
                ]
            ])
            ->add('city', null, [
                'attr' => ['placeholder' => 'Please enter your city'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your city'
                    ])
                ]
            ])
            ->add('street', null, [
                'attr' => ['placeholder' => 'Please enter your street'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your street'
                    ])
                ]
            ])
            ->add('house', null, [
                'attr' => ['placeholder' => 'Please enter your house number'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your house number'
                    ])
                ]
            ])
            ->add('zip_code', null, [
                'attr' => ['placeholder' => 'Please enter the zip code'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter the zip code'
                    ])
                ]
            ])
            ->add('phone', null, [
                'attr' => ['placeholder' => 'Please enter your phone number'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a phone number'
                    ])
                ]
            ])
            ->add('picture', FileType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Please enter price'],

                'label' => 'Picture',

                'mapped' => false,

                'required' => false,

                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'pictures/png',
                            'pictures/jpg',
                            'pictures/jpeg'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image document',
                    ])
                ],
            ])
            ->add('created_at')
            ->add('birth_date')
            
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password', 'placeholder' => 'Please enter a password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
