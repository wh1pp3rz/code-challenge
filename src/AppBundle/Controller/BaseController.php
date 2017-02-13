<?php

namespace AppBundle\Controller;

use \FOS\RestBundle\Controller\FOSRestController;
use League\Fractal\Serializer\ArraySerializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;

abstract class BaseController extends FOSRestController
{
    protected $manager;
    protected $status_code = Response::HTTP_OK;

    public function __construct()
    {
        $this->manager = new Manager();
        $this->manager->setSerializer(new ArraySerializer());
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->status_code;
    }

    /**
     * @param $status_code
     * @return $this
     */
    public function setStatusCode($status_code)
    {
        $this->status_code = $status_code;
        return $this;
    }

    /**
     * @param array $data
     * @return JsonResponse
     */
    protected function withArray(array $data)
    {
        $response = new JsonResponse();
        $response->setData($data);
        $response->setStatusCode($this->status_code);
        return $response;
    }

    /**
     * @param $item
     * @param $callback
     * @return JsonResponse
     */
    public function withItem($item, $callback)
    {
        $resource = new Item($item, $callback);
        return $this->withArray($this->manager->createData($resource)->toArray());
    }

    /**
     * @param $collection
     * @param $callback
     * @return JsonResponse
     */
    public function withCollection($collection, $callback)
    {
        $resource = new Collection($collection, $callback);
        return $this->withArray($this->manager->createData($resource)->toArray());
    }

    /**
     * @return JsonResponse
     */
    protected function withNothing()
    {
        return $this->withArray([]);
    }

    /**
     * @param $error_message
     * @return JsonResponse
     * @internal param $error_code
     */
    protected function withError($error_message)
    {
        return $this->withArray(
            [
                'error' => [
                    'error_code' => $this->status_code,
                    'error_message' => $error_message
                ]
            ]
        );
    }

    protected abstract function getHandler();
}