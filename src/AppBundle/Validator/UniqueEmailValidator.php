<?php
/**
 * Created by PhpStorm.
 * User: Ludovic
 * Date: 21/02/2018
 * Time: 19:26
 */

namespace AppBundle\Validator;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueEmailValidator extends ConstraintValidator
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function validate($object, Constraint $constraint)
    {
        $email = $object->getEmail();
        $qb = $this->em->createQueryBuilder();
        $qb->from("AppBundle:Utilisateur",'u');
        $qb->from("AppBundle:UtilisateurTemporaire",'ut');
        $qb->select(array("u.email as user","ut.email as usertemp"));
        $qb->where("u.email = :email OR ut.email = :email");
        $qb->setParameter("email", $email);
        $qb->groupBy("user");
        $qb->groupBy("usertemp");

        $conflicts=$qb->getQuery()->getResult();
        dump($conflicts);


        if($conflicts != null){
            if($conflicts[0]['user']==$email){
                $this->context->buildViolation('Cet Email est déjà utilisé par un autre Utilisateur')
                    ->addViolation();
            }elseif($conflicts[0]['usertemp']==$email){
                $this->context->buildViolation('Cet Email est en attente de validation, merci de vérifier vos mails')
                    ->addViolation();
            }

        }
    }

}