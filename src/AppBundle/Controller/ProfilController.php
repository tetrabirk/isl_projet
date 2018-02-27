<?php
/**
 * Created by PhpStorm.
 * User: Vi
 * Date: 17/10/2017
 * Time: 18:53
 */

namespace AppBundle\Controller;

use AppBundle\Entity\CategorieDeServices;
use AppBundle\Entity\Image;
use AppBundle\Entity\Internaute;
use AppBundle\Entity\Prestataire;
use AppBundle\Entity\Utilisateur;
use AppBundle\Entity\UtilisateurTemporaire;
use AppBundle\Form\CategorieDeServicesType;
use AppBundle\Form\InternauteType;
use AppBundle\Form\PrestataireType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Controller\DefaultController as DC;


class ProfilController extends Controller
{

    /**
     * @Route("/profil", name="profil")
     */
    public function profilAction($newUser = null, $userTemp = null, Request $request)
    {

        if (isset($newUser)) {
            $user = $newUser;
        } else {
            $user = $this->getUser();
        }
        $userType = $user->getType();



        if ($userType == "Prestataire") {
            return $this->loadProfilPrestataire($request, $user, $userTemp);
        } else {

            return $this->loadProfilInternaute($request, $user, $userTemp);
        }

    }

    /**
     * @Route("/profil/suppression", name="profil_suppression")
     */
    public function profilSuppressionAction()
    {
        return $this->render('profil/profil_suppression.html.twig', array());
    }


    public function loadProfilPrestataire(Request $request, $user, $userTemp)
    {
        /**
         * @var Prestataire $user
         */
        $form = $this->get('form.factory')->create(PrestataireType::class, $user);

        $action = null;

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $this->newCategManagement($form,$user);
            $action = $this->flushUtilisateur($user, $userTemp);
        }

        if ($action == "newUser") {
            return $this->redirectToRoute('connexion');
        }

        return $this->render('profil/prestataire.html.twig', array(
            'form' => $form->createView(),
            'newUser' => $user,
        ));
    }

    public function loadProfilInternaute($request, $user, $userTemp)
    {
        /**
         * @var Internaute $user
         */
        $form = $this->get('form.factory')->create(InternauteType::class, $user);

        $action = null;

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $action = $this->flushUtilisateur($user, $userTemp);

        }

        if ($action == "newUser") {
            return $this->redirectToRoute('connexion');
        }

        return $this->render('profil/internaute.html.twig', array(
            'form' => $form->createView(),
            'newUser' => $user,
        ));
    }


    private function flushUtilisateur(Utilisateur $utilisateur, $userTemp)
    {
        $em = $this->getDoctrine()->getManager();

        if (is_null($utilisateur->getId())) {


            $utilisateur->setInscription(new \DateTime());
            $em->persist($utilisateur);
            $em->flush();
            //TODO if success -> sucess message and delete tempUser
            $em->remove($userTemp);
            $em->flush();
            return 'newUser';

        } else {
            $em->flush();
            return 'profil';
        }


        //TODO if failure -> error message and "try again later"
    }

    private function newCategManagement($form, $user)
    {
        /**
         * @var Form $form
         * @var CategorieDeServices $newCateg
         * @var Prestataire $user
         */
        $newCategArray = ($form->get('newCategories')->getData());

        foreach ($newCategArray as $newCateg) {

            $newCateg->setValide(false);
            $newCateg->addPrestataires($user);

            $user->addCategorie($newCateg);
        }
    }


}
