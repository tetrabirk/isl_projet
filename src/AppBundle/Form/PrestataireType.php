<?php

namespace AppBundle\Form;

use AppBundle\Entity\CategorieDeServices;
use AppBundle\Entity\Image;
use AppBundle\Entity\Prestataire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrestataireType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addEventListener(FormEvents::POST_SET_DATA,
                array($this,"getLogo")
            )

            ->add('email', EmailType::class, array(
                'disabled' => true,
            ))
            ->add('adresseRue', TextType::class, array(
                'required' => false,
            ))
            ->add('adresseNum', TextType::class, array(
                'label' => 'Numéro',
                'required' => false,
            ))
            ->add('localite', EntityType::class, array(
                'class' => 'AppBundle:Localite',
                'choice_label' => 'nomAffichage',
                'placeholder' => 'Localité',
                'label' => 'Code Postal - Localité',
                'required' => false,
                'attr' => ['data-select' => 'true'],

            ))
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
                'choice_label' => function ($categories) {
                    /**
                     * @var CategorieDeServices $categories
                     */
                    $string =$categories->getNom();
                    if (!$categories->getValide()){
                        $string .= " (En attente de validation)";
                    }
                    return $string;
                },
                'multiple' => 'true',
                'placeholder' => 'Categorie',
                'required' => false,
                'empty_data' => null,
                'label' => 'Categories',
                'attr' => ['data-select' => 'true'],
                'by_reference' => false,

            ))
            ->add('newCategories', CollectionType::class, array(
                'entry_type' => CategorieDeServicesType::class,
                'attr' => ['class' => 'ttrbrk_newCategorie'],
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
                'mapped' => false

            ))
            ->add('logo', ImageType::class, array(
                'label' => 'logo',
                'required' => false,
            ))
            ->add('photos', CollectionType::class, array(
                'entry_type' => ImageType::class,

                'required' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
            ->add('enregistrer', SubmitType::class);
    }

    public function getLogo(FormEvent $event){
        /**@var Prestataire $prestataire*/
        $prestataire = $event->getData();
        $logo = $prestataire->getLogo();
        $form = $event->getForm();
        if($logo instanceof Image && ($logo->getId())!=null){
            $form->add('logo', ImageType::class, array(
                'label' => 'logo',
                'required' => false,
            ));

        }else{
            $form->add('logo', ImageType::class, array(
                'label' => 'logo',
                'required' => true,
            ));

        }
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
