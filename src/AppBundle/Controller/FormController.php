<?php
/**
 * Created by PhpStorm.
 * User: Vi
 * Date: 17/10/2017
 * Time: 18:53
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Prestataire;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;




class FormController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     * @Route("form", name="exemple form")
     */

    public function indexAction(Request $request){

        $prestataire = new Prestataire();
        $builder = $this->createFormBuilder($prestataire);
        $builder->add('email', EmailType::class, ['required'=>false]);
        $builder->add('nom', Texttype::class);
        $builder->add('siteInternet', Texttype::class);
        $builder->add('telephone', Texttype::class);
        $builder->add('motDePasse', Passwordtype::class);
        $builder->add('inscription', DateType::class);

        $form = $builder->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($prestataire);
            $em->flush();
            dump('youhou');
            dump($prestataire);
        }
        return $this->render('lib/form/formtest.html.twig',
            [
                'form'=> $form->createView()
            ]
        );

        return new Response();
    }

}