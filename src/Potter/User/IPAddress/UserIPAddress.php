<?php

declare(strict_types=1);

namespace Potter\User\IPAddress;

use Potter\Aware\AwareTrait;
use Potter\Database\Table\Aware\TableAwareTrait;
use Potter\Database\Table\TableInterface;

final class UserIPAddress extends AbstractUserIPAddress
{
    use AwareTrait, TableAwareTrait, UserIPAddressTrait;
    
    public function __construct(?int $sessionId = null, ?TableInterface $table = null)
    {
        $this->setTable($table);
        $this->initialize($sessionId);
    }
}
