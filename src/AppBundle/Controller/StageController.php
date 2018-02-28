<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Stage;
use AppBundle\Form\StageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use AppBundle\Repository\StageRepository;

class StageController extends Controller
{

    /**
     * @Route("/profil/stages/{id}", defaults={"id"=-1}, name="stages")
     */
    public function stagesAction($id, Request $request)
    {
        if ($id == 'add') {
            $stage = new Stage();
        } else {
            $stage = $this->getRepo()->findOneById($id);
        }

        if ($id != -1) {
            return $this->loadStageForm($request, $stage);
        } else {
            return $this->render('profil/stages/stages.html.twig', array());
        }
    }

    /**
     * @Route("/profil/stages/delete/{id}", name="deleteStage")
     */
    public function stageDelete($id)
    {
        $stage = $this->getRepo()->findOneBy(array('id'=>$id));
        $em = $this->getDoctrine()->getManager();
        $em->remove($stage);
        $em->flush();
        return $this->redirectToRoute('stages');

    }


    public function loadStageForm($request, $stage)
    {
        $form = $this->get('form.factory')->create(StageType::class, $stage);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $this->flushStage($stage);
        }

        return $this->render('profil/stages/stage_single.html.twig', array(
            'form' => $form->createView(),
            'stage' => $stage
        ));
    }

    public function flushStage(Stage $stage)
    {
        $em = $this->getDoctrine()->getManager();
        $stage->setPrestataire($this->getUser());

        if (is_null($stage->getId())) {
            $em->persist($stage);

        }
        $em->flush();
    }

    public function getRepo()
    {
        /** @var StageRepository $stage */
        $stage = $this->getDoctrine()->getRepository(Stage::class);
        return $stage;
    }

}
