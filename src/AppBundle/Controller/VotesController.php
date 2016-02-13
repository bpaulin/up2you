<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Hateoas\Configuration\Route;
use Hateoas\Representation\Factory\PagerfantaFactory;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Vote;

class VotesController extends FOSRestController
{
    /**
     * @ApiDoc(
     *  description="Returns a collection of votes",
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
     *  filters={
     *      {"name"="vote", "dataType"="string", "pattern"="(yes|maybe|no)"}
     *  },
     *  views = { "default", "voter" }
     * )
     * @REST\Get("votes")
     */
    public function getVotesAction(Request $request)
    {
        $limit = $request->query->getInt('limit', 10);
        $page = $request->query->getInt('page', 1);
        $vote = $request->query->getAlpha('vote');

        /** @var \AppBundle\Repository\VoteRepository $voteRepo */
        $voteRepo = $this->getDoctrine()->getRepository('AppBundle:Vote');
        $queryBuilder = $voteRepo->createQueryBuilder('v')
            ->where('v.user=:user')
            ->setParameter(':user', $this->getUser());
        $routeParam = array('limit' => $limit, 'page' => $page);
        switch ($vote) {
            case 'yes':
                $queryBuilder->andWhere('v.vote=:vote')->setParameter(':vote', Vote::YES);
                break;
            case 'maybe':
                $queryBuilder->andWhere('v.vote=:vote')->setParameter(':vote', Vote::MAYBE);
                break;
            case 'no':
                $queryBuilder->andWhere('v.vote=:vote')->setParameter(':vote', Vote::NO);
                break;
        }
        if ($vote) {
            $routeParam['vote'] = $vote;
        }

        $pagerAdapter = new DoctrineORMAdapter($queryBuilder);
        $pager = new Pagerfanta($pagerAdapter);
        $pager->setCurrentPage($page);
        $pager->setMaxPerPage($limit);

        $pagerFactory = new PagerfantaFactory();

        return $pagerFactory->createRepresentation(
            $pager,
            new Route('get_votes', $routeParam)
        );
    }
}
