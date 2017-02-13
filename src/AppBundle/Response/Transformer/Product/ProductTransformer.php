<?php

namespace AppBundle\Response\Transformer\Product;

use AppBundle\Entity\Product;
use League\Fractal\TransformerAbstract as FractalTransformer;

class ProductTransformer extends FractalTransformer
{
    public function transform(Product $product)
    {
        return [
            'id' => (int)$product->getId(),
            'name' => (string)$product->getName(),
            'category' => (string)$product->getCategory()->getName(),
            'sku' => (string)$product->getSku(),
            'price' => (float)$product->getPrice(),
            'quantity' => (int)$product->getQuantity()
        ];
    }
}
