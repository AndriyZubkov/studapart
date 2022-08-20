<?php

namespace App\Form\Type;

use App\Entity\Forms\SignupForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SignUpType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
           ->add('email', RepeatedType::class, [
               'type'    => EmailType::class,
               'options' => [
                   'attr' => [
                       'placeholder' => 'Email',
                       'maxlength' => 120,
                   ]
               ],
               'required'       => true,
               'first_options'  => [
                   'label' => false,
                   ],
               'second_options' => [
                   'label' => false,
                   'attr' => [
                       'placeholder' => 'Repeat email',
                   ]
                   ],
           ])
           ->add('password', RepeatedType::class, [
               'type'    => PasswordType::class,
               'options' => [
                   'attr' => [
                       'placeholder' => 'Password',
                       'minlength' => 6,
                       'maxlength' => 120,
                   ]
               ],
               'required'       => true,
               'first_options'  => [
                   'label' => false,
               ],
               'second_options' => [
                   'label' => false,
                   'attr' => [
                       'placeholder' => 'Repeat password',
                   ]
               ],
           ])
           ->add('phone', TelType::class, [
               'required' => true,
               'label'    => false,
               'attr'     => [
                   'placeholder' => 'Mobile phone number',
                   'minlength'   => 10,
                   'maxlength'   => 10,
               ],
           ]);
       //TODO: Email check for unique
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => SignupForm::class,
            'csrf_field_name' => '_token',
        ]);
    }
}
