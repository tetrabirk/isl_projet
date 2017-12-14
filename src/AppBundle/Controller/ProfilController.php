<?php
/**
 * Created by PhpStorm.
 * User: Vi
 * Date: 17/10/2017
 * Time: 18:53
 */

namespace AppBundle\Controller;

use AppBundle\Entity\CategorieDeServices;
use AppBundle\Entity\Utilisateur;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Controller\DefaultController as DC;




class ProfilController extends Controller
{

    //////        INTERNAUTE: 62       PRESTATAIRE: 32
    public function getUtilisateur($id)
    {
        $repository = $this->getDoctrine()->getRepository(Utilisateur::class);
        $data = $repository->findOneBy(array('id'=> $id));

        return $data;
    }

    /**
     * @Route("/profil/{id}", defaults ={"id"=null}, name="profil", requirements={"id": "\d+"})
     */
    public function profilAction()
    {
        $user = $this->getUtilisateur(98);
        $userType= $user->getType();
        if ($userType =="Prestataire"){
            return $this->render('profil/prestataire.html.twig',array(
                'utilisateur' => $user,
            ));
        }else{
            return $this->render('profil/internaute.html.twig',array(
                'utilisateur' => $user,
            ));
        }

    }

    /**
     * @Route("/profil/suppression", name="profil_suppression")
     */
    public function profilSuppressionAction()
    {
        return $this->render('profil/profil_suppression.html.twig',array(
        ));
    }






    /**
     * @Route("/profil/stages", name="stages")
     */
    public function stagesAction()
    {
        $user = $this->getUtilisateur(98);

        return $this->render('profil/stages/stages.html.twig',array(
            'utilisateur' => $user,
        ));
    }

    /**
     * @Route("/stages/nouveau", name="stage_nouveau")
     */
    public function stageNouveauAction()
    {
        return $this->render('profil/stages/stage_nouveau.html.twig',array(
        ));
    }

    /**
     * @Route("/stages/mise_a_jour", name="stage_mise_a_jour")
     */
    public function stageMiseAJourAction()
    {
        return $this->render('profil/stages/stage_mise_a_jour',array(
        ));
    }

    /**
     * @Route("/stages/suppression", name="stage_suppression")
     */
    public function stageSuppressionAction()
    {
        return $this->render('profil/stages/stages',array(
        ));
    }






    /**
     * @Route("/profil/promos", name="promos")
     */
    public function promosAction()
    {
        $user = $this->getUtilisateur(98);

        return $this->render('profil/promotions/promos.html.twig',array(
            'utilisateur' => $user,

        ));
    }

    /**
     * @Route("/promos/nouveau", name="promo_nouveau")
     */
    public function promoNouveauAction()
    {
        return $this->render('profil/promotions/promo_nouveau.html.twig',array(
        ));
    }

    /**
     * @Route("/promos/mise_a_jour", name="promo_mise_a_jour")
     */
    public function promoMiseAJourAction()
    {
        return $this->render('profil/promotions/promo_mise_a_jour',array(
        ));
    }

    /**
     * @Route("/promos/suppression", name="promo_suppression")
     */
    public function promoSuppressionAction()
    {
        return $this->render('profil/promos/promos',array(
        ));
    }





}
