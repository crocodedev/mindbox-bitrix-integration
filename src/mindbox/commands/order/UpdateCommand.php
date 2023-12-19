<?php
declare(strict_types=1);

namespace Codedot\Mindbox\Commands\Order;

use Codedot\Mindbox\CommandInterface;
use Codedot\Mindbox\Sendable;

final class UpdateCommand implements CommandInterface
{
    use Sendable;

    protected int $customerId;
    protected array $order;


    /**
     * RegistrationCommand constructor.
     *
     * @param int $customerId
     * @param array $order
     */
    public function __construct(int $customerId, array $order)
    {
        $this->customerId = $customerId;
        $this->order = $order;

        $this->initHttpInfo();
    }

    public function getName(): string
    {
        return 'UpdateOrder';
    }

    public function getRequest(): array
    {
        return [
            'customer' => [
                'ids' => ['websiteID' => $this->customerId,],
            ],
            'order' => $this->order,
        ];
    }
}