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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Controller\DefaultController as DC;

use AppBundle\Entity\Prestataire;


class MenuController extends Controller
{
    public function getMenu($type = null)
    {
        if ($type != null) {
            $menu = 'menuAdmin';

        }else{
            $menu = [
                ['nom' => 'Prestataires', 'href' => 'prestataire', 'submenu' =>
                    [
                        ['nom' => 'test', 'href' => 'homepage'],
                        ['nom' => 'tesities', 'href' => 'homepage']
                    ]
                ],
                ['nom' => 'Services', 'href' => 'services'],
                ['nom' => 'News', 'href' => 'news'],
                ['nom' => 'Contact', 'href' => 'contact'],
                ['nom' => 'A propos de nous', 'href' => 'about']
            ];

        }
        return $menu;

    }

    public function renderMenuAction($type=null)
    {
        $menu = $this->getMenu();
        return $this->render('lib/menu.html.twig',array(
            'menu' => $menu,
        ));
    }
}