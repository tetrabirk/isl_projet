<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('type', ChoiceType::class, array(
                'choices' => array(
                    'Internaute' => 'Internaute',
                    'Prestataire' => 'Prestataire',
                ),
                'placeholder' => '...',
                'expanded' => false,
                'mapped' => false,
            ))
            ->add('email', EmailType::class, array(
                'required' => true
            ))
            ->add('motDePasseNonCripte', RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passes doivent être identique',
                'required' => true,
                'first_options' => array('label'=>'Mot de Passe'),
                'second_options' => array('label'=>'Répétez Mot de Passe'),
            ))
            ->add('Envoyer', SubmitType::class, array(
                    'attr' => array('class' => 'btn btn-primary pull-right'),
                )
            );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Utilisateur'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_utilisateur';
    }


}
