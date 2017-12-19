<?php
/**
 * Created by PhpStorm.
 * User: Vi
 * Date: 17/10/2017
 * Time: 18:53
 */

namespace AppBundle\Controller;

use AppBundle\Entity\CategorieDeServices;
use AppBundle\Entity\Commentaire;
use AppBundle\Repository\CommentaireRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityRepository;

use AppBundle\Entity\Prestataire;
use AppBundle\Repository\PrestataireRepository;
use AppBundle\Repository\CategorieDeServicesRepository;

class PrestataireController extends Controller
{


//TODO : entities : add image, slug
//TODO : get : categories des prestataires, notes moyennes, promotions, stages


    /**
     * @Route("/prestataire/{slug}", defaults ={"slug"=null}, name="prestataire")
     */
    public function prestatairesAction($slug)
    {
        /** @var CategorieDeServicesRepository $cr */
        $cr = $this->getDoctrine()->getRepository(CategorieDeServices::class);
        $categories = $cr->findCategoriesDeServices();

        if ($slug != null) {
            $prestataire = $this->getRepo()->findOneWithEverythingBySlug($slug);

            return $this->render('public/prestataires/prestataire_single.html.twig', array(
                'categories' => $categories,
                'prestataire' => $prestataire,
            ));
        } else {
            $prestataires = $this->getRepo()->findAllWithEverything();
            return $this->render('public/prestataires/prestataires_all.html.twig', array(
                'prestataires' => $prestataires,
                'categories' => $categories,
            ));
        }
    }

    public function prestatairesByCategAction($categ)
    {
        $prestataires = $this->getRepo()->findAllWithEverythingByCateg($categ);;
        return $this->render('lib/list/prestataires.html.twig', array(
            'prestataires' => $prestataires,
        ));
    }

    public function nLastPrestatairesAction($n)
    {
        $prestataires = $this->getRepo()->findNMostRecentBasic($n);
        return $this->render('lib/list/prestataires_basic.html.twig',array(
            'prestataires' => $prestataires,
    ));
    }

    public function getRepo()
    {
        /** @var PrestataireRepository $pr */
        $pr = $this->getDoctrine()->getRepository(Prestataire::class);
        return $pr;
    }

}