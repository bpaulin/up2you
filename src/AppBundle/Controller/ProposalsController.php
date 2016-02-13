<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

class ProposalsController extends FOSRestController
{
    public function getProposalsAction()
    {
        $data = $this->getDoctrine()->getRepository('AppBundle:Proposal')->findAll();
        $view = $this->view($data, 200);

        return $this->handleView($view);
    }
}
