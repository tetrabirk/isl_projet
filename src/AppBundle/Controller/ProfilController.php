<?php
/**
 * Created by PhpStorm.
 * User: Vi
 * Date: 17/10/2017
 * Time: 18:53
 */

namespace AppBundle\Controller;

use AppBundle\Entity\CategorieDeServices;
use AppBundle\Entity\Image;
use AppBundle\Entity\Internaute;
use AppBundle\Entity\Prestataire;
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
            dump($user);
            $this->flushUtilisateur($user);
        }

        return $this->render('profil/prestataire.html.twig', array(
            'form' => $form->createView(),
            'newUser' => $user,
        ));
    }

    public function loadProfilInternaute($request, $user)
    {
        $form = $this->get('form.factory')->create(InternauteType::class, $user);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $this->flushUtilisateur($user);

        }

        return $this->render('profil/internaute.html.twig', array(
            'form' => $form->createView(),
            'newUser' => $user,
        ));
    }

    private function flushUtilisateur(Utilisateur $utilisateur){
        $em = $this->getDoctrine()->getManager();

        if (is_null($utilisateur->getId())){

            //ceci est temporaire
            $imagetemp = new Image();
            $imagetemp->setNom('default_0.jpg');
            $imagetemp->setActive(true);

            if ($utilisateur->getType() == "Prestataire"){
                $utilisateur->setLogo($imagetemp);
            }else{
                $utilisateur->setAvatar($imagetemp);
            }
            //^^^^^temporaiiiiiiire

            $utilisateur->setInscription(new \DateTime());
            $em->persist($utilisateur);
            dump('flush user');
        }
        $em->flush();
    }


}
