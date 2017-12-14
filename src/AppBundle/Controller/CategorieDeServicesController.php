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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Repository\CategorieDeServicesRepository;





class CategorieDeServicesController extends Controller
{

    //TODO creer un fichier où je mettrais tt les fonction "getqqlchose" pour éviter les répétitions

    public function getRepo()
    {
        /** @var CategorieDeServicesRepository $cr */
        $cr = $this->getDoctrine()->getRepository(CategorieDeServices::class);
        return $cr;
    }

    /**
     * @Route("/services/{slug}", defaults ={"slug"=null}, name="services")
     */
    public function categoriesDeServicesAction($slug)
    {

        $categories = $this->getRepo()->findCategoriesDeServices($slug);

        if ($slug != null){
            return $this->render('public/services/service_single.html.twig',array(
                'service' => $categories,
            ));
        }else{
            return $this->render('public/services/services_all.html.twig',array(
                'services' => $categories,
            ));
        }


    }

}