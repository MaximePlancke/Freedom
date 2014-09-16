<?php

namespace Freedom\ObjectiveBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Freedom\ObjectiveBundle\Entity\Objective;
use Freedom\ObjectiveBundle\Form\ObjectiveCreateType;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DashboardController extends Controller
{
	/**
    * @Route("/dashboard", name="freedom_objective_dashboard_dashboard")
    * @Template()
    */
    public function dashboardAction()
    {
        $user = $this->getUser();
        $repository = $this->getDoctrine()->getManager()->getRepository('FreedomObjectiveBundle:Objective');

        $lastCurrentObjective = $repository->findBy(array('user' => $user, 'done' => 0),array('datecreation' => 'desc'));
        $lastCurrentObjective = $lastCurrentObjective ? $lastCurrentObjective[0] : null;
        $lastDoneObjective = $repository->findBy(array('user' => $user, 'done' => 1),array('datedone' => 'desc'));
        $lastDoneObjective = $lastDoneObjective ? $lastDoneObjective[0] : null;
        $countTotalObjective = count($lastDoneObjective)+count($lastCurrentObjective);
        $pourcentComplete = ($countTotalObjective > 0) ? (int)(count($lastDoneObjective)/$countTotalObjective*100) : 0;

        return array(
            'lastCurrentObjective' => $lastCurrentObjective,
            'lastDoneObjective' => $lastDoneObjective,
            'pourcentComplete' => $pourcentComplete,
        );
    }

	/**
    * @Route("/create", name="freedom_objective_dashboard_create")
    * @Template()
    */
    public function createAction()
    {
        $objective = new Objective;
        $form = $this->createForm(new ObjectiveCreateType, $objective);

        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $objective->setUser($this->getUser());
                $objective->setNbsteps(count($objective->getSteps()));
                foreach ($objective->getSteps() as $key => $value) {
                    $value->setObjective($objective);
                    $objective->addStep($value);
                }
                $em = $this->getDoctrine()->getManager();
                $em->persist($objective);
                $em->flush();

                return $this->redirect($this->generateUrl('freedom_objective_dashboard_dashboard', array()));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
    * @Route("/{id}", requirements={"id" = "\d+"}, name="freedom_objective_dashboard_details")
    * @Template()
    */
    public function detailsAction($id)
    {

        return array();
    }

    /**
    * @Route("/current", name="freedom_objective_dashboard_current")
    * @Template()
    */
    public function currentAction()
    {
        return array();
    }

    /**
    * @Route("/done", name="freedom_objective_dashboard_done")
    * @Template()
    */
    public function doneAction()
    {
        return array();
    }

    /**
    * @Route("/followed", name="freedom_objective_dashboard_followed")
    * @Template()
    */
    public function followedAction()
    {
        return array();
    }

}
