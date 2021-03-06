<?php

namespace AppBundle\Form;

use AppBundle\Entity\Localite;
use AppBundle\Repository\CategorieDeServicesRepository;
use AppBundle\Repository\LocaliteRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SearchType extends AbstractType
{
    private $router;
    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('GET')
            ->setAction($this->router->generate('search',array(),UrlGeneratorInterface::ABSOLUTE_URL))
            ->add('motCle',TextType::class,array(
                'required' => false,
                'empty_data' => null,
                'attr' => ['placeholder'=>'Mots-Clés'],
            ))

//            ->add('localite',LocaliteType::class, array(
//                'label' => false,
//                'required'=>false,
//                'empty_data' => null,
//                'attr' => ['data-select' => 'true'],
//            ))


            ->add('localite', EntityType::class,array(
                'class' => 'AppBundle:Localite',
                'choice_label' => 'nomAffichage',
                'placeholder' => 'Localité',
                'label' => 'Code Postal - Localité',
                'required'=>false,
                'attr' => ['data-select' => 'true'],

            ))

            ->add('categorie',EntityType::class,array(
                'class'=> 'AppBundle:CategorieDeServices',
                'query_builder'=> function(CategorieDeServicesRepository $repo){
                    return $repo->getQBCategValide();
                },
                'choice_label'=> 'nom',
                'multiple' => 'true',
                'placeholder' => 'Categorie',
                'required'=>false,
                'empty_data' => null,
                'attr' => ['data-select' => 'true'],

            ))
            ->add('search',SubmitType::class,array(
                'attr'=> array('class'=>'search'),
            ))
        ;
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
        return '';
    }



}
