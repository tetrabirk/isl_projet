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
use AppBundle\Form\InternauteType;
use AppBundle\Form\PrestataireType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Controller\DefaultController as DC;




class ProfilController extends Controller
{

   /**
     * @Route("/profil/{id}", defaults ={"id"=null}, name="profil", requirements={"id": "\d+"})
     */
    public function profilAction(Request $request)
    {
        $user = $this->getUser();
        $userType= $user->getType();
        if ($userType =="Prestataire"){

            $form = $this->get('form.factory')->create(PrestataireType::class,$user);

            if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
                    $em = $this->getDoctrine()->getManager();
                    $em->flush();

            }

            return $this->render('profil/prestataire.html.twig',array(
                'form' => $form->createView(),
            ));
        }else{

            $form = $this->get('form.factory')->create(InternauteType::class,$user);

            if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->flush();

            }

            return $this->render('profil/internaute.html.twig',array(
                'form' => $form->createView(),
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








}
