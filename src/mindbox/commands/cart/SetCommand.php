<?php
declare(strict_types=1);

namespace Codedot\Mindbox\Commands\Cart;

use Codedot\Mindbox\CommandInterface;
use Codedot\Mindbox\Object\ProductList;
use Codedot\Mindbox\Sendable;

final class SetCommand implements CommandInterface
{
    use Sendable;

    protected productList $cart;

    /**
     * SetCommand constructor.
     *
     * @param array $products
     */
    public function __construct(ProductList $productList)
    {
        $this->cart = $productList;

        $this->initHttpInfo();
    }

    public function getName(): string
    {
        return 'SetCart';
    }

    public function getRequest(): array
    {
        return $this->cart->array();
    }
}