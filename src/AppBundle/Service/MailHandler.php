<?php
/**
 * Created by PhpStorm.
 * User: Vi
 * Date: 7/11/2017
 * Time: 20:20
 */

namespace AppBundle\Service;

use AppBundle\Entity\DocumentPDF;
use AppBundle\Entity\Newsletter;

class MailHandler
{

    private $mailer;
    private $templating;

    const SENDER_EMAIL = 'send@example.com';

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    public function mailConfirmation($email,$token)
    {
        $view = 'email/confirmation.html.twig';
        $subject = "Confirmation d'Inscription";
        $param = array('token'=>$token);

        $this->sendEmail($email,$subject,$view,$param);
    }

    public function mailInscription($email,$prenom){
        //TODO creer la view du mail
        $view = 'email/inscription.html.twig';
        $subject = "Confirmation d'Inscription";
        $param = array('prenom'=>$prenom);

        $this->sendEmail($email,$subject,$view,$param);
    }

    /**
     * @param Newsletter $newsletter
     * @param array $list
     */
    public function newsletter(Newsletter $newsletter, $list = array())
    {
       $view = 'email/newsletter.html.twig';
       $filepath = $newsletter->getDocumentPDF()->getWebPath();
       $subject = $newsletter->getTitre();
       $param = array();
       $this->sendEmail($list,$subject,$view,$param,$filepath);
    }

    public function sendEmail($email,$subject,$view, $param = array(),$filePath = null)
    {
        $message = (new \Swift_Message($subject))
            ->setFrom(self::SENDER_EMAIL)
            ->setTo($email)
            ->setBody($this->templating->render($view, $param), 'text/html');

        if(!is_null($filePath)){
            $message->attach(\Swift_Attachment::fromPath($filePath));
        }

        $this->mailer->send($message);

    }

}