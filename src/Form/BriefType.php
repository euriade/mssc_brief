<?php

namespace App\Form;

use App\Entity\Brief;
use App\Form\WebsiteType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class BriefType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('status', ChoiceType::class, [
                'label' => 'Statut',
                'required' => true,
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    'Nouveau' => 'Nouveau',
                    'À valider' => 'À valider',
                    'À compléter' => 'À compléter',
                    'Validé' => 'Validé',
                    'En cours' => 'En cours',
                    'Terminé' => 'Terminé',
                ],
            ])
            ->add('customer_name', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Nom du client',
            ])
            ->add('customer_lastname', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Prénom du client',
            ])
            ->add('company', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Nom de la société',
            ])
            ->add('phone', TelType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Téléphone de l\'entreprise',
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Email du contact',
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Pack artisan' => "Pack artisan",
                    'Pack avocat' => "Pack avocat",
                ],
                'attr' => [
                    'class' => 'form-select'
                ],
                'label' => 'Typologie'
            ])
            ->add('online_date', DateType::class, [
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Date de mise en ligne souhaitée',
            ])
            ->add('website', CollectionType::class, [
                'entry_type' => WebsiteType::class,
                'entry_options' => ['label' => false],
                // 'allow_add' => true,
                // 'allow_delete' => true,
                // 'by_reference' => false,
                // 'prototype' => true,
                'attr' => ['class' => 'website-collection'],
            ])
            ->add('domain', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Nom de domaine',
            ])
            ->add('domain_suscribe', ChoiceType::class, [
                'label' => 'À souscrire',
                'required' => true,
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
            ])
            ->add('domain_existing', ChoiceType::class, [
                'label' => 'Existant',
                'required' => true,
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
            ])
            ->add('host', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Hébergeur',
            ])
            ->add('host_login', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Login',
            ])
            ->add('host_password', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Mot de passe',
            ])
            ->add('artisan', ChoiceType::class, [
                'label' => 'Pack Artisan',
                'choices' => [
                    'Pack présence' => 'presence',
                    'Pack référence' => 'reference',
                    'Pack expérience' => 'experience',
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('avocat', ChoiceType::class, [
                'label' => 'Pack Artisan',
                'choices' => [
                    'Pack éloquence' => 'eloquence',
                    'Pack prestance' => 'prestance',
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('logo_reused', ChoiceType::class, [
                'label' => 'Devons-nous reprendre le logo existant',
                'required' => true,
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
            ])
            ->add('content_reused', ChoiceType::class, [
                'label' => 'Devons-nous reprendre les contenus du site existant',
                'required' => true,
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
            ])
            ->add('other_data', ChoiceType::class, [
                'label' => 'Avez-vous d\'autres contenus (texte et image) à nous fournir et à afficher sur le site web',
                'required' => true,
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
            ])
            ->add('files_uploaded', FileType::class, [
                'label' => 'Choisir un fichier',
                'multiple' => true,
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'accept' => 'application/pdf, image/*',
                    'multiple' => true,
                ]
            ])
            ->add('more_information', TextareaType::class, [
                'label' => 'Informations complémentaires',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => [
                    'class' => 'btn btn-primary rounded-pill mx-auto px-5',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Brief::class,
        ]);
    }
}