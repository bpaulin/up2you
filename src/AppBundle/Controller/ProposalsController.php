<?php

namespace AppBundle\Controller;

use AppBundle\Form\ProposalType;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Hateoas\Configuration\Route;
use Hateoas\Representation\Factory\PagerfantaFactory;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use AppBundle\Entity\Proposal;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;

class ProposalsController extends FOSRestController
{
    /**
     * @ApiDoc(
     *  description="Returns a proposal",
     *  views = { "default", "proposer", "voter" }
     * )
     *
     * @ParamConverter("proposal", class="AppBundle:Proposal")
     *
     * @REST\Get("proposal/{id}")
     * @Rest\View()
     */
    public function getProposalAction(Proposal $proposal)
    {
        return $proposal;
    }
    /**
     * @ApiDoc(
     *  description="Create a proposal",
     *  views = { "default", "proposer", "voter" }
     * )
     *
     * @REST\Post("proposal")
     */
    public function postProposalAction(Request $request)
    {
        $proposal = new Proposal();
        $form = $this->createForm('AppBundle\Form\ProposalType', $proposal);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($proposal);
            $manager->flush();

            $response = new Response();
            $response->setStatusCode(201);

            $response->headers->set(
                'Location',
                $this->generateUrl(
                    'get_proposal',
                    array('id' => $proposal->getId()),
                    true // absolute
                )
            );

            return $response;
        }
        return $this->view($form, 400);
    }

    /**
     * @ApiDoc(
     *  description="Returns a collection of proposals",
     *  requirements={
     *      {
     *          "name"="limit",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="how many objects to return"
     *      },
     *      {
     *          "name"="page",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="page"
     *      }
     *  },
     *  views = { "default", "proposer", "voter" }
     * )
     *
     * @REST\Get("proposals")
     * @Rest\View()
     */
    public function getProposalsAction(Request $request)
    {
        $limit = $request->query->getInt('limit', 10);
        $page = $request->query->getInt('page', 1);

        $queryBuilder = $this->getDoctrine()
            ->getRepository('AppBundle:Proposal')
            ->createQueryBuilder('p');

        $pagerAdapter = new DoctrineORMAdapter($queryBuilder);
        $pager = new Pagerfanta($pagerAdapter);
        $pager->setCurrentPage($page);
        $pager->setMaxPerPage($limit);

        $pagerFactory = new PagerfantaFactory();

        return $pagerFactory->createRepresentation(
            $pager,
            new Route('get_proposals', array('limit' => $limit, 'page' => $page))
        );
    }

    /**
     * @ApiDoc(
     *  description="Returns a collection of unvoted proposals",
     *  requirements={
     *      {
     *          "name"="limit",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="how many objects to return"
     *      },
     *      {
     *          "name"="page",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="page"
     *      }
     *  },
     *  views = { "default", "voter" }
     * )
     * @REST\Get("proposals/todo")
     */
    public function getProposalsTodoAction(Request $request)
    {
        $limit = $request->query->getInt('limit', 10);
        $page = $request->query->getInt('page', 1);

        $queryBuilder = $this->getDoctrine()
            ->getRepository('AppBundle:Proposal')
            ->getQueryBuilderFindTodoBy($this->getUser());

        $pagerAdapter = new DoctrineORMAdapter($queryBuilder);
        $pager = new Pagerfanta($pagerAdapter);
        $pager->setCurrentPage($page);
        $pager->setMaxPerPage($limit);

        $pagerFactory = new PagerfantaFactory();

        return $pagerFactory->createRepresentation(
            $pager,
            new Route('get_proposals_todo', array('limit' => $limit, 'page' => $page))
        );
    }
}
