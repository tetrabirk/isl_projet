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

use AppBundle\Entity\Prestataire;


class CommentaireController extends Controller
{
    public function getCommentaires($idPrestataire = null)
    {
        $repository = $this->getDoctrine()->getRepository(Commentaire::class);

        if($idPrestataire != null){
            $data = $repository->findOneBy(
                array('cibleCommentaire'=> $idPrestataire)
            );
        }else {
            $data = $repository->findAll();
        }
        return $data;

    }
}