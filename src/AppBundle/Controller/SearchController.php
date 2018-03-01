<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Localite;
use AppBundle\Form\SearchType;
use AppBundle\Repository\LocaliteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class SearchController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function renderSearchBarAction(Request $request)
    {
        $form = $this->get('form.factory')->create(SearchType::class);

        return $this->render('lib/search/searchbar.html.twig',
            [
                'form'=>$form->createView()
            ]
        );
    }


}
