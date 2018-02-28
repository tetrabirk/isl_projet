<?php

namespace AppBundle\Form;

use AppBundle\Entity\Image;
use AppBundle\Entity\Internaute;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
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
            ->addEventListener(FormEvents::POST_SET_DATA,
                array($this,"getAvatar")
            )

            ->add('email', EmailType::class,array(
                'disabled' => true,
                'error_bubbling'=>true,
            ))
            ->add('adresseRue', TextType::class, array(
                'required' => false,
                'error_bubbling'=>true,

            ))
            ->add('adresseNum', TextType::class, array(
                'label' => 'Numéro',
                'required' => false,
                'error_bubbling'=>true,

            ))
            ->add('localite', EntityType::class,array(
                'class' => 'AppBundle:Localite',
                'choice_label' => 'nomAffichage',
                'placeholder' => 'Localité',
                'label' => 'Code Postal - Localité',
                'required'=>false,
                'attr' => ['data-select' => 'true'],
                'error_bubbling'=>true,

            ))
            ->add('nom', TextType::class, array(
                'error_bubbling'=>true,
            ))
            ->add('prenom', TextType::class, array(
                'required' => false,
                'error_bubbling'=>true,

            ))

            ->add('newsletter', ChoiceType::class,array(
                'choices' => array(
                    'oui' => true,
                    'non' => false,
                ),
                'label' => "Inscription à la Newsletter",
                'required' => true,
                'error_bubbling'=>true,

            ))
            ->add('enregistrer', SubmitType::class);
    }

    public function getAvatar(FormEvent $event){
        /**@var Internaute $internaute*/
        $internaute = $event->getData();
        $avatar=$internaute->getAvatar();
        $form = $event->getForm();
        if($avatar instanceof Image && ($avatar->getId())!=null){
            $form->add('avatar', ImageType::class, array(
                'label' => 'avatar',
                'required' => false,
            ));

        }else{
            $form->add('avatar', ImageType::class, array(
                'label' => 'avatar',
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
