<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

class VotesController extends FOSRestController
{
    /**
     * @REST\Get("votes")
     */
    public function getVotesAction()
    {
        $data = $this->getDoctrine()->getRepository('AppBundle:Vote')->findBy(
            array(
                'user' => $this->getUser()
            )
        );
        $view = $this->view($data, 200);

        return $this->handleView($view);
    }
}
