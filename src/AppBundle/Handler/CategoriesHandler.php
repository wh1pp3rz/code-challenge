<?php

namespace AppBundle\Handler;

use AppBundle\Repository\CategoryRepository;
use AppBundle\Entity\Category;

class CategoriesHandler  implements HandlerInterface
{
    private $repository;

    public function __construct(CategoryRepository $repository)
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
     * @param $name
     * @return null|object
     */
    public function findOrCreate($name)
    {
        $category = $this->repository->findOneBy(['name' => $name]);
        if (empty($category)) {
            $category = new Category();
            $category->setName($name);
            $this->repository->getEntityManager()->persist($category);
            $this->repository->getEntityManager()->flush();
        }
        return $category;
    }
}