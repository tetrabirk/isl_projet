<?php
/**
 * Created by PhpStorm.
 * User: Ludovic
 * Date: 25/02/2018
 * Time: 19:06
 */

namespace AppBundle\Form\Model;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;



class ChangePassword
{
    /**
     * @SecurityAssert\UserPassword(
     *     message = "Mauvais mot de passe"
     * )
     */
    protected $oldPassword;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min=6,
     *     max=4096,
     *     minMessage="mot de passe trop court! (au moins {{limit}} caractères)"
     * )
     */
    protected $newPassword;

    /**
     * @return mixed
     */
    public function getOldPassword()
    {
        return $this->oldPassword;
    }

    /**
     * @param mixed $oldPassword
     */
    public function setOldPassword($oldPassword): void
    {
        $this->oldPassword = $oldPassword;
    }

    /**
     * @return mixed
     */
    public function getNewPassword()
    {
        return $this->newPassword;
    }

    /**
     * @param mixed $newPassword
     */
    public function setNewPassword($newPassword): void
    {
        $this->newPassword = $newPassword;
    }


}