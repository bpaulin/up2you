<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
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
