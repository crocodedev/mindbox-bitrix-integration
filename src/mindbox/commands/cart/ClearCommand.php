<?php
declare(strict_types=1);

namespace Codedot\Mindbox\Commands\Cart;

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
        return 'ClearCart';
    }

    public function getRequest(): array
    {
        return [];
    }
}