<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Response\Transformer\Category\CategoryTransformer;

/**
 * @RouteResource("Categories")
 */
class CategoriesController extends BaseController
{
    /**
     * @QueryParam(name="limit", requirements="\d+", default=10, description="limit")
     * @QueryParam(name="offset", requirements="\d+", default=0, description="offset")
     *
     * @param Request $request
     * @param ParamFetcherInterface $paramFetcher
     * @return mixed
     */
    public function cgetAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        $limit = $paramFetcher->get('limit');
        $offset = $paramFetcher->get('offset');

        return $this->withCollection(
            $this->getHandler()->all($limit, $offset),
            new CategoryTransformer()
        );
    }

    protected function getHandler()
    {
        return $this->get('app_bundle.handler.categories_handler');
    }
}