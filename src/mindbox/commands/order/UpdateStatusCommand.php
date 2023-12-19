<?php
declare(strict_types=1);

namespace Codedot\Mindbox\Commands\Order;

use Codedot\Mindbox\CommandInterface;
use Codedot\Mindbox\Sendable;

final class UpdateStatusCommand implements CommandInterface
{
    use Sendable;

    protected int $orderId;
    protected int $orderStatus;


    /**
     * RegistrationCommand constructor.
     *
     * @param int $userId
     */
    public function __construct(int $orderId, int $orderStatus)
    {
        $this->orderId = $orderId;
        $this->orderStatus = $orderStatus;

        $this->initHttpInfo();
    }

    public function getName(): string
    {
        return 'UpdateOrderStatus';
    }

    public function getRequest(): array
    {
        return [
            'orderLinesStatus' => $this->orderStatus,
            'order' => [
                'ids' => [
                    'websiteID' => $this->orderId,
                ],
            ],
        ];
    }
}