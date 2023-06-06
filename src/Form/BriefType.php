<?php

namespace App\Form;

use App\Entity\Brief;
use App\Form\DomainType;
use App\Form\WebsiteType;
use App\Form\AttachmentType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
                'placeholder' => 'Sélectionner le statut du brief',
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
                'constraints' => [
                    new Regex([
                        'pattern' => "/^[a-zA-ZÀ-ÿ\s-]+$/",
                        'message' => 'Le nom {{ value }} n\'est pas valide.',
                    ]),
                ],
                'required' => false,
            ])
            ->add('customer_lastname', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Prénom du client',
                'constraints' => [
                    new Regex([
                        'pattern' => "/^[a-zA-ZÀ-ÿ\s-]+$/",
                        'message' => 'Le prénom {{ value }} n\'est pas valide.',
                    ]),
                ],
                'required' => false,
            ])
            ->add('company', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Nom de la société',
                'constraints' => [
                    new Regex([
                        'pattern' => "/^[a-zA-ZÀ-ÿ\s-]+$/",
                        'message' => 'Le nom de la société "{{ value }}" n\'est pas valide.',
                    ]),
                ],
                'required' => false,
            ])
            ->add('phone', TelType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Téléphone de l\'entreprise',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\+33[1-9][0-9]{8}$/',
                        'message' => 'Le numéro de téléphone doit être au format +33xxxxxxxxx',
                    ]),
                ],
                'required' => false,
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'E-mail du contact',
                'constraints' => [
                    new Email([
                        'message' => 'L\'adresse email n\'est pas valide.',
                    ]),
                ],
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
                'placeholder' => 'Choisir le type de pack',
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
            ->add('websites', CollectionType::class, [
                'entry_type' => WebsiteType::class,
                'entry_options' => ['label' => false],
                'allow_delete' => true,
                'allow_add' => true,
                'by_reference' => false,
                'prototype' => true,
                'required' => false,
            ])
            ->add('domains', CollectionType::class, [
                'entry_type' => DomainType::class,
                'entry_options' => ['label' => false],
                'allow_delete' => true,
                'allow_add' => true,
                'by_reference' => false,
                'prototype' => true,
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
            ->add('attachments', CollectionType::class, [
                'entry_type' => AttachmentType::class,
                'entry_options' => ['label' => false],
                'allow_delete' => true,
                'allow_add' => true,
                'by_reference' => false,
                'required' => false,
                'label' => false,
            ])
            ->add('more_information', TextareaType::class, [
                'label' => 'Informations complémentaires',
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[^<>]*$/',
                        'message' => 'La description ne doit pas contenir de code HTML ou de scripts.',
                    ]),
                ],
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
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
        ]);
    }
}
