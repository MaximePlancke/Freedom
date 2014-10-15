<?php

namespace Freedom\ApiBundle\Controller;

use Freedom\ObjectiveBundle\Entity\Advice;
use Freedom\ObjectiveBundle\Form\AdviceType;
use Freedom\ObjectiveBundle\Entity\Objective;
use Freedom\UserBundle\Entity\Userlikeadvice;
use Freedom\UserBundle\Form\UserlikeadviceType;

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
 * Advice controller.
 * @RouteResource("Advice")
 */
class AdviceController extends VoryxController
{
    /**
     * Get a Advice entity
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @return Response
     *
     */
    public function getAction(Objective $objective, Advice $entity)
    {
        //If objective is public or we have the rigth to see it then :
        return $entity;
    }
    /**
     * Get all Advice entities.
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
            $entities = $em->getRepository('FreedomObjectiveBundle:Advice')->findBy($filters, $order_by, $limit, $offset);
            if ($entities) {
                return $entities;
            }

            return FOSView::create('Not Found', Codes::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return FOSView::create($e->getMessage(), Codes::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * Create a Advice objective.
     *
     * @View(statusCode=201, serializerEnableMaxDepthChecks=true)
     *
     * @param Request $request
     * @param objective
     *
     * @return Response
     *
     */
    public function postAction(Request $request, Objective $objective)
    {
        $advice = new Advice();
        $form = $this->createForm(new AdviceType(), $advice, array("method" => $request->getMethod()));
        $this->removeExtraFields($request, $form);
        $form->handleRequest($request);
        $advice->setUser($this->getUser());
        $advice->setObjective($objective);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($advice);
            $em->flush();
            return $advice;
        }

        return FOSView::create(array('errors' => $form->getErrors()), Codes::HTTP_INTERNAL_SERVER_ERROR);
    }
    /**
     * Update a Advice entity.
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @param Request $request
     * @param $objective
     * @param $advice
     *
     * @return Response
     */
    public function putAction(Request $request, Objective $objective, Advice $advice)
    {

        try {
            $em = $this->getDoctrine()->getManager();
            $request->setMethod('PATCH'); //Treat all PUTs as PATCH
            $form = $this->createForm(new AdviceType(), $advice, array("method" => $request->getMethod()));
            $this->removeExtraFields($request, $form);
            $form->handleRequest($request);
            $advice->setUser($this->getUser());
            // $advice->setObjective($objective);
            if ($form->isValid()) {
                $em->flush();

                return $advice;
            }

            return FOSView::create(array('errors' => $form->getErrors()), Codes::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            return FOSView::create($e->getMessage(), Codes::HTTP_INTERNAL_SERVER_ERROR);
        }

    } 
    /**
     * Partial Update to a Advice entity.
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @param Request $request
     * @param $entity
     *
     * @return Response
*/
    public function patchAction(Request $request, Advice $entity)
    {
        return $this->putAction($request, $entity);
    }
    /**
     * Delete a Advice entity.
     *
     * @View(statusCode=204)
     *
     * @param Request $request
     * @param $entity
     * @internal param $id
     *
     * @return Response
     */
    public function deleteAction(Request $request, Objective $objective, Advice $entity)
    {
        $user = $this->getUser();
        if ($user == $entity->getUser() OR $user == $entity->getObjective()->getUser()) {

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
                'No rights for this advice : '.$entity
            );
        }
    }


    /**
     * Create a Like Advice entity.
     *
     * @View(statusCode=201, serializerEnableMaxDepthChecks=true)
     *
     * @param Request $request
     * @param $advice
     *
     * @return Response
     *
     */
    public function postUserlikeadvicesAction(Request $request, Objective $objective, Advice $advice)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $userlikeadvice = new Userlikeadvice();
            $userlikeadvice->setUser($this->getUser());
            $userlikeadvice->setAdvice($advice);

            $entity = $em->getRepository('FreedomUserBundle:Userlikeadvice')->findOneBy(array('user' => $this->getUser(), 'advice' => $advice));

            if ($entity == null) {

                $em->persist($userlikeadvice);
                $em->flush();

                return $userlikeadvice;

            }

            return FOSView::create(array('errors' => 'Already exist'), Codes::HTTP_INTERNAL_SERVER_ERROR);
            
        } catch (\Exception $e) {
            return FOSView::create($e->getMessage(), Codes::HTTP_INTERNAL_SERVER_ERROR);
        }
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
    public function deleteUserlikeadvicesAction(Request $request, Objective $objective, Advice $advice, Userlikeadvice $entity)
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
