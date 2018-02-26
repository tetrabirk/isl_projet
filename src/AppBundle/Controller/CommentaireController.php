<?php
/**
 * Created by PhpStorm.
 * User: Vi
 * Date: 17/10/2017
 * Time: 18:53
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Commentaire;
use AppBundle\Repository\CommentaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Prestataire;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CommentaireController extends Controller
{


    public function listCommentairesAction(Prestataire $prestataire = null)
    {

        $idPrestataire = $prestataire->getId();
        $commentaires = $this->getCommentaires($idPrestataire);


        return $this->render(':lib/list:commentaires.html.twig', array(
            'commentaires' => $commentaires,
        ));

    }

    /**
     * @Route("/profil/commentaires" , name="commentaires")
     */
    public function profilCommentaires()
    {
        return $this->render(':profil:commentaires.html.twig');
    }


    public function getCommentaires($idPrestataire)
    {
        /** @var CommentaireRepository $cr*/
        $cr = $this->getDoctrine()->getRepository(Commentaire::class);

        $commentaires = $cr->findCommentairesByIdPrestataire($idPrestataire);

        return $commentaires;
    }

}