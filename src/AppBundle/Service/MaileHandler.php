<?php
/**
 * Created by PhpStorm.
 * User: Vi
 * Date: 7/11/2017
 * Time: 20:20
 */

namespace AppBundle\Service;


class MaileHandler
{

    const SENDER_EMAIL = 'send@example.com';

    public function mailConfirmation($email,$token, $mailer)
    {
        $view = 'email/confirmation.html.twig';
        $subject = "Confirmation d'Inscription";
        $param = array('token'=>$token);

        $this->sendEmail($email,$subject,$view,$param,$mailer);
    }

    public function mailInscription($email,$prenom,$mailer){
        //TODO creer la view du mail
        $view = 'email/inscription.html.twig';
        $subject = "Confirmation d'Inscription";
        $param = array('prenom'=>$prenom);

        $this->sendEmail($email,$subject,$view,$param,$mailer);
    }
    public function sendEmail($email,$subject,$view, $param = array(), $mailer)
    {
        $message = (new \Swift_Message($subject))
            ->setFrom(self::SENDER_EMAIL)
            ->setTo($email)
            ->setBody($this->renderView($view, $param, 'text/html'));

        $mailer->send($message);

    }

}