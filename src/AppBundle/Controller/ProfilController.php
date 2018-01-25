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
     * @Route("/profil", name="profil")
     */
    public function profilAction($newUser = null, Request $request)
    {
        if(isset($newUser)){
            $user = $newUser;

        }else{
            $user = $this->getUser();
        }
        $userType = $user->getType();
        if ($userType == "Prestataire") {
            return $this->loadProfilPrestataire($request, $user);
        } else {
            return $this->loadProfilInternaute($request,$user);
        }

    }

    /**
     * @Route("/profil/suppression", name="profil_suppression")
     */
    public function profilSuppressionAction()
    {
        return $this->render('profil/profil_suppression.html.twig', array());
    }


    public function loadProfilPrestataire($request, $user)
    {
        $form = $this->get('form.factory')->create(PrestataireType::class, $user);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }

        return $this->render('profil/prestataire.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function loadProfilInternaute($request, $user)
    {
        $form = $this->get('form.factory')->create(InternauteType::class, $user);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }

        return $this->render('profil/internaute.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
