<?php

namespace Freedom\ObjectiveBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Freedom\ObjectiveBundle\Entity\Objective;
use Freedom\ObjectiveBundle\Form\ObjectiveCreateType;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


/**
 * @Route("/{idProfile}"), requirements={"idProfile" = "\d+"}
 */
class ProfileController extends Controller
{
	/**
    * @Route("/profile", name="freedom_objective_profile_profile")
    * @Template()
    */
    public function profileAction($idProfile)
    {

        $repository = $this->getDoctrine()->getManager()->getRepository('FreedomUserBundle:User');
        $userProfile = $repository->find($idProfile);

        $repository = $this->getDoctrine()->getManager()->getRepository('FreedomObjectiveBundle:Objective');

        $lastCurrentObjective = $repository->findBy(array('user' => $userProfile, 'done' => 0),array('datecreation' => 'desc'));
        $lastCurrentObjective = $lastCurrentObjective ? $lastCurrentObjective[0] : null;
        $lastDoneObjective = $repository->findBy(array('user' => $userProfile, 'done' => 1),array('datedone' => 'desc'));
        $lastDoneObjective = $lastDoneObjective ? $lastDoneObjective[0] : null;
        $countTotalObjective = count($lastDoneObjective)+count($lastCurrentObjective);
        $pourcentComplete = ($countTotalObjective > 0) ? (int)(count($lastDoneObjective)/$countTotalObjective*100) : 0;

        return array(
            'userProfile' => $userProfile,
            'lastCurrentObjective' => $lastCurrentObjective,
            'lastDoneObjective' => $lastDoneObjective,
            'pourcentComplete' => $pourcentComplete,
        );
    }


    /**
    * @Route("/current", name="freedom_objective_profile_current")
    * @Template()
    */
    public function currentAction($idProfile)
    {

        $repository = $this->getDoctrine()->getManager()->getRepository('FreedomUserBundle:User');
        $userProfile = $repository->find($idProfile);
        
        return array(
                'userProfile' => $userProfile,
            );
    }

    /**
    * @Route("/done", name="freedom_objective_profile_done")
    * @Template()
    */
    public function doneAction($idProfile)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('FreedomUserBundle:User');
        $userProfile = $repository->find($idProfile);
        
        return array(
                'userProfile' => $userProfile,
            );
    }

    /**
    * @Route("/followed", name="freedom_objective_profile_followed")
    * @Template()
    */
    public function followedAction($idProfile)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('FreedomUserBundle:User');
        $userProfile = $repository->find($idProfile);
        
        return array(
                'userProfile' => $userProfile,
            );
    }

}
