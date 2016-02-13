<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Vote;
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

    protected function getVote($vote)
    {
        $data = $this->getDoctrine()->getRepository('AppBundle:Vote')->findBy(
            array(
                'user' => $this->getUser(),
                'vote' => $vote
            )
        );
        $view = $this->view($data, 200);

        return $this->handleView($view);
    }

    /**
     * @REST\Get("votes/yes")
     */
    public function getVotesYesAction()
    {
        return $this->getVote(Vote::YES);
    }

    /**
     * @REST\Get("votes/no")
     */
    public function getVotesNoAction()
    {
        return $this->getVote(Vote::NO);
    }

    /**
     * @REST\Get("votes/maybe")
     */
    public function getVotesMaybeAction()
    {
        return $this->getVote(Vote::MAYBE);
    }
}
