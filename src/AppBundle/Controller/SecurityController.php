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
use AppBundle\Service\MailHandler;

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
    public function inscriptionAction(Request $request, EncoderFactoryInterface $encoderFactory, MailHandler $mailHandler)
    {
        $utilisateurT = new UtilisateurTemporaire();
        $form = $this->createForm(UtilisateurTemporaireType::class, $utilisateurT,
            array('method' => 'POST', 'action' => ($this->generateUrl('inscription'))));

        $form->handleRequest($request);
//        dump('test');
        if ($form->isSubmitted() && $form->isValid()) {

            $this->persistUserTemp($utilisateurT,$encoderFactory);

            $email = $utilisateurT->getEmail();
            $token = $utilisateurT->getToken();

            $mailHandler->mailConfirmation($email,$token);

            //TODO error handler :  si le mail ne s'envoie pas -> supprimer l'user temporaire et dire qu'il y a eu une erreur et de recommencer
            //TODO                  si le tempuser existe déjà -> demander si il veut renvoyer le mail

            $this->addFlash('notifications', "Un Email de confirmation à bien été envoyé");

            return $this->redirectToRoute('inscription');
        } else {
//            dump($form->getErrors());

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

        } else {
            $utilisateur = new Prestataire();
        }

        $utilisateur->setEmail($utilisateurT->getEmail());
        $utilisateur->setMotDePasse($utilisateurT->getMotDePasse());

        return $this->traitementNewUser($utilisateur, $utilisateurT);

        //TODO if success -> sucess message and delete tempUser
        //TODO if failure -> error message and "try again later"

    }

    /**
     * @Route("/mot_de_passe", name="mot_de_passe")
     */
    public function motDePasseAction()
    {
        return $this->render('security/mot_de_passe.html.twig', array());
    }


    public function sendEmail($email, $token, $mailer,MailHandler $mailHandler)
    {
        $mailHandler->mailConfirmation($email,$token);
    }

    public function persistUserTemp(UtilisateurTemporaire $utilisateurT, $encoderFactory)
    {
        $passwordEncoder = $encoderFactory->getEncoder($utilisateurT);
        $password = $passwordEncoder->encodePassword($utilisateurT->getMotDePasseNonCripte(), $utilisateurT->getSalt());
        $utilisateurT->setMotDePasse($password);

        $utilisateurT->setDate(new \DateTime());

        $token = hash('sha512', $utilisateurT->getEmail() . ($utilisateurT->getDate())->format('dmy'));
        $utilisateurT->setToken($token);

        $em = $this->getDoctrine()->getManager();
        $em->persist($utilisateurT);
        $em->flush();
    }


    public function traitementNewUser($utilisateur,$utilisateurT)
    {
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
            'userTemp' =>$utilisateurT
        ));
    }

}
