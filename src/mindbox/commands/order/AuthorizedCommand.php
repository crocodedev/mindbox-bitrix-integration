<?php
declare(strict_types=1);

namespace Codedot\Mindbox\Commands\Order;

use Codedot\Mindbox\CommandInterface;
use Codedot\Mindbox\Object\Customer;
use Codedot\Mindbox\Sendable;

final class AuthorizedCommand implements CommandInterface
{
    use Sendable;

    /** @var Customer Данные пользователя */
    protected Customer $user;

    protected array $order;

    /**
     * RegistrationCommand constructor.
     *
     * @param Customer $user
     * @param array $order
     */
    public function __construct(Customer $user, array $order)
    {
        $this->user = $user;
        $this->order = $order;

        $this->initHttpInfo();
    }

    public function getName(): string
    {
        return 'CreateAuthorizedOrder';
    }

    public function getRequest(): array
    {
        return [
            'customer' => $this->user->array()['customer'],
            'order' => $this->order
        ];
    }
}