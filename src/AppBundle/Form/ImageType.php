<?php

namespace AppBundle\Form;

use AppBundle\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageType extends AbstractType
{
    public $path;
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->addEventListener(
                FormEvents::POST_SET_DATA,
                array($this,"getPath")
            )

        ;


    }

    public function getPath(FormEvent $event){
        /**
         * @var Image $img
         */
        $img = $event->getData();
        $form = $event->getForm();
        if($img instanceof Image){
            $this->path=$img->getWebPath();
        }
        $form->add('file',FileType::class,array(
            'label' => false,
            'attr' =>['img-path'=>$this->path],

        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Image'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_image';
    }


}
