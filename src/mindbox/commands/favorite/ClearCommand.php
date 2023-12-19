<?php
declare(strict_types=1);

namespace Codedot\Mindbox\Commands\Favorite;

use Codedot\Mindbox\CommandInterface;
use Codedot\Mindbox\Sendable;

final class ClearCommand implements CommandInterface
{
    use Sendable;

    /**
     * ClearCommand constructor.
     */
    public function __construct()
    {
        $this->initHttpInfo();
    }

    public function getName(): string
    {
        return 'ClearWishList';
    }

    public function getRequest(): array
    {
        return [];
    }
}