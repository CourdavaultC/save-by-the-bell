<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label'=>'Email: '
            ])


            ->add('plainPassword', PasswordType::class, [
                'label'=>"Password: ",
                'mapped'=>false
            ])

            ->add('firstname', TextType::class, [
                'label'=>'Prénom: '
            ])

            ->add('lastname', TextType::class, [
                'label'=>'Nom: '
            ])

            ->add('session', null, [
                'label'=>'Nom de la Session: '
            ])

            ->add('submit', SubmitType::class, [
                'label'=>'Ajouter un utilisateur'
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
