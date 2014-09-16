<?php

namespace Freedom\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ObjectiveController extends Controller
{

    /**
    * @Route("/{id}", requirements={"id" = "\d+"}, name="freedom_api_getobjective")
    */
    public function getObjectiveAction($id)
    {
        $repositoryObjective = $this->getDoctrine()->getManager()->getRepository('FreedomObjectiveBundle:Objective');

        $objective = $repositoryObjective->myFindOne($id);
        if (!$objective) {
            throw $this->createNotFoundException(
                'No objective for this id : '.$id
            );
        }

		$response = new JsonResponse();
		$response->setData(array(
		    'objective' => $objective,
		));
		return $response;
    }


}
