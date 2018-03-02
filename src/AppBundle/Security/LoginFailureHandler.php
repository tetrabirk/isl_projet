<?php
/**
 * Created by PhpStorm.
 * User: Ludovic
 * Date: 2/03/2018
 * Time: 18:10
 */

namespace AppBundle\Security;

use AppBundle\Entity\Utilisateur;
use Doctrine\ORM\EntityManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationFailureHandler;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Security\Http\HttpUtils;


class LoginFailureHandler extends DefaultAuthenticationFailureHandler
{
    /** @var EntityManager $em */
    public $em;

    public function __construct(HttpKernelInterface $httpKernel, HttpUtils $httpUtils, array $options = array(), LoggerInterface $logger = null, EntityManager $entityManager)
    {
        parent::__construct($httpKernel, $httpUtils, $options, $logger);
        $this->em =$entityManager;

    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        dump('tatutat');
        $username = ($request->get('_username'));
        $this->incrementeEssaisInfructueux($username);
        return parent::onAuthenticationFailure($request, $exception);
    }

    public function incrementeEssaisInfructueux($username){
        $this->em->getRepository(Utilisateur::class)->incrementeEssaisInfructueux($username);
    }
}