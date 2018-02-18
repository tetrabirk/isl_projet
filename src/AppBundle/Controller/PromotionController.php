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

    public function loadPromotionForm($request,$promotion){
        $form = $this->get('form.factory')->create(PromotionType::class,$promotion);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $this->flushStage($promotion);
        }
        dump($promotion);

        return $this->render('profil/promotions/promo_single.html.twig', array(
            'form' => $form->createView(),
            'promotion' => $promotion
        ));
    }

    public function flushStage(Promotion $promotion){
        $em = $this->getDoctrine()->getManager();
        $promotion->setPrestataire($this->getUser());
        if (is_null($promotion->getId())){
            $em->persist($promotion);
        }
        $em->flush();
    }

    public function getRepo()
    {
        /** @var PromotionRepository $promotion */
        $promotion = $this->getDoctrine()->getRepository(Promotion::class);
        return $promotion;
    }





}
