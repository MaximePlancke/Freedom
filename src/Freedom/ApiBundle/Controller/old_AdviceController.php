<?php

namespace Freedom\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Freedom\ObjectiveBundle\Entity\Advice;
use Symfony\Component\HttpFoundation\JsonResponse;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AdviceController extends Controller
{

    /**
    * @return array
    * @View()
    */
    public function getAdvicesAction()
    {

    } 

    /**
    * @return array
    * @View()
    */
    public function postAdvicesAction()
    {

        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $params = $request->request->all();

            $repository = $this->getDoctrine()->getManager()->getRepository('FreedomObjectiveBundle:Objective');
            $objective = $repository->find($params['idObjective']);

            //If objective is public or we have the rigth to see it then :
            $advice = new Advice();
            $advice->setName(htmlentities($params['message']));
            $advice->setObjective($objective);
            $advice->setUser($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($advice);
            $em->flush();

            //We choose what we want to return
            $repositoryAdvice = $this->getDoctrine()->getManager()->getRepository('FreedomObjectiveBundle:Advice');
            $adviceArray = $repositoryAdvice->myFindOne($advice->getId());
        }
		return $adviceArray;

    }

    /**
    * @return array
    * @View()
    */
    public function removeAdviceAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('FreedomObjectiveBundle:Advice');
        $advice = $repository->find($id);

        $user = $this->getUser();
        if ($user == $advice->getUser() OR $user == $advice->getObjective()->getUser()) {
            $em->remove($advice);
            $em->flush();
        } else {
            throw $this->createNotFoundException(
                'No rights for this advice : '.$id
            );
        }
    }

}
