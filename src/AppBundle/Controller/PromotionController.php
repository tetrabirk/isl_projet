<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Promotion;
use AppBundle\Form\PromotionType;
use AppBundle\Repository\PromotionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PromotionController extends Controller
{

    /**
     * @Route("/profil/promotions/{id}", defaults={"id"=null}, name="promotions")
     *
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function promotionsAction($id, Request $request)
    {

        if($id == 'add'){
            $promotion = new Promotion();
        }else{
            $promotion = $this->getRepo()->findOneById($id);
        }

        if ($id != null) {
            return $this->loadPromotionForm($request,$promotion);
        } else {
            return $this->render('profil/promotions/promos.html.twig', array());
        }
    }


    /**
     * @Route("/profil/promotions/delete/{id}", name="deletePromotion")
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function stageDelete($id)
    {
        $promotion = $this->getRepo()->findOneBy(array('id'=>$id));

        $em = $this->getDoctrine()->getManager();
        $em->remove($promotion);
        $em->flush();

        return $this->redirectToRoute('promotions');

    }


    /**
     * @param Request $request
     * @param $promotion
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loadPromotionForm($request,$promotion){
        $form = $this->get('form.factory')->create(PromotionType::class,$promotion);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $this->flushStage($promotion);
        }

        return $this->render('profil/promotions/promo_single.html.twig', array(
            'form' => $form->createView(),
            'promotion' => $promotion
        ));
    }


    /**
     * @param Promotion $promotion
     */
    public function flushStage($promotion){
        $promotion->setPrestataire($this->getUser());

        $em = $this->getDoctrine()->getManager();
        if (is_null($promotion->getId())){
            $em->persist($promotion);
        }
        $em->flush();
    }


    /**
     * @return PromotionRepository $promotion
     */
    public function getRepo()
    {
        $promotion = $this->getDoctrine()->getRepository(Promotion::class);
        return $promotion;
    }





}
