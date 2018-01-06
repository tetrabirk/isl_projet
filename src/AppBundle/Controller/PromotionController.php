<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class PromotionController extends Controller
{

    /**
     * @Route("/profil/promos", name="promos")
     */
    public function promosAction()
    {

        return $this->render('profil/promotions/promos.html.twig',array(

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
        return $this->render('profil/promotions/promo_mise_a_jour.html.twig',array(
        ));
    }

    /**
     * @Route("/promos/suppression", name="promo_suppression")
     */
    public function promoSuppressionAction()
    {
        return $this->render('profil/promotions/promos.html.twig',array(
        ));
    }



}
