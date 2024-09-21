<?php

declare(strict_types=1);

namespace Potter\User\IPAddress;

use Potter\Database\Table\TableInterface;

trait UserIPAddressTrait 
{
    final public function createTableIfNotExists(): void
    {
        $this->getTable()->createTableIfNotExists(
            new Column('Common_Id', 'int', primaryKey: true),
            new Column('IP_Address', 'varchar(255)', notNull: true),
            new Column('Session', 'int', notNull: true));
    }
    
    final public function initialize(?int $sessionId = null): void
    {
        if (!array_key_exists('REMOTE_ADDR', $_SESSION)) {
            return;
        }
        $userIP = $_SERVER['REMOTE_ADDR'];
        if (!$this->hasTable() || is_null($sessionId)) {
            return;
        }
        $this->createTableIfNotExists();
        $userIPTable = $this->getTable();
        $result = $userIPTable->getRecords(['IP_Address' => $userIP, 'Session' => $sessionId])->toArray();
        if (count($result) > 0) {
            return;
        }
        $userIPTable->insertRecord(['IP_Address' => $userIP, 'Session' => $sessionId]);
    }
    
    abstract public function getTable(): TableInterface;
    abstract public function hasTable(): bool;
}
