<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', RepeatedType::class,[
                'type' => EmailType::class,
                'invalid_message' => "L'email doit être identique.",
                'required' => true,
                'options' =>[ 'attr' => ['class' => 'block w-full py-3 px-1 mt-2 mb-4
                    text-grey-800 appearance-none
                    border-b-2 border-gray-100
                    focus:text-gray-500 focus:outline-none focus:border-gray-200'
                ]],
                'first_options' =>
                ['label' => 'Email :',
                    'label_attr' =>
                        ['class' => 'block text-xs font-semibold text-gray-600 uppercase']],

                'second_options' =>
                    ['label' => "Confirmer l'email :",'label_attr' =>
                    ['class' => 'block text-xs font-semibold text-gray-600 uppercase']],

            ])

            ->add('password', RepeatedType::class,[
                'type' => PasswordType::class,
                'options' => [ 'attr' => ['class' => 'block w-full py-3 px-1 mt-2 mb-4
                    text-grey-800 appearance-none
                    border-b-2 border-gray-100
                    focus:text-gray-500 focus:outline-none focus:border-gray-200',
                    ]],
                'invalid_message' => 'Le mot de passe doit être identique.',

                'first_options' =>
                    ['label' => 'Mot de passe :',
                    'label_attr' =>
                        ['class' => 'block text-xs font-semibold text-gray-600 uppercase']],

                'second_options' => ['label' => "Confirmation du mot de passe :",'label_attr' =>
                    ['class' => 'block text-xs font-semibold text-gray-600 uppercase']],
             ])

            ->add('name', TextType::class,
                ['label' => 'Nom :',
                    'attr' => ['class' => 'block w-full py-3 px-1 mt-2 mb-4
                    text-grey-800 appearance-none
                    border-b-2 border-gray-100
                    focus:text-gray-500 focus:outline-none focus:border-gray-200'],
                ])

            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'w-full py-3 mt-10 bg-gray-800 rounded-sm
                    font-medium text-white uppercase
                    focus:outline-none hover:bg-gray-700 hover:shadow-none']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'task_item',
        ]);
    }
}
