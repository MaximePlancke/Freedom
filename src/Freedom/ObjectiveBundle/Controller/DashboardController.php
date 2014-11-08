<?php

namespace Freedom\ObjectiveBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Freedom\ObjectiveBundle\Entity\Objective;
use Freedom\ObjectiveBundle\Form\ObjectiveCreateType;
use Freedom\ObjectiveBundle\Form\ObjectiveEditType;

// ACL
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

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

        $lastCurrentObjectives = $repository->findBy(array('user' => $user, 'done' => 0),array('datecreation' => 'desc'));
        $lastDoneObjectives = $repository->findBy(array('user' => $user, 'done' => 1),array('datedone' => 'desc'));
        $countTotalObjective = count($lastDoneObjectives)+count($lastCurrentObjectives);
        $pourcentComplete = ($countTotalObjective > 0) ? (int)(count($lastDoneObjectives)/$countTotalObjective*100) : 0;
        $lastCurrentObjectives = array_slice($lastCurrentObjectives, 0, 5, true);
        $lastDoneObjectives = array_slice($lastDoneObjectives, 0, 5, true);

        return array(
            'lastCurrentObjectives' => $lastCurrentObjectives,
            'lastDoneObjectives' => $lastDoneObjectives,
            'pourcentComplete' => $pourcentComplete,
        );
    }

	/**
    * @Route("/create", name="freedom_objective_dashboard_create", options={"expose"=true})
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

                //ACL
                $aclProvider = $this->get('security.acl.provider');
                $objectIdentity = ObjectIdentity::fromDomainObject($objective);
                $acl = $aclProvider->createAcl($objectIdentity);

                $securityContext = $this->get('security.context');
                $user = $securityContext->getToken()->getUser();
                $securityIdentity = UserSecurityIdentity::fromAccount($user);

                $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
                $aclProvider->updateAcl($acl);

                return $this->redirect($this->generateUrl('freedom_objective_dashboard_details', array('id' => $objective->getId())));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
    * @Route("/edit/{id}", name="freedom_objective_dashboard_edit", options={"expose"=true})
    * @Template()
    */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $objective = $em->getRepository('FreedomObjectiveBundle:Objective')->find($id);

        if (null === $objective) {
            throw new NotFoundHttpException("the objective with the id ".$id." doesn't exist.");
        }

        //Check if user can edit it 
        $securityContext = $this->get('security.context');
        if (false === $securityContext->isGranted('EDIT', $objective))
        {
            throw new AccessDeniedException();
        }

        $form = $this->createForm(new ObjectiveEditType, $objective);

        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                foreach ($objective->getSteps() as $key => $value) {
                    $value->setObjective($objective);
                    $objective->addStep($value);
                }
                $em->flush();

                return $this->redirect($this->generateUrl('freedom_objective_dashboard_details', array('id' => $id)));
            }
        }

        return array(
            'form' => $form->createView(),
            'id' => $id
        );
    }

    /**
    * @Route("/{id}", requirements={"id" = "\d+"}, name="freedom_objective_dashboard_details", options={"expose"=true})
    * @Template()
    */
    public function detailsAction($id)
    {

        return array();
    }

    /**
    * @Route("/notifications", name="freedom_objective_dashboard_notifications")
    * @Template()
    */
    public function notificationsAction()
    {
        return array();
    }

    /**
    * @Route("/requests", name="freedom_objective_dashboard_friendrequests")
    * @Template()
    */
    public function friendrequestsAction()
    {
        $user = $this->getUser();
        $repository = $this->getDoctrine()->getManager()->getRepository('FreedomUserBundle:Userfrienduser');

        $friendRequests = $repository->findBy(array('user2' => $user, 'accepted' => 0),array('datecreation' => 'desc'));

        return array(
            'friendRequests' => $friendRequests,
        );
    }

    /**
    * @Route("/current", name="freedom_objective_dashboard_current")
    * @Template()
    */
    // public function currentAction()
    // {
    //     return array();
    // }

    /**
    * @Route("/done", name="freedom_objective_dashboard_done")
    * @Template()
    */
    // public function doneAction()
    // {
    //     return array();
    // }

    /**
    * @Route("/followed", name="freedom_objective_dashboard_followed")
    * @Template()
    */
    // public function followedAction()
    // {
    //     return array();
    // }

}
