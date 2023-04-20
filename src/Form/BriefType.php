<?php

namespace App\Form;

use App\Entity\Brief;
use App\Form\WebsiteType;
use Symfony\Component\Form\AbstractType;
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
                'required' => false,
                'multiple' => false,
                'choices' => [
                    'Nouveau' => 'Nouveau',
                    'À valider' => 'À valider',
                    'À compléter' => 'À compléter',
                    'Validé' => 'Validé',
                    'En cours' => 'En cours',
                    'Terminé' => 'Terminé',
                ],
                'attr' => [
                    'class' => 'form-select'
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('customer_name', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Nom du client',
                'required' => false,
            ])
            ->add('customer_lastname', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Prénom du client',
                'required' => false,
            ])
            ->add('company', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Nom de la société',
                'required' => false,
            ])
            ->add('phone', TelType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Téléphone de l\'entreprise',
                'required' => false,
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Email du contact',
                'required' => false,
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Pack artisan' => "Pack artisan",
                    'Pack avocat' => "Pack avocat",
                ],
                'attr' => [
                    'class' => 'form-select'
                ],
                'label' => 'Typologie',
                'required' => false,
            ])
            ->add('online_date', DateType::class, [
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Date de mise en ligne souhaitée',
                'required' => false,
            ])
            ->add('website', CollectionType::class, [
                'entry_type' => WebsiteType::class,
                'entry_options' => ['label' => false],
                'allow_delete' => true,
                'allow_add' => true,
                'by_reference' => false,
                'attr' => ['class' => 'website-collection'],
                'required' => false,
            ])
            ->add('domain', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Nom de domaine',
                'required' => false,
            ])
            ->add('domain_suscribe', ChoiceType::class, [
                'label' => 'À souscrire',
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
            ])
            ->add('domain_existing', ChoiceType::class, [
                'label' => 'Existant',
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
                'required' => false,
            ])
            ->add('host_login', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Login',
                'required' => false,
            ])
            ->add('host_password', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Mot de passe',
                'required' => false,
            ])
            ->add('artisan', ChoiceType::class, [
                'label' => 'Pack Artisan',
                'choices' => [
                    'Pack présence' => 'Présence',
                    'Pack référence' => 'Référence',
                    'Pack expérience' => 'Expérience',
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('avocat', ChoiceType::class, [
                'label' => 'Pack Artisan',
                'choices' => [
                    'Pack éloquence' => 'Éloquence',
                    'Pack prestance' => 'Prestance',
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('logo_reused', ChoiceType::class, [
                'label' => 'Devons-nous reprendre le logo existant',
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
            ])
            ->add('content_reused', ChoiceType::class, [
                'label' => 'Devons-nous reprendre les contenus du site existant',
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
            ])
            ->add('other_data', ChoiceType::class, [
                'label' => 'Avez-vous d\'autres contenus (texte et image) à nous fournir et à afficher sur le site web',
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
            ])
            ->add('files_uploaded', FileType::class, [
                'label' => 'Choisir un fichier',
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
