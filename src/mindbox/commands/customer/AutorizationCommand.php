<?php
declare(strict_types=1);

namespace Codedot\Mindbox\Commands\Customer;

use Codedot\Mindbox\CommandInterface;
use Codedot\Mindbox\Object\Customer;
use Codedot\Mindbox\Sendable;

final class AutorizationCommand implements CommandInterface
{
    use Sendable;

    /** @var Customer Данные пользователя */
    protected Customer $user;

    /**
     * AutorizationCommand constructor.
     *
     * @param Customer $user
     */
    public function __construct(Customer $user)
    {
        $this->user = $user;

        $this->initHttpInfo();
    }

    public function getName(): string
    {
        return 'AuthorizeCustomer';
    }

    public function getRequest(): array
    {
        return $this->user->array();
    }
}
