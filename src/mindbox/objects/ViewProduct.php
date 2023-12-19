<?php
declare(strict_types=1);

namespace Codedot\Mindbox\Object;

use JetBrains\PhpStorm\ArrayShape;
use \ReflectionClass;
use \ReflectionMethod;

class ViewProduct
{
    use ObjectStandart;

    private Product $product;
    private ProductGroup $productGroup;

    public function __construct($params) {
        $this->name = 'viewProduct';

        foreach ($params as $keyParam => $valueParam) {
            $setKey = "set$keyParam";

            $this->$setKey($valueParam);
        }
    }

    public function setProduct(Product $product): ViewProduct
    {
        $this->product = $product;
        return $this;
    }

    public function setProductGroup(ProductGroup $productGroup): ViewProduct
    {
        $this->productGroup = $productGroup;
        return $this;
    }

    public function getProduct(): ?array
    {
        $data = null;
        if (!empty($this->product)) {
            $data = $this->product->array()['product'];
        }

        return $data;
    }

    public function getProductGroup(): ?array
    {
        $data = null;
        if (!empty($this->productGroup)) {
            $data = $this->productGroup->array()['productGroup'];
        }

        return $data;
    }
}