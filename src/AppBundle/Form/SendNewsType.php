<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;


class SendNewsType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('newsletter', EntityType::class, array(
                'class' => 'AppBundle\Entity\Newsletter',
                'choice_label'=>'titre',
                'label'=> 'Selectionne une newsletter à envoyer',
                'choice_value'=>'id'
            ))
            ->add('Envoyer a tout les abbonnes', SubmitType::class);
    }

}
