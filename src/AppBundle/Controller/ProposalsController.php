<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class ProposalsController extends FOSRestController
{
    /**
     * @ApiDoc(
     *  description="Returns a collection of proposals",
     *  views = { "default", "proposer", "voter" }
     * )
     *
     * @REST\Get("proposals")
     */
    public function getProposalsAction()
    {
        $data = $this->getDoctrine()->getRepository('AppBundle:Proposal')->findAll();
        $view = $this->view($data, 200);

        return $this->handleView($view);
    }

    /**
     * @ApiDoc(
     *  description="Returns a collection of unvoted proposals",
     *  views = { "default", "voter" }
     * )
     * @REST\Get("proposals/todo")
     */
    public function getProposalsTodoAction()
    {
        $data = $this->getDoctrine()->getRepository('AppBundle:Proposal')->findTodoBy($this->getUser());
        $view = $this->view($data, 200);

        return $this->handleView($view);
    }
}
