<?php

namespace Freedom\GroupBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Freedom\GroupBundle\Entity\Groups;
use Freedom\GroupBundle\Form\GroupsCreateType;
use Freedom\UserBundle\Entity\Userbelonggroup;
use Freedom\ObjectiveBundle\Entity\Objective;
use Freedom\ObjectiveBundle\Form\ObjectiveCreateType;

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
                $userbelonggroup->setAccepted(true);
            	$userbelonggroup->setGroup($group);
                $group->addUserbelonggroups($userbelonggroup);
                $em = $this->getDoctrine()->getManager();
                $em->persist($group);
                $em->flush();
                $id = $group->getId();

                return $this->redirect($this->generateUrl('freedom_group_details', array('id' => $id)));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
    * @Route("/edit/{id}", name="freedom_group_edit", options={"expose"=true})
    * @Template()
    */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $group = $em->getRepository('FreedomGroupBundle:Groups')->find($id);
        $form = $this->createForm(new GroupsCreateType, $group);

        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->flush();

                return $this->redirect($this->generateUrl('freedom_group_details', array('id' => $id)));
            }
        }

        return array(
            'form' => $form->createView(),
            'id' => $id
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

	/**
    * @Route("/{id}/create", name="freedom_group_create_objective")
    * @Template()
    */
    public function createObjectiveAction($id)
    {
        $objective = new Objective;
        $form = $this->createForm(new ObjectiveCreateType, $objective);

        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
            	$em = $this->getDoctrine()->getManager();

                $objective->setUser($this->getUser());
                $group = $em->getRepository('FreedomGroupBundle:Groups')->find($id);
                $objective->setGroup($group);
                $objective->setNbsteps(count($objective->getSteps()));
                foreach ($objective->getSteps() as $key => $value) {
                    $value->setObjective($objective);
                    $objective->addStep($value);
                }
                $em->persist($objective);
                $em->flush();

                return $this->redirect($this->generateUrl('freedom_group_details', array('id' => $id)));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

}
