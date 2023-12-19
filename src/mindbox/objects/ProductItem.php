<?php
declare(strict_types=1);

namespace Codedot\Mindbox\Object;

class ProductItem
{
    use ObjectStandart;

    private Product $product;
    private ProductGroup $productGroup;
    private int $count = 0;
    private float $pricePerItem = 0.0;
    private float $priceOfLine = 0.0;

    public function __construct(array $params = []) {
        $this->name = 'productItem';

        foreach ($params as $key => $value) {
            $setter = "set" . ucfirst($key);

            if (method_exists($this, $setter)) {
                $this->$setter($value);
            }
        }
    }

    public function setProduct(Product $product): ProductItem
    {
        $this->product = $product;
        return $this;
    }

    public function setProductGroup(ProductGroup $productGroup): ProductItem
    {
        $this->productGroup = $productGroup;
        return $this;
    }

    public function setCount(int $count): ProductItem
    {
        $this->count = $count;
        return $this;
    }

    public function setPricePerItem(float $pricePerItem): ProductItem
    {
        $this->pricePerItem = $pricePerItem;
        return $this;
    }

    public function setPriceOfLine(float $priceOfLine): ProductItem
    {
        $this->priceOfLine = $priceOfLine;
        return $this;
    }

    public function getProduct(): ?array
    {
        return (!empty($this->product)) ? $this->product->array()['product'] : null;
    }

    public function getProductGroup(): ?array
    {
        return (!empty($this->productGroup)) ? $this->productGroup->array()['productGroup'] : null;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function getPricePerItem(): float
    {
        return $this->pricePerItem;
    }
}
