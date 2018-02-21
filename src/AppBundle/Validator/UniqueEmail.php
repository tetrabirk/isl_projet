<?php
/**
 * Created by PhpStorm.
 * User: Ludovic
 * Date: 21/02/2018
 * Time: 19:21
 */

namespace AppBundle\Validator;


use Symfony\Component\Validator\Constraint;

/** @Annotation */
class UniqueEmail extends Constraint
{
    public function validatedBy()
    {
        return 'unique_email';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}