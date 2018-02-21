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
        $conflicts = $this->em
            ->getRepository('AppBundle:Utilisateur')
            ->findOneBy(array('email'=>$email))
            ;

        if($conflicts != null){
            $this->context->buildViolation('Cet Email est déjà utilisé par un autre Utilisateur')
                ->addViolation();
        }
    }

}