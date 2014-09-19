<?php

namespace Freedom\ExploreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ExploreController extends Controller
{

	/**
    * @Route("/search", name="freedom_explore_search")
    * @Template()
    */
    public function searchAction()
    {

    	$user = $this->getUser();


        return array();
    }

	/**
    * @Route("/", name="freedom_explore_news")
    * @Template()
    */
    public function newsAction()
    {

    	$user = $this->getUser();


        return array();
    }
}
