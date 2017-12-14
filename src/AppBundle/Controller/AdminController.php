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




class AdminController extends Controller
{

    /**
     * @Route("/admin/{route1}", defaults ={"route1"=null}, name="admin")
     */
    public function renderAdmin($route1)
    {
        switch ($route1){
            case 'prestataires':
                return $this->render('admin/adminPrestataires.html.twig',array(
                    'pageTitle' => "AdminController - PrestataireController",
                ));
                break;
            case 'internautes':
                return $this->render('admin/adminInternautes.html.twig',array(
                    'pageTitle' => "AdminController - Internautes",
                ));
                break;
            case 'slider':
                return $this->render('admin/adminSlider.html.twig',array(
                    'pageTitle' => "AdminController - Slider",
                ));
                break;
            case 'commentaires':
                return $this->render('admin/adminCommentaires.html.twig',array(
                    'pageTitle' => "AdminController - CommentaireController",
                ));
                break;
            case 'services':
                return $this->render('admin/adminServices.html.twig',array(
                    'pageTitle' => "AdminController - Services",
                ));
                break;
            default:
                return $this->render('admin/admin.html.twig',array(
                    'pageTitle' => "AdminController",
                ));
                break;
        }
    }
}