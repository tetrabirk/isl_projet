<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Newsletter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function homeAction()
    {
        return $this->render('index.html.twig',array(
        ));
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction()
    {
        return $this->render('public/contact.html.twig',array(
        ));
    }
    /**
     * @Route("/about", name="about")
     */
    public function aboutAction()
    {
        return $this->render('public/about.html.twig',array(
        ));
    }
    /**
     * @Route("/newsletter", name="news")
     */
    public function newsAction()
    {
        $newsletters = self::getNewsletter();

        return $this->render('public/newsletter.html.twig',array(
            'newsletters' => $newsletters,
        ));
    }
    /**
     * @Route("/connexion", name="connexion")
     */
    public function connexionAction()
    {
        return $this->render('security/connexion.html.twig',array(
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





    public function getNewsletter()
    {
        $repository = $this->getDoctrine()->getRepository(Newsletter::class);

        $data = $repository->findAll();
        return $data;
    }

}
