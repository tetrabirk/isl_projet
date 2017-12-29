<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Localite;
use AppBundle\Repository\LocaliteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;



class SearchController extends Controller
{

    public function renderSearchBarAction(Request $request)
    {
        $defaultData = array('message'=>'blablabla');
        $form = $this->createFormBuilder($defaultData)
            ->setMethod('GET')
            ->setAction($this->generateUrl('search'))
            ->add('motCle',TextType::class,array(
                'required' => false,
                'empty_data' => null,

            ))
//            ->add('localite',TextType::class,array(
//                'required' => false
//            ))

            ->add('localite',EntityType::class,array(
                'class'=> 'AppBundle:Localite',
                'query_builder' => function (LocaliteRepository $qb){
                    return $qb->createQueryBuilder('l')
                        ->leftJoin('l.codePostal','cp')->addSelect('cp')->orderBy('cp.codePostal');
                },
                'choice_label'=> function(Localite $localite){
                    return $localite->getNomAffichage();
                },
                'placeholder' => 'Localite',
                'required'=>false,
                'empty_data' => null,

            ))

            ->add('categorie',EntityType::class,array(
                'class'=> 'AppBundle:CategorieDeServices',
                'choice_label'=> 'nom', 'multiple' => 'true',
                'placeholder' => 'Categorie',
                'required'=>false,
                'empty_data' => null,

            ))
            ->add('search',SubmitType::class,array(
                'attr'=> array('class'=>'search'),
            ))
            ->getForm();


        return $this->render('lib/search/searchbar.html.twig',
            [
                'form'=>$form->createView()
            ]
        );
    }

    /**
     * @Route("/s/", name="search")
     */
    public function rechercheAction()
    {
        $request = Request::createFromGlobals();
        $motcle = $request->query->get('form')['motCle'] ?? null; // string
        $localite = $request->query->get('form')['localite'] ?? null; // id
        $categorie = ($request->query->get('form')['categorie']) ?? null ; //array d'id

        $repo = $this->getDoctrine()->getRepository(Prestataire::class);
        $qb = $repo->createQueryBuilder('p');
        $qb->leftJoin('p.stages','stages')->addSelect('stages');
        $qb->leftJoin('p.promotions','promotions')->addSelect('promotions');
        $qb->leftJoin('p.photos','photos')->addSelect('photos');
        $qb->leftJoin('p.logo','logo')->addSelect('logo');
        $qb->leftJoin('p.internautesFavoris','fav')->addSelect('fav');

        if (!is_null($categorie)){
            $qb->join('p.categories','c','WITH',$qb->expr()->in('c.id',$categorie));
        }else{
            $qb->leftJoin('p.categories','categories')->addSelect('categories');
        }

        if (!empty($localite)){
            $qb->join('p.localite','l','WITH', $qb->expr()->eq('l.id',$localite));
        }else{
            $qb->leftJoin('p.localite','localite')->addSelect('localite');
        }
        $qb->leftJoin('p.codePostal','cp')->addSelect('cp');

        if(!empty($motcle)){
            $qb->add('where', $qb->expr()->like('p.nom','?1'));
            $qb->setParameter(1,$motcle);

        }
        $query = $qb->getQuery();
        $prestataires = $query->getResult();

        return $this->render('public/prestataires/prestataires_all.html.twig', array(
            'prestataires' => $prestataires,
        ));

    }
}
