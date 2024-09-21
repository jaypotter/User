<?php

declare(strict_types=1);

namespace Potter\User\IPAddress;

use Potter\Database\Table\Aware\AbstractTableAware;

abstract class AbstractUserIPAddress extends AbstractTableAware implements UserIPAddressInterface
{
    abstract public function createTableIfNotExists(): void;
    abstract public function initialize(?int $sessionId = null): void;
}
