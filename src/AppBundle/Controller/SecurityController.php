<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @Route("/connexion", name="connexion")
     */
    public function connexion(Request $request, AuthenticationUtils $authUtils)
    {
        //get login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        //last username enterd by user
        $lastUsername = $authUtils->getLastUsername();
        return $this->render('security/connexion.html.twig',array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    /**
     * @Route("/deconnexion", name="deconnexion")
     */
    public function deconnexionAction()
    {
        return $this->render('index.html.twig',array(
        ));
    }

    /**
     * @Route("/inscription", name="inscription")
     */
    public function inscriptionAction()
    {
        return $this->render('security/inscription.html.twig',array(
        ));
    }
    /**
     * @Route("/mot_de_passe", name="mot_de_passe")
     */
    public function motDePasseAction()
    {
        return $this->render('security/mot_de_passe.html.twig',array(
        ));
    }



}
