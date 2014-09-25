<?php

namespace Freedom\ApiBundle\Controller;

use Freedom\ObjectiveBundle\Entity\Objective;
use Freedom\ObjectiveBundle\Form\ObjectiveType;
use Freedom\ObjectiveBundle\Entity\Advice;
use Freedom\ObjectiveBundle\Form\AdviceType;
use Freedom\UserBundle\Entity\Userlikeobjective;
// use Freedom\UserBundle\Form\UserlikeobjectiveType;

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
 * Objective controller.
 * @RouteResource("Objective")
 */
class ObjectiveController extends VoryxController
{
    /**
     * Get a Objective entity
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @return Response
     *
     */
    public function getAction(Objective $entity)
    {
        //If not private or from friends then...
        return $entity;
    }
    /**
     * Get all Objective entities.
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

        //If not private or from friends then...
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
            ->getRepository('FreedomObjectiveBundle:Objective')
            ->apiSearch($name, $filters, $offset, $limit, $order_by);

            // $em = $this->getDoctrine()->getManager();
            // $entities = $em->getRepository('FreedomObjectiveBundle:Objective')->findBy($filters, $order_by, $limit, $offset);
            if ($entities) {
                return $entities;
            }

            return FOSView::create('Not Found', Codes::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return FOSView::create($e->getMessage(), Codes::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * Create a Objective entity.
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
        $entity = new Objective();
        $form = $this->createForm(new ObjectiveType(), $entity, array("method" => $request->getMethod()));
        $this->removeExtraFields($request, $form);
        $form->handleRequest($request);

        // if ($form->isValid()) {
        //     $em = $this->getDoctrine()->getManager();
        //     $em->persist($entity);
        //     $em->flush();

        //     return $entity;
        // }

        return FOSView::create(array('errors' => $form->getErrors()), Codes::HTTP_INTERNAL_SERVER_ERROR);
    }
    /**
     * Update a Objective entity.
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @param Request $request
     * @param $entity
     *
     * @return Response
     */
    public function putAction(Request $request, Objective $entity)
    {
        $user = $this->getUser();
        if ($user == $entity->getUser()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $request->setMethod('PATCH'); //Treat all PUTs as PATCH
                $form = $this->createForm(new ObjectiveType(), $entity, array("method" => $request->getMethod()));
                $this->removeExtraFields($request, $form);
                $form->handleRequest($request);
                if ($form->isValid()) {
                    $em->flush();

                    return $entity;
                }
                return FOSView::create(array('errors' => $form), Codes::HTTP_INTERNAL_SERVER_ERROR);
            } catch (\Exception $e) {
                return FOSView::create($e->getMessage(), Codes::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            throw $this->createNotFoundException(
                'No rights for this objective : '.$entity
            );
        }
    }
    /**
     * Partial Update to a Objective entity.
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @param Request $request
     * @param $entity
     *
     * @return Response
*/
    public function patchAction(Request $request, Objective $entity)
    {
        return $this->putAction($request, $entity);
    }
    /**
     * Delete a Objective entity.
     *
     * @View(statusCode=204)
     *
     * @param Request $request
     * @param $entity
     * @internal param $id
     *
     * @return Response
     */
    public function deleteAction(Request $request, Objective $entity)
    {
        $user = $this->getUser();
        if ($user == $entity->getUser()) {

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
                'No rights for this objective : '.$entity
            );
        }
    }

    /**
     * Create a Like Objective entity.
     *
     * @View(statusCode=201, serializerEnableMaxDepthChecks=true)
     *
     * @param Request $request
     * @param $objective
     *
     * @return Response
     *
     */
    public function postUserlikeobjectivesAction(Request $request, Objective $objective)
    {
        $em = $this->getDoctrine()->getManager();
        $userlikeobjective = new Userlikeobjective();
        // $form = $this->createForm(new UserlikeobjectiveType(), $userlikeobjective, array("method" => $request->getMethod()));
        // $this->removeExtraFields($request, $form);
        // $form->handleRequest($request);
        $userlikeobjective->setUser($this->getUser());
        $userlikeobjective->setObjective($objective);

        $entity = $em->getRepository('FreedomUserBundle:Userlikeobjective')->findOneBy(array('user' => $this->getUser(), 'objective' => $objective));

        if ($entity == null) {

        // if ($form->isValid()) {
            $em->persist($userlikeobjective);
            $em->flush();

            return $userlikeobjective;
        // }

        }

        return FOSView::create(array('errors' => 'Already exist'), Codes::HTTP_INTERNAL_SERVER_ERROR);
    } 

    /**
     * Delete a Like Objective entity.
     *
     * @View(statusCode=204)
     *
     * @param Request $request
     * @param $entity
     * @internal param $id
     *
     * @return Response
     */
    public function deleteUserlikeobjectivesAction(Request $request, Objective $objective, Userlikeobjective $entity)
    {
        $user = $this->getUser();
        if ($user == $entity->getUser()) {

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
                'No rights for this like : '.$entity
            );
        }
    }


}