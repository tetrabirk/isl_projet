<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class StageController extends Controller
{

    /**
     * @Route("/profil/stages", name="stages")
     */
    public function stagesAction()
    {

        return $this->render('profil/stages/stages.html.twig',array(
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
        return $this->render('profil/stages/stage_mise_a_jour.html.twig',array(
        ));
    }

    /**
     * @Route("/stages/suppression", name="stage_suppression")
     */
    public function stageSuppressionAction()
    {
        return $this->render('profil/stages/stages.html.twig',array(
        ));
    }




}
