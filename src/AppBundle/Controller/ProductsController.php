<?php
/**
 * Created by PhpStorm.
 * User: Maurice
 * Date: 2/12/2017
 * Time: 3:16 AM
 */

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpFoundation\Request;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Response\Transformer\Product\ProductTransformer;

/**
 * @RouteResource("Products")
 */
class ProductsController extends  BaseController
{
    /**
     * Get a single Product.
     *
     * @ApiDoc(
     *   output = "AppBundle\Entity\Product",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when not found"
     *   }
     * )
     *
     * @param int $id the product id
     *
     * @throws NotFoundHttpException when does not exist
     *
     * @return View
     */
    public function getAction($id)
    {
        return $this->getOr404($id);
    }

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
            new ProductTransformer()
        );
    }

    public function postAction(Request $request)
    {
       try {
            $product = $this->getHandler()->post(
                $request->request
            );

            $routeOptions = array(
                'id'        => $product->getId(),
                '_format'    => $request->get('_format'),
            );

            return $this->routeRedirectView(
                'get_products',
                $routeOptions,
                Response::HTTP_CREATED
            );
        } catch (\Exception $exception) {
            return $this->setStatusCode(Response::HTTP_BAD_REQUEST)
                ->withError('Oops! Product could not be created.');
        }
    }

    public function patchAction(Request $request, $id)
    {
        try {
            $product = $this->getHandler()->get($id);

            if (empty($product)) {
                return $this->setStatusCode(Response::HTTP_NOT_FOUND)
                    ->withError(sprintf("Product with ID %s not found", $id));
            }

            if (!$this->getHandler()->patch(
                    $product,
                    $request->request
            )) {
                return $this->setStatusCode(Response::HTTP_BAD_REQUEST)
                    ->withError("An error occurred, product not updated");
            }

            $routeOptions = array(
                'id'        => $product->getId(),
                '_format'   => $request->get('_format')
            );

            return $this->routeRedirectView(
                'get_products',
                $routeOptions,
                Response::HTTP_NO_CONTENT
            );

        } catch (\Exception $e) {
            return $this->setStatusCode(Response::HTTP_BAD_REQUEST)
                ->withError("An error occurred, product not updated");
        }
    }

    public function deleteAction($id)
    {
        try {
            $product = $this->getHandler()->get($id);
            if (empty($product)) {
                return $this->setStatusCode(Response::HTTP_NOT_FOUND)
                    ->withError(sprintf("Product with ID %s not found", $id));
            }

            $this->getHandler()->delete($product);

            return $this->setStatusCode(Response::HTTP_NO_CONTENT)->withNothing();
        } catch (\Exception $exception) {
            return $this->setStatusCode(Response::HTTP_BAD_REQUEST)
                ->withError("Oops! Product could not be deleted");
        }
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    private function getOr404($id)
    {
        $handler = $this->getHandler();
        $product = $handler->get($id);

        if (empty($product)) {
            return $this->setStatusCode(Response::HTTP_NOT_FOUND)
                ->withError(sprintf("Product with id %s was not found", $id));
        }

        return $this->withItem($product, new ProductTransformer());
    }

    protected function getHandler()
    {
        return $this->get('app_bundle.handler.products_handler');
    }
}