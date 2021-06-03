<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'invalid_message' => "L'email n'existe pas.",
                'required' => true,
                'attr' => ['class' => 'block w-full py-3 px-1 mt-2 mb-4
                    text-grey-800 appearance-none
                    border-b-2 border-gray-100
                    focus:text-gray-500 focus:outline-none focus:border-gray-200'
                ]])
            ->add('password', PasswordType::class, [
                'invalid_message' => "Le mot de passe est incorrect.",
                'required' => true,
                'attr' => ['class' => 'block w-full py-3 px-1 mt-2 mb-4
                    text-grey-800 appearance-none
                    border-b-2 border-gray-100
                    focus:text-gray-500 focus:outline-none focus:border-gray-200',
                ]])

            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'w-full py-3 mt-10 bg-gray-800 rounded-sm
                    font-medium text-white uppercase
                    focus:outline-none hover:bg-gray-700 hover:shadow-none']
            ]);
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
