<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Localite;
use AppBundle\Repository\LocaliteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class SearchController extends Controller
{

    public function renderSearchBarAction(Request $request)
    {
        $defaultData = array('message'=>'blablabla');
        $form = $this->createFormBuilder($defaultData)
            ->setMethod('GET')
            ->setAction($this->generateUrl('search'))
            ->add('motCle',TextType::class,array(
                'required' => false,

            ))
//            ->add('localite',TextType::class,array(
//                'required' => false
//            ))

            ->add('localite',EntityType::class,array(
                'class'=> 'AppBundle:Localite',
                'query_builder' => function (LocaliteRepository $qb){
                    return $qb->createQueryBuilder('l')
                        ->leftJoin('l.codePostal','cp')->addSelect('cp')->orderBy('cp.codePostal');
                },
                'choice_label'=> function(Localite $localite){
                    return $localite->getNomAffichage();
                },
                'placeholder' => 'Localite',
                'required'=>false,
            ))

            ->add('categorie',EntityType::class,array(
                'class'=> 'AppBundle:CategorieDeServices',
                'choice_label'=> 'nom', 'multiple' => 'true',
                'placeholder' => 'Categorie',
                'required'=>false,
            ))
            ->add('search',SubmitType::class,array(
                'attr'=> array('class'=>'search'),
            ))
            ->getForm();


        return $this->render('lib/search/searchbar.html.twig',
            [
                'form'=>$form->createView()
            ]
        );
    }
}
