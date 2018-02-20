<?php
/**
 * Created by PhpStorm.
 * User: Ludovic
 * Date: 19/02/2018
 * Time: 18:58
 */

namespace AppBundle\Security;

use AppBundle\Entity\Utilisateur;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof Utilisateur) {
            return;
        }
    }
    public function checkPostAuth(UserInterface $user)
    {

        if (!$user instanceof Utilisateur) {
            return;
        }
        if($user->getBanni()){
            throw new AccountExpiredException('vous êtes banni');
        }


    }
}