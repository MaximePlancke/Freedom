<?php

namespace Freedom\GroupBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Freedom\GroupBundle\Entity\Groups;
use Freedom\GroupBundle\Form\GroupsCreateType;
use Freedom\UserBundle\Entity\Userbelonggroup;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
	/**
    * @Route("/create", name="freedom_group_create")
    * @Template()
    */
    public function createAction()
    {
        $group = new Groups;
        $form = $this->createForm(new GroupsCreateType, $group);

        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
            	$group->setUser($this->getUser());
            	$userbelonggroup = new Userbelonggroup;
            	$userbelonggroup->setUser($this->getUser());
            	$userbelonggroup->setRole(1);
            	$userbelonggroup->setGroup($group);
                $group->addUserbelonggroups($userbelonggroup);
                $em = $this->getDoctrine()->getManager();
                $em->persist($group);
                $em->flush();

                return $this->redirect($this->generateUrl('freedom_objective_dashboard_dashboard', array()));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
    * @Route("/{id}", requirements={"id" = "\d+"}, name="freedom_group_details", options={"expose"=true})
    * @Template()
    */
    public function detailsAction($id)
    {

        return array();
    }
}
