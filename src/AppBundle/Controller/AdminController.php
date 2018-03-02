<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Internaute;
use AppBundle\Entity\Newsletter;
use AppBundle\Form\SendNewsType;
use AppBundle\Service\MailHandler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\DocumentPDF;

class AdminController extends Controller
{

    /**
     * @Route("/admin/newsletter", name="admin_news_form")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function addNewsletterAction(Request $request)
    {
//        $newsletter = new Newsletter();
//        $form = $this->
    }

    /**
     * @Route("/admin/send_newsletter", name="admin_send_news")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function sendNewsletterAction(Request $request, MailHandler $mailHandler)
    {
        $list = $this->getAbbonnes();

        $form = $this->get('form.factory')->create(SendNewsType::class);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
        /** @var Newsletter $newsletter */
            $newsletter = $form->get('newsletter')->getData();

            $mailHandler->newsletter($newsletter, $list);
        }

        return $this->render(':admin:send_news.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function getAbbonnes()
    {
        $ur = $this->getDoctrine()->getRepository(Internaute::class);
        $list = $ur->findAllAbonner();
        return $list;
    }
}

