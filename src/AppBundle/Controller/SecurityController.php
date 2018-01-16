<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Utilisateur;
use AppBundle\Entity\UtilisateurTemporaire;
use AppBundle\Form\UtilisateurTemporaireType;
use AppBundle\Form\UtilisateurType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;

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
    public function inscriptionAction(Request $request, EncoderFactory $encoderFactory)
    {
        $utilisateurT = new UtilisateurTemporaire();
        $form = $this->createForm(UtilisateurTemporaireType::class, $utilisateurT,
            array('method'=>'POST','action' =>($this->generateUrl('inscription'))));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $passwordEncoder  = $encoderFactory->getEncoder($utilisateurT);
            $password = $passwordEncoder->encodePassword($utilisateurT->getMotDePasseNonCripte(), $utilisateurT->getSalt());
            $utilisateurT->setMotDePasse($password);
            $utilisateurT->setDate(new \DateTime());
            $utilisateurT->setToken($utilisateurT->getEmail());

            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisateurT);
            $em->flush();


            return $this->redirectToRoute('homepage');
        } else {
            dump($form->getErrors());

        }

        return $this->render('security/inscription.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/mot_de_passe", name="mot_de_passe")
     */
    public function motDePasseAction()
    {
        return $this->render('security/mot_de_passe.html.twig', array());
    }

}
