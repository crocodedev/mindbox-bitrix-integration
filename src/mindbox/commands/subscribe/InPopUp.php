<?php
declare(strict_types=1);

namespace Codedot\Mindbox\Commands\Subscribe;

use Codedot\Mindbox\CommandInterface;
use Codedot\Mindbox\Sendable;

final class InPopUp implements CommandInterface
{
    use Sendable;

    protected array $customer;

    public function __construct(array $user)
    {
        $this->customer = $user;

        $this->customer['subscriptions'][] = [
            "pointOfContact" => "Email",
        ];
    }


    public function getName(): string
    {
        return 'SubscriptionInPopUp';
    }

    public function getRequest(): array
    {
        $data = [];

        $data['customer'] = $this->customer;

        return $data;
    }
}