<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class ApiController extends Controller
{
    /**
     * @ApiDoc(
     *     description="test api response",
     *     views = { "default", "proposer", "voter" },
     *     statusCodes={
     *         200="Returned when authenticated",
     *         401="Returned when anonymous"
     *     }
     * )
     * @REST\Get("ping")
     */
    public function proposerAction()
    {
        return new JsonResponse();
    }
    /**
     * @ApiDoc(
     *  description="Authenticate",
     *  requirements={
     *      {
     *          "name"="username",
     *          "dataType"="string",
     *          "description"="Username"
     *      },
     *      {
     *          "name"="password",
     *          "dataType"="string",
     *          "description"="Password"
     *      },
     *  },
     *  views = { "default", "proposer", "voter" }
     * )
     *
     * @Rest\Post("/login_check")
     */
    public function checkAction()
    {
    }
}
