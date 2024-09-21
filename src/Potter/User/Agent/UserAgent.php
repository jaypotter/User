<?php

declare(strict_types=1);

namespace Potter\User\Agent;

use Potter\Aware\AwareTrait;
use Potter\Database\Table\Aware\TableAwareTrait;
use Potter\Database\Table\TableInterface;

final class UserAgent extends AbstractUserAgent
{
    use AwareTrait, TableAwareTrait, UserAgentTrait;
    
    public function __construct(?TableInterface $table = null)
    {
        $this->setTable($table);
        $this->initialize();
    }
}
