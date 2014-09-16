<?php

namespace Freedom\MenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    public function menuTopAction()
    {
    	$user = $this->getUser();
        return $this->render('FreedomMenuBundle:Default:menu-top.html.twig', array('user' => $user));
    }

}
