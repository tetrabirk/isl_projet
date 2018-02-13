<?php

namespace AppBundle\Form;

use AppBundle\Entity\Localite;
use AppBundle\Repository\LocaliteRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocaliteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

//            ->add('localite',EntityType::class,array(
//                'class'=> 'AppBundle:Localite',
//                'query_builder' => function (LocaliteRepository $qb){
//                    return $qb->createQueryBuilder('l')
//                        ->leftJoin('l.codePostal','cp')->addSelect('cp')->orderBy('cp.codePostal');
//                },
//                'choice_label'=> function(Localite $localite){
//                    return $localite->getNomAffichage();
//                },
//                'placeholder' => 'Code postal - Localité',
//                'required'=>false,
//                'empty_data' => null,
//                'attr' => ['data-select' => 'true'],
//                'label' => 'Code postal et Localité'
//
//            ))

            ->add('localite', EntityType::class,array(
                'class' => 'AppBundle:Localite',
                'choice_label' => 'localite',
                'attr' => ['data-select' => 'true'],

//            ))
//            ->add('codePostal', CodePostalType::class, array(
//                'label' => false,
            ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Localite'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_localite';
    }


}
