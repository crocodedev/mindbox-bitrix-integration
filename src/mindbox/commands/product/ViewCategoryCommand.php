<?php
declare(strict_types=1);

namespace Codedot\Mindbox\Commands\Product;

use Codedot\Mindbox\CommandInterface;
use Codedot\Mindbox\Sendable;

final class ViewCategoryCommand implements CommandInterface
{
    use Sendable;

    protected ?int $categoryId = null;

    public function __construct(?int $categoryId = null)
    {
        $this->categoryId = $categoryId;

        $this->initHttpInfo();
    }

    public function getName(): string
    {
        return 'ViewCategory';
    }

    public function getRequest(): array
    {
        return [
            'viewProductCategory' => [
                'productCategory' => [
                    'ids' => [
                        'website' => $this->categoryId,
                    ],
                ],
            ],
        ];
    }
}
