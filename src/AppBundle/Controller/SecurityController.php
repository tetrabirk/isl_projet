<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Image;
use AppBundle\Entity\Internaute;
use AppBundle\Entity\Prestataire;
use AppBundle\Entity\Utilisateur;
use AppBundle\Entity\UtilisateurTemporaire;
use AppBundle\Form\ChangePasswordType;
use AppBundle\Form\InternauteType;
use AppBundle\Form\Model\ChangePassword;
use AppBundle\Form\PrestataireType;
use AppBundle\Form\SuppressionCompteType;
use AppBundle\Form\UtilisateurTemporaireType;
use AppBundle\Form\UtilisateurType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use AppBundle\Service\MailHandler;

class SecurityController extends Controller
{

    /**
     * @Route("/connexion", name="connexion")
     *
     * @param AuthenticationUtils $authUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function connexion(AuthenticationUtils $authUtils)
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
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deconnexionAction()
    {
        return $this->render('index.html.twig', array());
    }


    /**
     * @Route("/inscription", name="inscription")
     *
     * @param Request $request
     * @param EncoderFactoryInterface $encoderFactory
     * @param MailHandler $mailHandler
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function inscriptionAction(Request $request, EncoderFactoryInterface $encoderFactory, MailHandler $mailHandler)
    {
        $utilisateurT = new UtilisateurTemporaire();
        $form = $this->createForm(UtilisateurTemporaireType::class, $utilisateurT,
            array('method' => 'POST', 'action' => ($this->generateUrl('inscription'))));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->persistUserTemp($utilisateurT, $encoderFactory);

            $email = $utilisateurT->getEmail();
            $token = $utilisateurT->getToken();

            try {
                $mailHandler->mailConfirmation($email, $token);
            } catch (Exception $exception) {
                $this->removeUserTemp($utilisateurT);
                $this->addFlash('notifications', $exception->getMessage());

            }

            $this->addFlash('notifications', "Un Email de confirmation à bien été envoyé");

            return $this->redirectToRoute('inscription');
        }

        return $this->render('security/inscription.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    /**
     * @Route("/confirmation/{token}", name="confirmation")
     *
     * @param $token
     * @return \Symfony\Component\HttpFoundation\Response
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

    }

    /**
     * @Route("/mot_de_passe", name="mot_de_passe")
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function motDePasseAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $changePasswordModel = new ChangePassword();

        $user = $this->getUser();

        $form = $this->createForm(ChangePasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newPassword = $changePasswordModel->getNewPassword();
            $encoded = $encoder->encodePassword($user, $newPassword);
            $user->setMotDePasse($encoded);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('notifications', "le mot de passe à bien été modifier");
        }
        return $this->render('security/mot_de_passe.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/suppression", name="suppression")
     *
     * @param Request $request
     * @param TokenStorageInterface $tokenStorage
     * @param SessionInterface $session
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function suppressionUtilisateur(Request $request, TokenStorageInterface $tokenStorage, SessionInterface $session)
    {
        $user = $this->getUser();
        $form = $this->createForm(SuppressionCompteType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $form->get("question")->getData()) {

            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();

            $tokenStorage->setToken(null);
            $session->invalidate();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('security/suppressionCompte.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @param UtilisateurTemporaire $utilisateurT
     * @param EncoderFactoryInterface $encoderFactory
     */
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

    /**
     * @param $userTemp
     */
    public function removeUserTemp($userTemp)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($userTemp);

    }

    /**
     * @param Utilisateur $utilisateur
     * @param Utilisateur $utilisateurT
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function traitementNewUser($utilisateur, $utilisateurT)
    {
        $image = new Image();
        $image->setActive(true);

        if ($utilisateur->getType() == "Prestataire") {
            /** @var Prestataire $utilisateur */
            $utilisateur->setLogo($image);
        } else {
            /** @var Internaute $utilisateur */
            $utilisateur->setAvatar($image);
        }

        //forward to profilController
        return $this->forward('AppBundle\Controller\ProfilController::ProfilAction', array(
            'newUser' => $utilisateur,
            'userTemp' => $utilisateurT
        ));
    }

}
