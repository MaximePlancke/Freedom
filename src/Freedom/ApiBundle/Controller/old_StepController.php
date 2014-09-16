<?php

namespace Freedom\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class StepController extends Controller
{

    /**
    * @return array
    * @View()
    */
    public function putStepAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('FreedomObjectiveBundle:Stepobjective');

        $step = $repository->find($id);
        if (!$step) {
            throw $this->createNotFoundException(
                'No step for this id : '.$id
            );
        }

        $user = $this->getUser();
        if ($user == $step->getObjective()->getUser()) {
            $step->setDone(!$step->getDone());
            $em->persist($step);
            $em->flush();
        } else {
            throw $this->createNotFoundException(
                'No rights for this step : '.$id
            );
        }

        return $step;
    }

    /**
    * @return array
    * @View()
    */
    public function removeStepAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('FreedomObjectiveBundle:Stepobjective');
        $step = $repository->find($id);

        $user = $this->getUser();
        if ($user == $step->getObjective()->getUser()) {
            $em->remove($step);
            $em->flush();
        } else {
            throw $this->createNotFoundException(
                'No rights for this step : '.$id
            );
        }
    }

}
