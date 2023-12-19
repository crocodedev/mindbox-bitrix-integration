<?php
declare(strict_types=1);

namespace Codedot\Mindbox\Commands\Favorite;

use Codedot\Mindbox\CommandInterface;
use Codedot\Mindbox\Object\ProductList;
use Codedot\Mindbox\Sendable;

final class SetCommand implements CommandInterface
{
    use Sendable;

    protected productList $favorite;

    /**
     * SetCommand constructor.
     *
     * @param productList $productList
     */
    public function __construct(ProductList $productList)
    {
        $this->favorite = $productList;

        $this->initHttpInfo();
    }

    public function getName(): string
    {
        return 'SetWishList';
    }

    public function getRequest(): array
    {
        return $this->favorite->array();
    }
}