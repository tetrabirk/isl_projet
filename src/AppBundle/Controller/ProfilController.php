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
     *
     * @param null $newUser
     * @param null $userTemp
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function profilAction($newUser = null, $userTemp = null, Request $request)
    {

        $user = $newUser ?? $this->getUser();
        $userType = $user->getType();

        if ($userType == "Prestataire") {
            return $this->loadProfilPrestataire($request, $user, $userTemp);
        } else {
            return $this->loadProfilInternaute($request, $user, $userTemp);
        }

    }


    /**
     * @Route("/profil/suppression", name="profil_suppression")
     *
     * @return Response
     */
    public function profilSuppressionAction()
    {
        return $this->render('profil/profil_suppression.html.twig', array());
    }


    /**
     * @param Request $request
     * @param Prestataire $user
     * @param $userTemp
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function loadProfilPrestataire($request, $user, $userTemp)
    {
        $form = $this->get('form.factory')->create(PrestataireType::class, $user);

        $action = null;

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $this->newCategManagement($form, $user);
            $action = $this->flushUtilisateur($user, $userTemp);
        }

        if ($action == "newUser") {
            return $this->redirectToRoute('connexion');
        } else {
            return $this->render('profil/prestataire.html.twig', array(
                'form' => $form->createView(),
                'newUser' => $user,
            ));
        }
    }


    /**
     * @param Request $request
     * @param Internaute $user
     * @param $userTemp
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function loadProfilInternaute($request, $user, $userTemp)
    {
        $form = $this->get('form.factory')->create(InternauteType::class, $user);

        $action = null;

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $action = $this->flushUtilisateur($user, $userTemp);
        }

        if ($action == "newUser") {
            return $this->redirectToRoute('connexion');
        } else {
            return $this->render('profil/internaute.html.twig', array(
                'form' => $form->createView(),
                'newUser' => $user,
            ));
        }
    }


    /**
     * @param Utilisateur $utilisateur
     * @param $userTemp
     * @return string
     */
    private function flushUtilisateur(Utilisateur $utilisateur, $userTemp)
    {
        $em = $this->getDoctrine()->getManager();

        if (is_null($utilisateur->getId())) {

            $utilisateur->setInscription(new \DateTime());
            $em->persist($utilisateur);
            $em->flush();
            $em->remove($userTemp);
            $em->flush();
            return 'newUser';

        } else {
            $em->flush();
            return 'profil';
        }
    }


    /**
     * @param Form $form
     * @param Prestataire $user
     */
    private function newCategManagement($form, $user)
    {
        /**
         * @var CategorieDeServices $newCateg
         */
        $newCategArray = ($form->get('newCategories')->getData());

        foreach ($newCategArray as $newCateg) {

            $newCateg->setValide(false);
            $newCateg->addPrestataires($user);

            $user->addCategorie($newCateg);
        }
    }

}
