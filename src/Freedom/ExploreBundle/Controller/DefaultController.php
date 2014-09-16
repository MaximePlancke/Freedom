<?php

namespace Freedom\ExploreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {

    	$user = $this->getUser();

		if (null === $user) {
		  // return $this->redirect($this->generateUrl('fos_user_profile', array()));
		} 


        return $this->render('FreedomExploreBundle:Default:index.html.twig', array());
    }
}
