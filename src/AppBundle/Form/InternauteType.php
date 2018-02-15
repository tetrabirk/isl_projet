<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class InternauteType extends AbstractType
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
//            ))
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class, array(
                'required' => false,
            ))
            ->add('avatar', ImageType::class, array(
                'label' => 'avatar',
                'required' => false,
            ))
            ->add('newsletter', ChoiceType::class,array(
                'choices' => array(
                    'oui' => true,
                    'non' => false,
                ),
                'empty_data' => 'true',
                'label' => "Inscription à la Newsletter",
                'required' => false
            ))
            ->add('enregistrer', SubmitType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Internaute'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_internaute';
    }


}
