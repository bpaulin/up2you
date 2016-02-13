<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Vote;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class VotesController extends FOSRestController
{
    /**
     * @ApiDoc(
     *  description="Returns a collection of votes",
     *  views = { "default", "voter" }
     * )
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
     * @ApiDoc(
     *  description="Returns a collection of votes YES",
     *  views = { "default", "voter" }
     * )
     * @REST\Get("votes/yes")
     */
    public function getVotesYesAction()
    {
        return $this->getVote(Vote::YES);
    }

    /**
     * @ApiDoc(
     *  description="Returns a collection of votes NO",
     *  views = { "default", "voter" }
     * )
     * @REST\Get("votes/no")
     */
    public function getVotesNoAction()
    {
        return $this->getVote(Vote::NO);
    }

    /**
     * @ApiDoc(
     *  description="Returns a collection of votes MAYBE",
     *  views = { "default", "voter" }
     * )
     * @REST\Get("votes/maybe")
     */
    public function getVotesMaybeAction()
    {
        return $this->getVote(Vote::MAYBE);
    }
}
