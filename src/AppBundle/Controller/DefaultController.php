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


    public function getNewsletter()
    {
        $repository = $this->getDoctrine()->getRepository(Newsletter::class);

        $data = $repository->findAll();
        return $data;
    }

}
