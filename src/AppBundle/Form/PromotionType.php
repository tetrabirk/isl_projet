<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PromotionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array(
                'label' => 'Intitulé de la Promotion'
            ))
            ->add('description', TextareaType::class, array(
                'label' => 'Description de la Promotion',
            ))
            ->add('documentPDF', DocumentPDFType::class,array(
                'label' => 'Document PDF',
                'required'=>false,
                'error_bubbling'=>true,

            ))
            ->add('debut', DateType::class, array(
                'label' => 'Date de début de la Promotion',
                'widget' => 'choice',
            ))
            ->add('fin', DateType::class, array(
                'label' => 'Date de fin de la Promotion',
                'widget' => 'choice',
                'error_bubbling'=>true,

            ))
            ->add('affichageDe', DateType::class, array(
                'label' => 'Affichage à partir de:',
                'widget' => 'choice'
            ))
            ->add('affichageJusque', DateType::class, array(
                'label' => 'Affichage jusque',
                'widget' => 'choice',
                'error_bubbling'=>true,

            ))
            ->add('categories', EntityType::class, array(
                'class' => 'AppBundle:CategorieDeServices',
                'choice_label' => 'nom',
                'multiple' => 'true',
                'placeholder' => 'Categorie',
                'required' => false,
                'empty_data' => null,
                'label' => 'Categories',
                'attr' => ['data-select' => 'true'],

            ))
            ->add('enregistrer', SubmitType::class)

        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Promotion'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_promotion';
    }


}
