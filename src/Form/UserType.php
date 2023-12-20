<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', null, [
                'attr' => ['placeholder' => 'Please enter e-mail'],
                "invalid_message" => "This value is not valid",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a e-mail'
                    ]),
                    
                    new Email([
                        'message' => 'The email {{ value }} is not a valid email.'
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
                'attr' => ['class' => 'form-control', 'placeholder' => 'Please enter price', 'accept' => 'image/png , image/jpg, image/jpeg'],
                
                'label' => 'Picture',

                'mapped' => false,

                'required' => false,

                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                            'image/jpeg'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image document',
                    ])
                ],
            ])

            ->add('birth_date',null,[
                "widget" => "single_text",
            ])

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
            
            ->add('date_expiration',null,[
                "widget" => "single_text",
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
