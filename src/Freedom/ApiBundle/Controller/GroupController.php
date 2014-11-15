<?php

namespace Freedom\ApiBundle\Controller;

use Freedom\GroupBundle\Entity\Groups;
use Freedom\GroupBundle\Form\GroupsType;
use Freedom\UserBundle\Entity\User;
use Freedom\UserBundle\Form\UserbelonggroupType;
use Freedom\UserBundle\Entity\Userbelonggroup;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View as FOSView;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Voryx\RESTGeneratorBundle\Controller\VoryxController;

/**
 * Groups controller.
 * @RouteResource("Group")
 */
class GroupController extends VoryxController
{
    /**
     * Get a Groups entity
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @return Response
     *
     */
    public function getAction(Groups $entity)
    {
        return $entity;
    }
    /**
     * Get all Groups entities.
     *
     * @View(serializerEnableMaxDepthChecks=true, serializerGroups={"Default"})
     *
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return Response
     *
     * @QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing notes.")
     * @QueryParam(name="limit", requirements="\d+", default="20", description="How many notes to return.")
     * @QueryParam(name="order_by", nullable=true, description="Order by fields. Must be an array ie. &order_by[name]=ASC&order_by[description]=DESC")
     * @QueryParam(name="filters", nullable=true, description="Filter by fields. Must be an array")
     * @QueryParam(name="name", description="Name of the content. String")
     */
    public function cgetAction(ParamFetcherInterface $paramFetcher)
    {
        try {
            $offset = $paramFetcher->get('offset');
            $limit = $paramFetcher->get('limit');
            $order_by = $paramFetcher->get('order_by');
            $name = $paramFetcher->get('name');
            $filters = !is_null($paramFetcher->get('filters')) ? $paramFetcher->get('filters') : array();
            $order_by = json_decode($order_by, true);
            $filters = json_decode($filters, true);

            $entities = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('FreedomGroupBundle:Groups')
            ->apiSearch($name, $filters, $offset, $limit, $order_by);

            // $em = $this->getDoctrine()->getManager();
            // $entities = $em->getRepository('FreedomGroupBundle:Groups')->findBy($filters, $order_by, $limit, $offset);
            if ($entities) {
                return $entities;
            }

            return FOSView::create('Not Found', Codes::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return FOSView::create($e->getMessage(), Codes::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Create a Groups entity.
     *
     * @View(statusCode=201, serializerEnableMaxDepthChecks=true)
     *
     * @param Request $request
     *
     * @return Response
     *
     */
    public function postAction(Request $request)
    {
        $entity = new Groups();
        $form = $this->createForm(new GroupsType(), $entity, array("method" => $request->getMethod()));
        $this->removeExtraFields($request, $form);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $entity;
        }

        return FOSView::create(array('errors' => $form->getErrors()), Codes::HTTP_INTERNAL_SERVER_ERROR);
    }
    /**
     * Update a Groups entity.
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @param Request $request
     * @param $entity
     *
     * @return Response
     */
    public function putAction(Request $request, Groups $entity)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $request->setMethod('PATCH'); //Treat all PUTs as PATCH
            $form = $this->createForm(new GroupsType(), $entity, array("method" => $request->getMethod()));
            $this->removeExtraFields($request, $form);
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em->flush();

                return $entity;
            }

            return FOSView::create(array('errors' => $form->getErrors()), Codes::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            return FOSView::create($e->getMessage(), Codes::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * Partial Update to a Groups entity.
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @param Request $request
     * @param $entity
     *
     * @return Response
*/
    public function patchAction(Request $request, Groups $entity)
    {
        return $this->putAction($request, $entity);
    }
    /**
     * Delete a Groups entity.
     *
     * @View(statusCode=204)
     *
     * @param Request $request
     * @param $entity
     * @internal param $id
     *
     * @return Response
     */
    public function deleteAction(Request $request, Groups $entity)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($entity);
            $em->flush();

            return null;
        } catch (\Exception $e) {
            return FOSView::create($e->getMessage(), Codes::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

/**
     * Create a Belong Group entity.
     *
     * @View(statusCode=201, serializerEnableMaxDepthChecks=true)
     *
     * @param Request $request
     * @param $group
     *
     * @return Response
     *
     */
    public function postUserbelonggroupsAction(Request $request, Groups $group)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $userbelonggroup = new Userbelonggroup();
            $userbelonggroup->setUser($this->getUser());
            $userbelonggroup->setGroup($group);
            $userbelonggroup->setRole(2);
            if($group->getPrivate() == false){
                $userbelonggroup->setAccepted(true);
            }

            $entity = $em->getRepository('FreedomUserBundle:Userbelonggroup')->findOneBy(array('user' => $this->getUser(), 'group' => $group));

            if ($entity == null) {

            // if ($form->isValid()) {
                $em->persist($userbelonggroup);
                $em->flush();

                if($group->getPrivate() == false){
                    // return $userbelonggroup;
                    return array('type' => 'success', 'alert' => 'alert-success', 'message' => 'You are now part of the group!', 'data' => $userbelonggroup);
                }else{
                    return array('type' => 'private', 'alert' => 'alert-success', 'message' => 'Your request has been sent to the owner of the group!');
                }
            // }

            }

            // return FOSView::create(array('errors' => 'Already exist'), Codes::HTTP_INTERNAL_SERVER_ERROR);
            return array('type' => 'warning', 'alert' => 'alert-warning', 'message' => 'You already requested for this group');

        } catch (\Exception $e) {
            return FOSView::create($e->getMessage(), Codes::HTTP_INTERNAL_SERVER_ERROR);
        }
    } 

    /**
     * Delete a Belong Group entity.
     *
     * @View(statusCode=200)
     *
     * @param Request $request
     * @param $entity
     * @internal param $id
     *
     * @return Response
     */
    public function deleteUserbelonggroupsAction(Request $request, Groups $group, Userbelonggroup $entity)
    {
        $user = $this->getUser();
        if (($user == $entity->getUser() AND $entity->getRole() != 1) OR ($user == $group->getUser())) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->remove($entity);
                $em->flush();

                return array('type' => 'success', 'alert' => 'alert-success', 'message' => 'You don\'t belong this group anymore !');
            } catch (\Exception $e) {
                // return FOSView::create($e->getMessage(), Codes::HTTP_INTERNAL_SERVER_ERROR);
                return array('type' => 'error');
            }
        } else {
            throw $this->createNotFoundException(
                'No able to modify : '.$entity
            );
        }
    }

    /**
     * Update a member entity.
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @param Request $request
     * @param $entity
     * @param $member   
     *
     * @return Response
     */
    public function putUserbelonggroupsAction(Request $request, Groups $group,  Userbelonggroup $member)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $request->setMethod('PATCH'); //Treat all PUTs as PATCH
            $form = $this->createForm(new UserbelonggroupType(), $member, array("method" => $request->getMethod()));
            $this->removeExtraFields($request, $form);
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em->flush();

                return $member;
            }

            return FOSView::create(array('errors' => $em), Codes::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            return FOSView::create($e->getMessage(), Codes::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get a User belong entity
     *
     * @View(statusCode=200, serializerEnableMaxDepthChecks=true)
     * @param Request $request
     * @param $group
     * @param $user
     *
     * @return Response
     *
     */
    public function getUserbelonggroupsAction(Request $request, Groups $group, User $user)
    {
        try {
            $userBelong = $group->getUserBelong($user);
            return $userBelong;
        } catch (\Exception $e) {
            return FOSView::create($e->getMessage(), Codes::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
