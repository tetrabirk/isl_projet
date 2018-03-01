<?php
/**
 * Created by PhpStorm.
 * User: Vi
 * Date: 17/10/2017
 * Time: 18:53
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Abus;
use AppBundle\Entity\Commentaire;
use AppBundle\Entity\Internaute;
use AppBundle\Entity\Utilisateur;
use AppBundle\Form\AbusType;
use AppBundle\Form\CommentaireType;
use AppBundle\Form\FavorisType;
use AppBundle\Repository\CommentaireRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Prestataire;
use AppBundle\Repository\PrestataireRepository;
use Symfony\Component\HttpFoundation\Request;

class PrestataireController extends Controller
{

    /** @var Prestataire $prestataire */
    public $prestataire;

    /**
     * @Route("/prestataire/{slug}", defaults ={"slug"=null}, name="prestataire")
     *
     * @param $slug
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function prestatairesAction($slug, Request $request)
    {
        if ($slug != null) {
            $this->prestataire = $this->getRepo()->findOneWithEverythingBySlug($slug);
            $form = $this->addCommentaire($request);
            $formAbus = $this->addFormAbus($request);
            $formFavoris = $this->addFormFavoris($request);

            return $this->render('public/prestataires/prestataire_single.html.twig', array(
                'prestataire' => $this->prestataire,
                'form' => $form->createView(),
                'abus' => $formAbus->createView(),
                'favoris' => $formFavoris->createView(),
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
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function rechercheAction(Request $request)
    {

        $motcle = $request->query->get('motCle') ?? null; // string
        $localite = $request->query->get('localite') ?? null; // id
        $categorie = $request->query->get('categorie') ?? null; //array d'id

        $query = $this->getRepo()->searchAll($categorie, $localite, $motcle);

        $prestataires = $this->getPrestatairesWithPagination($query, $request);


        return $this->render('public/prestataires/prestataires_all.html.twig', array(
            'prestataires' => $prestataires,
        ));

    }

    /**
     * @param $categ
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function prestatairesByCategAction($categ, Request $request)
    {
        $query = $this->getRepo()->findAllWithEverythingByCateg($categ);
        $prestataires = $this->getPrestatairesWithPagination($query, $request);

        return $this->render('lib/list/prestataires.html.twig', array(
            'prestataires' => $prestataires,
        ));
    }

    /**
     * @param $n
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function nLastPrestatairesAction($n)
    {
        $prestataires = $this->getRepo()->findNMostRecentBasic($n);
        return $this->render('lib/list/prestataires_basic.html.twig', array(
            'prestataires' => $prestataires,
        ));
    }

    /**
     * @param $query
     * @param $request
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function getPrestatairesWithPagination($query, $request)
    {

        /** @var $paginator \Knp\Component\Pager\Paginator */

        $paginator = $this->get('knp_paginator');
        $prestataires = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)

        );

        return $prestataires;
    }

    /**
     * @return PrestataireRepository
     */
    public function getRepo()
    {
        /** @var PrestataireRepository $pr */
        $pr = $this->getDoctrine()->getRepository(Prestataire::class);
        return $pr;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\Form\FormInterface
     */
    public function addFormAbus($request)
    {
        $abus = new Abus;
        $formAbus = $this->get('form.factory')->create(AbusType::class, $abus);

        if ($request->isMethod('POST') && $formAbus->handleRequest($request)->isValid()) {
            $id = ($formAbus->get('commentaire_id')->getData());
            $this->flushAbus($abus, $id);
        }
        return $formAbus;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\Form\FormInterface
     */
    public function addFormFavoris($request)
    {
        $formFavoris = $this->get('form.factory')->create(FavorisType::class);

        if ($request->isMethod('POST') && $formFavoris->handleRequest($request)->isValid()) {
            $this->addRemoveFavoris();
        }
        return $formFavoris;
    }

    /**
     * @param Abus $abus
     * @param $id
     */
    public function flushAbus($abus, $id)
    {

        /** @var CommentaireRepository $cr */
        $cr = $this->getDoctrine()->getRepository(Commentaire::class);
        $commentaire = $cr->findOneBy(array('id' => $id));

        $abus->setCommentaire($commentaire);

        $em = $this->getDoctrine()->getManager();
        $em->persist($abus);
        $em->flush();
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\Form\FormInterface
     */
    public function addCommentaire($request)
    {
        $newComment = new Commentaire();
        $form = $this->get('form.factory')->create(CommentaireType::class, $newComment);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $this->flushCommentaire($newComment);
        }
        return $form;

    }

    /**
     * @param Commentaire $newComment
     */
    public function flushCommentaire($newComment)
    {
        $newComment->setCibleCommentaire($this->prestataire);
        /**@var Utilisateur $user */
        $user = $this->getUser();
        $newComment->setAuteurCommentaire($user);
        if ($user->getType() != 'Internaute') {
            $newComment->setCote(null);
        }

        $this->prestataire->setMoyenneCote($this->getMoyenne($newComment));

        $em = $this->getDoctrine()->getManager();
        $em->persist($newComment);
        $em->persist($this->prestataire);
        $em->flush();

    }


    /**
     * @param Commentaire $newComment
     * @return float|int
     */
    public function getMoyenne($newComment)
    {
        $cr = $this->getDoctrine()->getRepository(Commentaire::class);
        $cotesExistantes = ($cr->getCoteFromPrest($this->prestataire->getId()));
        $cotes = [];
        foreach ($cotesExistantes as $array) {
            array_push($cotes, $array['cote']);
        }
        $newCote = $newComment->getCote();
        array_push($cotes, $newCote);

        $moyenne = array_sum($cotes) / count($cotes);

        return $moyenne;

    }

    /*
     *J'ai un prblm avec cette fonction, elle ajoute et retire correctement les favoris de ma DB mais elle modifie
     * tj l'affichage de 1 après un submit, je n'ai pas eu le temps de trouver une solution
     */
    public function addRemoveFavoris()
    {

        $internaute = $this->getUser();
        if ($internaute instanceof Internaute) {
            $internauteFavoris = $this->prestataire->getInternautesFavoris();
            if ($internauteFavoris->contains($internaute)) {
                $internaute->removeFavoris($this->prestataire);
//                dump('remove');
            } else {
                $internaute->addFavoris($this->prestataire);
//                dump('add');
            };
            $em = $this->getDoctrine()->getManager();
            $em->persist($internaute);
            $em->flush();
        }
    }
}