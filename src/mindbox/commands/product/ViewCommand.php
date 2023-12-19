<?php
declare(strict_types=1);

namespace Codedot\Mindbox\Commands\Product;

use Codedot\Mindbox\CommandInterface;
use Codedot\Mindbox\Sendable;

final class ViewCommand implements CommandInterface
{
    use Sendable;

    /** @var int|null ID продукта */
    protected ?int $productId;
    /** @var int|null ID группы продуктов */
    protected ?int $groupId;

    /**
     * ViewCommand constructor.
     *
     * @param int|null $productId
     * @param int|null $groupId
     */
    public function __construct(?int $productId = null, ?int $groupId = null)
    {
        $this->productId = $productId;
        $this->groupId = $groupId;

        $this->initHttpInfo();
    }

    public function getName(): string
    {
        return 'ViewProduct';
    }

    public function getRequest(): array
    {
        $data = [];
        if (!empty($this->productId))
        $data['product'] = [
            'ids' => [
                'website' => $this->productId
            ]
        ];
        if (!empty($this->groupId))
        $data['productGroup'] = [
            'ids' => [
                'website' => $this->groupId
            ]
        ];

        $result = [];
        $result['viewProduct'] = $data;

        return $result;
    }
}