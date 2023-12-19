<?php
declare(strict_types=1);

namespace Codedot\Mindbox\Object;

use JetBrains\PhpStorm\ArrayShape;

class ProductList
{
    use ObjectStandart;

    private array $productList = [];

    public function __construct(array $params = []) {
        $this->name = 'productItem';

        foreach ($params as $key => $value) {
            $setter = "set" . ucfirst($key);

            if (method_exists($this, $setter)) {
                $this->$setter($value);
            }
        }
    }

    public function setProduct(ProductItem $productItem): ProductList
    {
        $this->productList[] = $productItem;
        return $this;
    }

    public function array(): array
    {
        $productItems = [];
        foreach ($this->productList as $productItem) {
            $productItems[] = $productItem->array()['productItem'];
        }

        return (count($productItems)) ? [
            'productList' => $productItems
        ] : [];
    }
}
