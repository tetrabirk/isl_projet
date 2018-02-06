<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Image;
use AppBundle\Entity\Internaute;
use AppBundle\Entity\Prestataire;
use AppBundle\Entity\Utilisateur;
use AppBundle\Entity\UtilisateurTemporaire;
use AppBundle\Form\InternauteType;
use AppBundle\Form\PrestataireType;
use AppBundle\Form\UtilisateurTemporaireType;
use AppBundle\Form\UtilisateurType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{

    //TODO déconnecter tout utilsateur avant inscription, (connexion), confirmation
    /**
     * @Route("/connexion", name="connexion")
     */
    public function connexion(Request $request, AuthenticationUtils $authUtils)
    {
        //get login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        //last username enterd by user
        $lastUsername = $authUtils->getLastUsername();
        return $this->render('security/connexion.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
        ));
    }

    /**
     * @Route("/deconnexion", name="deconnexion")
     */
    public function deconnexionAction()
    {
        return $this->render('index.html.twig', array());
    }

    /**
     * @Route("/inscription", name="inscription")
     */
    public function inscriptionAction(Request $request, EncoderFactoryInterface $encoderFactory, \Swift_Mailer $mailer)
    {
        $utilisateurT = new UtilisateurTemporaire();
        $form = $this->createForm(UtilisateurTemporaireType::class, $utilisateurT,
            array('method' => 'POST', 'action' => ($this->generateUrl('inscription'))));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $passwordEncoder = $encoderFactory->getEncoder($utilisateurT);
            $password = $passwordEncoder->encodePassword($utilisateurT->getMotDePasseNonCripte(), $utilisateurT->getSalt());
            $utilisateurT->setMotDePasse($password);

            $utilisateurT->setDate(new \DateTime());

            $token = hash('sha512', $utilisateurT->getEmail() . ($utilisateurT->getDate())->format('dmy'));
            $utilisateurT->setToken($token);

            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisateurT);
            $em->flush();

            $this->addFlash('notifications', "Un Email de confirmation à bien été envoyé");

            //TODO creer un service pour ceci
            $this->sendEmail($utilisateurT->getEmail(), $utilisateurT->getToken(), $mailer);

            return $this->redirectToRoute('inscription');
        } else {
            dump($form->getErrors());

        }

        return $this->render('security/inscription.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/confirmation/{token}", name="confirmation")
     */
    public function confirmation($token)
    {
        $utilisateurT = $this->getDoctrine()
            ->getRepository(UtilisateurTemporaire::class)
            ->findOneBy(array('token' => $token));


        if ($utilisateurT->getType() == 'Internaute') {
            $utilisateur = new Internaute();
            $utilisateur->setEmail($utilisateurT->getEmail());
            $utilisateur->setMotDePasse($utilisateurT->getMotDePasse());

            return $this->forward('AppBundle\Controller\ProfilController::traitementNewUser', array(
                'newUser' => $utilisateur,
            ));
        } else {
            $utilisateur = new Prestataire();
            $utilisateur->setEmail($utilisateurT->getEmail());
            $utilisateur->setMotDePasse($utilisateurT->getMotDePasse());

            return $this->traitementNewUser($utilisateur);
        }


    }

    /**
     * @Route("/mot_de_passe", name="mot_de_passe")
     */
    public function motDePasseAction()
    {
        return $this->render('security/mot_de_passe.html.twig', array());
    }

    public function sendEmail($email, $token, $mailer)
    {
        $message = (new \Swift_Message('hello Email'))
            ->setFrom('send@example')
            ->setTo($email)
            ->setBody(
                $this->renderView('email/inscription.html.twig', array(
                    'token' => $token
                )), 'text/html'
            );
        $mailer->send($message);

    }

    public function traitementNewUser($utilisateur){
        $user = $utilisateur;
        $image = new Image();
        $image->setActive(true);

        /**
         * @var Utilisateur $user
         */
        if ($user->getType() == "Prestataire") {
            /**
             * @var Prestataire $user
             */
            $user->setLogo($image);
        } else {
            /**
             * @var Internaute $user
             */
            $user->setAvatar($image);
        }

        //forward to profilController
        return $this->forward('AppBundle\Controller\ProfilController::ProfilAction', array(
            'newUser' => $user,
        ));
    }

}
