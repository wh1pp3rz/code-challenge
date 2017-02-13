<?php

namespace AppBundle\Handler;

use AppBundle\Repository\ProductsRepository;
use Appbundle\Entity\Product;
use Symfony\Component\HttpFoundation\ParameterBag;

class ProductsHandler implements HandlerInterface
{

    private $repository;

    const PRODUCT_NAME_FIELD = 'name';
    const CATEGORY_NAME_FIELD = 'category';
    const SKU_FIELD = 'sku';
    const PRICE_FIELD = 'price';
    const QUANTITY_FIELD = 'quantity';

    public function __construct(ProductsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $id
     * @return null|object
     */
    public function get($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param $limit
     * @param $offset
     * @return array
     */
    public function all($limit, $offset)
    {
       return $this->repository->findBy([],[], $limit, $offset);
    }

    /**
     * @param Product $product
     * @param ParameterBag $data
     * @return bool
     */
    public function patch(Product $product, ParameterBag $data)
    {
        try{
            $this->update($product, $data);
            $this->repository->getEntityManager()->flush();
            return true;
        } catch(\Exception $e) {
            return false;
        }
    }

    /**
     * @param ParameterBag $data
     * @return Product
     */
    public function post(ParameterBag $data)
    {
        $product = new Product();
        $this->update($product, $data);
        $this->repository->getEntityManager()->persist($product);
        $this->repository->getEntityManager()->flush();

        return $product;
    }

    /**
     * @param Product $product
     */
    public function delete(Product &$product)
    {
        $this->repository->getEntityManager()->remove($product);
        $this->repository->getEntityManager()->flush();
    }

    /**
     * @param Product $product
     * @param ParameterBag $data
     */
    private function update(Product &$product, ParameterBag $data)
    {
        // This would have better handled by a Symfony Form with proper validation
        // Quick hack in the interest of time

        $product->setName($data->get(static::PRODUCT_NAME_FIELD));
        $product->setCategory(
            $this->findOrCreateCategory(
                $data->get(static::CATEGORY_NAME_FIELD)
            )
        );
        $product->setSku($data->get(static::SKU_FIELD));
        $product->setPrice($data->get(static::PRICE_FIELD));
        $product->setQuantity($data->get(static::QUANTITY_FIELD));
    }

    /**
     * @param $category_name
     * @return null|object
     */
    private function findOrCreateCategory($category_name)
    {
        $category_handler = new CategoriesHandler(
            $this->repository
                ->getEntityManager()
                ->getRepository('AppBundle:Category')
        );

        return $category_handler->findOrCreate($category_name);
    }
}