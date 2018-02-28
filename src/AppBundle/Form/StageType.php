<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StageType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array(
                'label' => 'Intitulé du Stage',
                'error_bubbling'=>true,

            ))
            ->add('description', TextareaType::class, array(
                'label' => 'Description du Stage'
            ))
            ->add('tarif', MoneyType::class, array(
                'label' => 'Tarif',
                'error_bubbling'=>true,

            ))
            ->add('infoComplementaire', TextareaType::class, array(
                'label' => 'Informations Complémentaires',
                'required'=>false
            ))
            ->add('debut', DateType::class, array(
                'label' => 'Date de début du Stage',
                'widget' => 'choice',
                'error_bubbling'=>true,

            ))
            ->add('fin', DateType::class, array(
                'label' => 'Date de fin du Stage',
                'widget' => 'choice',
                'error_bubbling'=>true,

            ))
            ->add('affichageDe', DateType::class, array(
                'label' => 'Affichage à partir de:',
                'widget' => 'choice',
                'error_bubbling'=>true,

            ))
            ->add('affichageJusque', DateType::class, array(
                'label' => 'Affichage jusque',
                'widget' => 'choice',
                'error_bubbling'=>true,

            ))
            ->add('enregistrer', SubmitType::class)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Stage',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_stage';
    }


}
