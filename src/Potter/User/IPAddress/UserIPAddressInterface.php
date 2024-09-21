<?php

declare(strict_types=1);

namespace Potter\User\IPAddress;

use Potter\Database\Table\Aware\TableAwareInterface;

interface UserIPAddressInterface extends TableAwareInterface
{
    public function createTableIfNotExists(): void;
    public function initialize(?int $sessionId = null): void;
}
