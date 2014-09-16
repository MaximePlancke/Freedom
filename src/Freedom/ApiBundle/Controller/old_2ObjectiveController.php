<?php

namespace Freedom\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

use Freedom\ObjectiveBundle\Entity\Objective;
use Freedom\ObjectiveBundle\Form\ObjectiveType;
use Freedom\UserBundle\Entity\Userlikeobjective;
use \DateTime;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ObjectiveController extends Controller
{
  
    /**
    * @return array
    * @Rest\View()
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

		return $objective;
        ;
    }

    /**
    * @return array
    * @Rest\View()
    */
    public function putObjectiveAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('FreedomObjectiveBundle:Objective');

        $objective = $repository->find($id);
        if (!$objective) {
            throw $this->createNotFoundException(
                'No objective for this id : '.$id
            );
        }

        $request = $this->get('request');
        $params = $request->request->all();

        $user = $this->getUser();
        if ($user == $objective->getUser()) {


            $form = $this->createForm(new ObjectiveType(), $objective);
            $form->submit($params);

            if ($form->isValid()) {

                // if($objective->getDone() != $params['done'] AND $params['done'] == true) {
                //     $objective->setDatedone(new \Datetime);
                // }

                // // $objective->setCategory($params['category']);
                // // $objective->setNbsteps($params['nbsteps']);
                // $objective->setDone($params['done']);
                // $objective->setPrivate($params['private']);
                // $objective->setLikes($params['likes']);//delete this and count number of entity in the class
                // // $objective->setGroups($params['groups']);
                // $objective->setDategoal(new DateTime($params['dategoal']));

                // // $userlikeobjective = new Userlikeobjective();
                // // $userlikeobjective->setUser($user);
                // // $userlikeobjective->setObjective($objective);
                // // $em->persist($userlikeobjective);

                $em->persist($objective);
                $em->flush();

            } else {
                return $form;
            }

        } else {
            throw $this->createNotFoundException(
                'No rights for this objective : '.$id
            );
        }

        return $objective;
    }

    /**
    * @return array
    * @Rest\View()
    */
    public function removeObjectiveAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('FreedomObjectiveBundle:Objective');
        $objective = $repository->find($id);

        $user = $this->getUser();
        if ($user == $objective->getUser()) {
            $em->remove($objective);
            $em->flush();
        } else {
            throw $this->createNotFoundException(
                'No rights for this objective : '.$id
            );
        }
    }

    /**
    * @return array
    * @Rest\View()
    */
    public function putObjectiveUserlikeobjetivesAction($id)
    {
        // $em = $this->getDoctrine()->getManager();
        // $repository = $em->getRepository('FreedomObjectiveBundle:Objective');

        // $objective = $repository->find($id);
        // if (!$objective) {
        //     throw $this->createNotFoundException(
        //         'No objective for this id : '.$id
        //     );
        // }

        // $request = $this->get('request');
        // $params = $request->request->all();

        // $user = $this->getUser();
        // if ($user == $objective->getUser()) {

        //     // $objective->setUserlikeobjectives($params['userlikeobjetives']);

        //     $em->persist($objective);
        //     $em->flush();
        // } else {
        //     throw $this->createNotFoundException(
        //         'No rights for this objective : '.$id
        //     );
        // }

        // return $objective;
    }

}
