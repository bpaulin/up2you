<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

class ProposalsController extends FOSRestController
{
    /**
     * @REST\Get("proposals")
     */
    public function getProposalsAction()
    {
        $data = $this->getDoctrine()->getRepository('AppBundle:Proposal')->findAll();
        $view = $this->view($data, 200);

        return $this->handleView($view);
    }

    /**
     * @REST\Get("proposals/todo")
     */
    public function getProposalsTodoAction()
    {
        $data = $this->getDoctrine()->getRepository('AppBundle:Proposal')->findTodoBy($this->getUser());
        $view = $this->view($data, 200);

        return $this->handleView($view);
    }
}
