<?php

namespace Freedom\ApiBundle\Controller;

use Freedom\ObjectiveBundle\Entity\Stepobjective;
use Freedom\ObjectiveBundle\Form\StepobjectiveType;
use Freedom\ObjectiveBundle\Entity\Objective;
use Freedom\UserBundle\Entity\Userlikestepobjective;
use Freedom\UserBundle\Form\UserlikestepobjectiveType;

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
 * Stepobjective controller.
 * @RouteResource("Stepobjective")
 */
class StepobjectiveController extends VoryxController
{
    /**
     * Get a Stepobjective entity
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @return Response
     *
     */
    public function getAction(Stepobjective $entity)
    {
        return $entity;
    }
    /**
     * Get all Stepobjective entities.
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return Response
     *
     * @QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing notes.")
     * @QueryParam(name="limit", requirements="\d+", default="20", description="How many notes to return.")
     * @QueryParam(name="order_by", nullable=true, array=true, description="Order by fields. Must be an array ie. &order_by[name]=ASC&order_by[description]=DESC")
     * @QueryParam(name="filters", nullable=true, array=true, description="Filter by fields. Must be an array ie. &filters[id]=3")
     */
    public function cgetAction(ParamFetcherInterface $paramFetcher)
    {
        try {
            $offset = $paramFetcher->get('offset');
            $limit = $paramFetcher->get('limit');
            $order_by = $paramFetcher->get('order_by');
            $filters = !is_null($paramFetcher->get('filters')) ? $paramFetcher->get('filters') : array();

            $em = $this->getDoctrine()->getManager();
            $entities = $em->getRepository('FreedomObjectiveBundle:Stepobjective')->findBy($filters, $order_by, $limit, $offset);
            if ($entities) {
                return $entities;
            }

            return FOSView::create('Not Found', Codes::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return FOSView::create($e->getMessage(), Codes::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * Create a Stepobjective entity.
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
        $entity = new Stepobjective();
        $form = $this->createForm(new StepobjectiveType(), $entity, array("method" => $request->getMethod()));
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
     * Update a Stepobjective entity.
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @param Request $request
     * @param $entity
     *
     * @return Response
     */
    public function putAction(Request $request, Objective $objective, Stepobjective $entity)
    {
        $user = $this->getUser();
        if ($user == $entity->getObjective()->getUser()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $request->setMethod('PATCH'); //Treat all PUTs as PATCH
                $form = $this->createForm(new StepobjectiveType(), $entity, array("method" => $request->getMethod()));
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
        } else {
            throw $this->createNotFoundException(
                'No rights for this step : '.$entity
            );
        }
    }
    /**
     * Partial Update to a Stepobjective entity.
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @param Request $request
     * @param $entity
     *
     * @return Response
*/
    public function patchAction(Request $request, Stepobjective $entity)
    {
        return $this->putAction($request, $entity);
    }
    /**
     * Delete a Stepobjective entity.
     *
     * @View(statusCode=204)
     *
     * @param Request $request
     * @param $entity
     * @internal param $id
     *
     * @return Response
     */
    public function deleteAction(Request $request, Objective $objective, Stepobjective $entity)
    {

        $user = $this->getUser();
        if ($user == $entity->getObjective()->getUser()) {
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
                'No rights for this step : '.$entity
            );
        }
    }

    /**
     * Create a Like Step entity.
     *
     * @View(statusCode=201, serializerEnableMaxDepthChecks=true)
     *
     * @param Request $request
     * @param $stepobjective
     *
     * @return Response
     *
     */
    public function postUserlikestepobjectivesAction(Request $request, Objective $objective, Stepobjective $stepobjective)
    {
        $em = $this->getDoctrine()->getManager();
        $userlikestepobjective = new Userlikestepobjective();
        $userlikestepobjective->setUser($this->getUser());
        $userlikestepobjective->setStepobjective($stepobjective);

        $entity = $em->getRepository('FreedomUserBundle:Userlikestepobjective')->findOneBy(array('user' => $this->getUser(), 'stepobjective' => $stepobjective));

        if ($entity == null) {

            $em->persist($userlikestepobjective);
            $em->flush();

            return $userlikestepobjective;

        }

        return FOSView::create(array('errors' => 'Already exist'), Codes::HTTP_INTERNAL_SERVER_ERROR);
    } 

    /**
     * Delete a Like Advice entity.
     *
     * @View(statusCode=204)
     *
     * @param Request $request
     * @param $entity
     * @internal param $id
     *
     * @return Response
     */
    public function deleteUserlikestepobjectivesAction(Request $request, Objective $objective, Stepobjective $stepobjective, Userlikestepobjective $entity)
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
