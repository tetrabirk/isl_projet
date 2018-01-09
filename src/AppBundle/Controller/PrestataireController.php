<?php
/**
 * Created by PhpStorm.
 * User: Vi
 * Date: 17/10/2017
 * Time: 18:53
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Prestataire;
use AppBundle\Repository\PrestataireRepository;
use Symfony\Component\HttpFoundation\Request;

class PrestataireController extends Controller
{


//TODO : get : categories des prestataires, notes moyennes, promotions, stages


    /**
     * @Route("/prestataire/{slug}", defaults ={"slug"=null}, name="prestataire")
     */
    public function prestatairesAction($slug, Request $request)
    {
        if ($slug != null) {
            $prestataire = $this->getRepo()->findOneWithEverythingBySlug($slug);

            return $this->render('public/prestataires/prestataire_single.html.twig', array(
                'prestataire' => $prestataire,
            ));
        } else {

            $query = $this->getRepo()->findAllWithEverything();
            $prestataires = $this->getPrestatairesWithPagination($query, $request);

            return $this->render('public/prestataires/prestataires_all.html.twig', array(
                'prestataires' => $prestataires,
            ));
        }
    }

    /**
     * @Route("/s/", name="search")
     */
    public function rechercheAction()
    {
        $request = Request::createFromGlobals();
        $motcle = $request->query->get('form')['motCle'] ?? null; // string
        $localite = $request->query->get('form')['localite'] ?? null; // id
        $categorie = ($request->query->get('form')['categorie']) ?? null ; //array d'id

        $query = $this->getRepo()->searchAll($categorie,$localite,$motcle);
        $prestataires = $this->getPrestatairesWithPagination($query, $request);

        return $this->render('public/prestataires/prestataires_all.html.twig', array(
            'prestataires' => $prestataires,
        ));

    }

    public function prestatairesByCategAction($categ, Request $request)
    {
        $query = $this->getRepo()->findAllWithEverythingByCateg($categ);
        $prestataires = $this->getPrestatairesWithPagination($query, $request);

        return $this->render('lib/list/prestataires.html.twig', array(
            'prestataires' => $prestataires,
        ));
    }

    public function nLastPrestatairesAction($n)
    {
        $prestataires = $this->getRepo()->findNMostRecentBasic($n);
        return $this->render('lib/list/prestataires_basic.html.twig', array(
            'prestataires' => $prestataires,
        ));
    }

    public function getPrestatairesWithPagination($query, $request)
    {

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */

        $paginator = $this->get('knp_paginator');
        $prestataires = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)

        );

        return $prestataires;
    }

    public function getRepo()
    {
        /** @var PrestataireRepository $pr */
        $pr = $this->getDoctrine()->getRepository(Prestataire::class);
        return $pr;
    }



}