<?php
/**
 * Created by PhpStorm.
 * User: Vi
 * Date: 17/10/2017
 * Time: 18:53
 */

namespace AppBundle\Controller;

use AppBundle\Entity\CategorieDeServices;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Repository\CategorieDeServicesRepository;


class CategorieDeServicesController extends Controller
{

    /**
     * @Route("/services/{slug}", defaults ={"slug"=null}, name="services")
     */
    public function categoriesDeServicesAction($slug)
    {

        $categories = $this->getRepo()->findCategoriesDeServices($slug);

        if ($slug != null) {
            return $this->render('public/services/service_single.html.twig', array(
                'service' => $categories,
            ));
        } else {
            return $this->render('public/services/services_all.html.twig', array(
                'services' => $categories,
            ));
        }
    }

    public function serviceEnAvantAction()
    {
        $categorie = $this->getRepo()->findEnAvant();

        return $this->render('lib/widget/service_en_avant.html.twig', array(
            'service' => $categorie,
        ));
    }

    public function sliderImageCategAction()
    {
        $categories = $this->getRepo()->findCategoriesDeServices();

        return $this->render('lib/slider_front.html.twig', array(
            'categories' => $categories
        ));
    }

    public function getRepo()
    {
        /** @var CategorieDeServicesRepository $cr */
        $cr = $this->getDoctrine()->getRepository(CategorieDeServices::class);
        return $cr;
    }

}