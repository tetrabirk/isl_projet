<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrestataireType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('adresseRue', TextType::class, array(
                'required' => false,
            ))
            ->add('adresseNum', TextType::class, array(
                'label' => 'Numéro',
                'required' => false,
            ))
//            ->add('localite',LocaliteType::class, array(
//                'label' => false,
//                'required'=>false,
//            ))
            ->add('nom', TextType::class, array())
            ->add('siteInternet', UrlType::class, array(
                'required' => false,
            ))
            ->add('emailContact', EmailType::class, array(
                'label' => 'Email de contact',
                'required' => false,
            ))
            ->add('telephone', TextType::class, array(
                'label' => 'Téléphone',
                'required' => false,
            ))
            ->add('numTVA', TextType::class, array(
                'label' => 'Numéro de TVA',
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
//            ->add('categories', CollectionType::class, array(
//                'entry_type' => CategorieDeServicesType::class,
//                'allow_add' => true,
//                'allow_delete' => true,
//                'label' => 'Categories'
//
//            ))
            ->add('logo',ImageType::class,array(
                'label' => 'logo',
                'required'=>false,
            ))

            ->add('enregistrer', SubmitType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Prestataire'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_prestataire';
    }


}
