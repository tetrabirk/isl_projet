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
use AppBundle\Entity\Utilisateur;
use AppBundle\Form\AbusType;
use AppBundle\Form\CommentaireType;
use AppBundle\Repository\CommentaireRepository;
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
            $form = $this->addCommentaire($request, $prestataire);
            $formAbus = $this->addFormAbus($request,$slug);

            return $this->render('public/prestataires/prestataire_single.html.twig', array(
                'prestataire' => $prestataire,
                'form' => $form->createView(),
                'abus' => $formAbus->createView(),
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

    public function addFormAbus(Request $request,$slug)
    {
        $abus = new Abus;
        $formAbus = $this->get('form.factory')->create(AbusType::class, $abus);

        /** @var Request $request */

        if ($request->isMethod('POST') && $formAbus->handleRequest($request)->isValid()) {
            $id = ($formAbus->get('commentaire_id')->getData());
            $this->flushAbus($abus, $id);
        }
        return $formAbus;
    }

    public function flushAbus($abus, $id){
        /**@var Abus $abus */

        /** @var CommentaireRepository $cr*/
        $cr = $this->getDoctrine()->getRepository(Commentaire::class);
        $commentaire = $cr->findOneBy(array('id'=>$id));
        $abus->setCommentaire($commentaire);
        $em = $this->getDoctrine()->getManager();
        $em->persist($abus);
        $em->flush();
    }

    public function addCommentaire($request, $prestataire)
    {
        $newComment = new Commentaire();
        $form = $this->get('form.factory')->create(CommentaireType::class, $newComment);

        /** @var Request $request */

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $this->flushCommentaire($newComment, $prestataire);
        }
        return $form;

    }

    public function flushCommentaire($newComment, $prestataire)
    {
        /**@var Commentaire $newComment */
        $newComment->setCibleCommentaire($prestataire);
        /**@var Utilisateur $user */
        $user = $this->getUser();
        $newComment->setAuteurCommentaire($user);
        if ($user->getType() != 'Internaute') {
            $newComment->setCote(null);
        }
        /**@var Prestataire $prestataire */
        $prestataire->setMoyenneCote($this->getMoyenne($newComment, $prestataire));

        $em = $this->getDoctrine()->getManager();
        $em->persist($newComment);
        $em->persist($prestataire);
        $em->flush();

    }

    public function getMoyenne($newComment, $prestataire)
    {
        $cr = $this->getDoctrine()->getRepository(Commentaire::class);
        $cotesExistantes = ($cr->getCoteFromPrest($prestataire->getId()));
        $cotes = [];
        foreach ($cotesExistantes as $array) {
            array_push($cotes, $array['cote']);
        }
        /**@var Commentaire $newComment */
        $newCote = $newComment->getCote();
        array_push($cotes, $newCote);

        $moyenne = array_sum($cotes) / count($cotes);

        return $moyenne;

    }

    /**
     * @Route("/favoris", name="favoris")
     */
    public function addRemoveFavoris(Request $request){

        if ($request->isMethod('POST')) {
            $slugPrestataire = ($request->get('favoris'));
            dump($slugPrestataire);
            $user = $this->getUser();
            //TODO update user -> if prest if favoris remove else add

        }
        return $this->redirectToRoute('prestataire',array('slug'=>$slugPrestataire));


    }
}