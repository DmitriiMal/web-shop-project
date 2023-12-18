<?php

namespace App\Form;

use Symfony\Component\DomCrawler\Field\TextareaFormField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', null, [
            'attr' => ['placeholder' => 'Please enter name', 'class' => 'mt-5'],
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter your name'
                ])
            ]
        ])
        ->add('email', null, [
            'attr' => ['placeholder' => 'Please enter e-mail', 'class' => 'mt-2'],
            "invalid_message" => "This value is not valid",
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter an e-mail-address'
                ]),
            ]
        ])
        ->add('subject', null, [
            'attr' => ['placeholder' => 'Please enter subject', 'class' => 'mt-2 tinymce'],
            "invalid_message" => "This value is not valid",
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter a subject'
                ]),
            ]
        ])
        ->add('message', TextareaType::class, [
            'attr' => ['placeholder' => 'Please enter message', 'class' => 'mt-2'],
            "invalid_message" => "This value is not valid",
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter a message'
                ]),
            ]
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
            // Configure your form options here
        ]);
    }
}
