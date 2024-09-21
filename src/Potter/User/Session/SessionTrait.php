<?php

declare(strict_types=1);

namespace Potter\User\Session;

use Potter\Database\Column\Column;
use Potter\Database\Table\TableInterface;

trait SessionTrait 
{
    final public function getSessionId(): string
    {
        return session_id();
    }
    
    final protected function setSessionId(string $sessionId): string
    {
        return session_id($sessionId);
    }
    
    final public function getSessionName(): string
    {
        return session_name();
    }
    
    final protected function setSessionName(string $sessionName): string
    {
        return session_name($sessionName);
    }
    
    final public function startSession(): void
    {
        session_start();
        if (!$this->hasTable()) {
            return;
        }
        $this->createTableIfNotExists();
        $sessionTable = $this->getTable();
        $database = $sessionTable->getDatabase();
        $sessionId = $this->getSessionId();
        $result = $sessionTable->getRecords(['Session_Id' => $sessionId])->toArray();
        if (!empty($result)) {
            $lastSeen = date("Y-m-d H:i:s");
            $sessionTable->updateRecords(['Session_Id' => $sessionId], ['Last_Seen' => $lastSeen]);
            return;
        }
        $database->getCommonTable()->getTable()->insertRecord([]);
        $sessionCommonId = $database->getLastInsertId();
        $sessionTable->insertRecord([
            'Common_Id' => $sessionCommonId,
            'Session_Id' => $sessionId]);
    }
    
    final public function createTableIfNotExists(): void
    {
        $this->getTable()->createTableIfNotExists(
            new Column('Common_Id', 'int', primaryKey: true),
            new Column('Session_Id', 'varchar(255)', notNull: true),
            new Column('Last_Seen', 'timestamp', notNull: true, columnDefault: 'CURRENT_TIMESTAMP')
        );
    }
    
    abstract public function getTable(): TableInterface;
    abstract public function hasTable(): bool;
}
