<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
            ->add('email',EmailType::class)
            ->add('adresseRue', TextType::class)
            ->add('adresseNum', TextType::class)
            ->add('localite',LocaliteType::class)
            ->add('nom', TextType::class)
            ->add('siteInternet', UrlType::class)
            ->add('emailContact', EmailType::class)
            ->add('telephone', TextType::class)
            ->add('numTVA', TextType::class)
            ->add('categories', CollectionType::class, array(
                'entry_type' => CategorieDeServicesType::class,
                'allow_add' => true,
                'allow_delete' => true
            ))
            ->add('photos', CollectionType::class, array(
                'entry_type' => ImageType::class,
                'allow_add' => true,
                'allow_delete' => true
            ))
            ->add('logo', ImageType::class)
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
