<?php

declare(strict_types=1);

namespace Potter\User\Session;

use Potter\Aware\AwareTrait;
use Potter\Database\Table\{
    TableInterface,
    Aware\TableAwareTrait
};

final class Session extends AbstractSession
{
    use AwareTrait, SessionTrait, TableAwareTrait;
    
    public function __construct(?string $sessionName = null, ?TableInterface $table = null)
    {
        if (!is_null($sessionName)) {
            $this->setSessionName($sessionName);
        }
        $this->startSession();
        $this->setTable($table);
        if (!$this->hasTable()) {
            return;
        }
        $this->createTableIfNotExists();
    }
}
