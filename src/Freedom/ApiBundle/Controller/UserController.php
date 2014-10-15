<?php

namespace Freedom\ApiBundle\Controller;

use Freedom\UserBundle\Entity\User;
use Freedom\UserBundle\Form\UserType;
use Freedom\UserBundle\Entity\Userfrienduser;
use Freedom\UserBundle\Entity\Notification;

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
 * User controller.
 * @RouteResource("User")
 */
class UserController extends VoryxController
{

    /**
     * Get a User entity
     *
     * @View(serializerEnableMaxDepthChecks=true)
     * @param $user
     *
     * @return Response
     *
     */
    public function getAction(User $user)
    {
        $entity = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('FreedomUserBundle:User')
            ->apiSearchOne($user);
        return $entity;
    }

    /**
     * Get all User entities.
     *
     * @View(serializerEnableMaxDepthChecks=true)
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
            ->getRepository('FreedomUserBundle:User')
            ->apiSearch($name, $filters, $offset, $limit, $order_by);

            // $em = $this->getDoctrine()->getManager();
            // $entities = $em->getRepository('FreedomUserBundle:User')->findBy($filters, $order_by, $limit, $offset);
            if ($entities) {
                return $entities;
            }

            return FOSView::create('Not Found', Codes::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return FOSView::create($e->getMessage(), Codes::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * Create a User entity.
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
        $entity = new User();
        $form = $this->createForm(new UserType(), $entity, array("method" => $request->getMethod()));
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
     * Update a User entity.
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @param Request $request
     * @param $entity
     *
     * @return Response
     */
    public function putAction(Request $request, User $entity)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $request->setMethod('PATCH'); //Treat all PUTs as PATCH
            $form = $this->createForm(new UserType(), $entity, array("method" => $request->getMethod()));
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
     * Partial Update to a User entity.
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @param Request $request
     * @param $entity
     *
     * @return Response
*/
    public function patchAction(Request $request, User $entity)
    {
        return $this->putAction($request, $entity);
    }
    /**
     * Delete a User entity.
     *
     * @View(statusCode=204)
     *
     * @param Request $request
     * @param $entity
     * @internal param $id
     *
     * @return Response
     */
    public function deleteAction(Request $request, User $entity)
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
     * Get all followed objectives entities.
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @param ParamFetcherInterface $paramFetcher
     * @param $entity
     *
     * @return Response
     *
     * @QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing notes.")
     * @QueryParam(name="limit", requirements="\d+", default="20", description="How many notes to return.")
     * @QueryParam(name="order_by", nullable=true, description="Order by fields. Must be an array ie. &order_by[name]=ASC&order_by[description]=DESC")
     * @QueryParam(name="filters", nullable=true, description="Filter by fields. Must be an array")
     * @QueryParam(name="user", description="Name of the content. String")
     */
    public function cgetUserfollowobjectivesAction(ParamFetcherInterface $paramFetcher, User $entity)
    {
        try {
            $offset = $paramFetcher->get('offset');
            $limit = $paramFetcher->get('limit');
            $order_by = $paramFetcher->get('order_by');
            $filters = !is_null($paramFetcher->get('filters')) ? $paramFetcher->get('filters') : array();
            $order_by = json_decode($order_by, true);
            $filters = json_decode($filters, true);

            $entities = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('FreedomObjectiveBundle:Objective')
            ->apiFollowedSearch($entity, $filters, $offset, $limit, $order_by);

            // $em = $this->getDoctrine()->getManager();
            // $entities = $em->getRepository('FreedomUserBundle:User')->findBy($filters, $order_by, $limit, $offset);
            if ($entities) {
                return $entities;
            }

            return FOSView::create('Not Found', Codes::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return FOSView::create($e->getMessage(), Codes::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get all group from user entities.
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @param ParamFetcherInterface $paramFetcher
     * @param $entity
     *
     * @return Response
     *
     * @QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing notes.")
     * @QueryParam(name="limit", requirements="\d+", default="20", description="How many notes to return.")
     * @QueryParam(name="order_by", nullable=true, description="Order by fields. Must be an array ie. &order_by[name]=ASC&order_by[description]=DESC")
     * @QueryParam(name="filters", nullable=true, description="Filter by fields. Must be an array")
     * @QueryParam(name="user", description="Name of the content. String")
     */
    public function cgetUserbelonggroupsAction(ParamFetcherInterface $paramFetcher, User $entity)
    {
        try {
            $offset = $paramFetcher->get('offset');
            $limit = $paramFetcher->get('limit');
            $order_by = $paramFetcher->get('order_by');
            $filters = !is_null($paramFetcher->get('filters')) ? $paramFetcher->get('filters') : array();
            $order_by = json_decode($order_by, true);
            $filters = json_decode($filters, true);

            $entities = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('FreedomGroupBundle:Groups')
            ->apiBelongSearch($entity, $filters, $offset, $limit, $order_by);

            // $em = $this->getDoctrine()->getManager();
            // $entities = $em->getRepository('FreedomUserBundle:User')->findBy($filters, $order_by, $limit, $offset);
            if ($entities) {
                return $entities;
            }

            return FOSView::create('Not Found', Codes::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return FOSView::create($e->getMessage(), Codes::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Create a Friend User entity.
     *
     * @View(statusCode=201, serializerEnableMaxDepthChecks=true)
     *
     * @param Request $request
     * @param $user
     *
     * @return Response
     *
     */
    public function postUserfriendusersAction(Request $request, User $user)
    {
        try {
            if ($this->getUser() == $user) {
                return FOSView::create(array('errors' => 'You can\'t be friend with yourself'), Codes::HTTP_INTERNAL_SERVER_ERROR);
            }

            $em = $this->getDoctrine()->getManager();
            $userfrienduser = new Userfrienduser();
            $userfrienduser->setUser1($this->getUser());
            $userfrienduser->setUser2($user);

            $entity = $em->getRepository('FreedomUserBundle:User')->alreadyFriend($this->getUser(),$user);

            if ($entity == null) {

            // if ($form->isValid()) {
                $em->persist($userfrienduser);

                $notification = new Notification();
                $notification->setContent($this->getUser()->getUsername().' requested to be your friends');
                $notification->setUser($user);
                $notification->setUrl($this->getUser()->getId());
                $notification->setType(1);
                $em->persist($notification);
                $em->flush();

                return $userfrienduser;
            // }

            }

            return FOSView::create(array('errors' => 'Already exist'), Codes::HTTP_INTERNAL_SERVER_ERROR);

        } catch (\Exception $e) {
            return FOSView::create($e->getMessage(), Codes::HTTP_INTERNAL_SERVER_ERROR);
        }
    } 

    /**
     * Delete a Friend User entity.
     *
     * @View(statusCode=204)
     *
     * @param Request $request
     * @param $entity
     * @internal param $id
     *
     * @return Response
     */
    public function deleteUserfriendusersAction(Request $request, User $user, Userfrienduser $entity)
    {
        $user = $this->getUser();
        if ($user == $entity->getUser1() OR $user == $entity->getUser2()) {
            if($entity->getAccepted() != 0 AND $user == $entity->getUser1()){
                try {
                    $em = $this->getDoctrine()->getManager();
                    $em->remove($entity);
                    $em->flush();

                    return null;
                } catch (\Exception $e) {
                    return FOSView::create($e->getMessage(), Codes::HTTP_INTERNAL_SERVER_ERROR);
                }
            } else {
                throw $this->createNotFoundException(
                    'Friendship not accepted yet'
                );
            }
        } else {
            throw $this->createNotFoundException(
                'No rights for this follow : '.$entity
            );
        }
    }

    /**
     * Get a isFriend entity
     *
     * @View(statusCode=201, serializerEnableMaxDepthChecks=true)
     * @param Request $request
     * @param $user
     * @param $friend
     *
     * @return Response
     *
     */
    public function getIsfriendAction(Request $request, User $user, User $friend)
    {
        return array('1' => 'amis');
    }

}
