<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class FavorisType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prestataire_id', HiddenType::class, array(
                'data' => 'addRemove',
                'attr' => array(
                    'class' => 'btn btn-primary'
                ),
                'mapped' => false,
            ))
            ->add('addRemove', SubmitType::class);
    }


}
