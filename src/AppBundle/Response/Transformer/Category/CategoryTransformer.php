<?php

namespace AppBundle\Response\Transformer\Category;

use AppBundle\Entity\Category;
use League\Fractal\TransformerAbstract as FractalTransformer;

class CategoryTransformer extends FractalTransformer
{
    public function transform(Category $category)
    {
        return [
            'id' => (int)$category->getId(),
            'name' => (string)$category->getName()
        ];
    }
}
