<?php

namespace App\Form;

use App\Entity\Domain;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class DomainType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('subscription', ChoiceType::class, [
                'label' => 'À souscrire',
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    'Oui' => "Oui",
                    'Non' => "Non",
                ],
            ])
            ->add('existing', ChoiceType::class, [
                'label' => 'Existant',
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non',
                ],
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom de domaine',
                'attr' => [
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => "/^[a-z ,.'-]+$/i",
                        'message' => 'Le nom de domaine {{ value }} n\'est pas valide.',
                    ]),
                ],
                'required' => false,
            ])
            ->add('host', TextType::class, [
                'label' => 'Hébergeur',
                'attr' => [
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => "/^[a-z ,.'-]+$/i",
                        'message' => 'Le nom de l\'hébergeur {{ value }} n\'est pas valide.',
                    ]),
                ],
                'required' => false,
            ])
            ->add('login', TextType::class, [
                'label' => 'Login',
                'attr' => [
                    'class' => 'form-control'
                ],
                'required' => false,
            ])
            ->add('password', TextType::class, [
                'label' => 'Mot de passe',
                'attr' => [
                    'class' => 'form-control'
                ],
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Domain::class,
        ]);
    }
}
