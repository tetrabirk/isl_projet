<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecurityTestController extends Controller
{
    /**
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route(path="my-admin")
     */
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
}
