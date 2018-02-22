<?php
/**
 * Created by PhpStorm.
 * User: Vi
 * Date: 7/11/2017
 * Time: 20:20
 */

namespace AppBundle\Service;

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
    public function sendEmail($email,$subject,$view, $param = array())
    {
        $message = (new \Swift_Message($subject))
            ->setFrom(self::SENDER_EMAIL)
            ->setTo($email)
            ->setBody($this->templating->render($view, $param), 'text/html');

        $this->mailer->send($message);

    }

}