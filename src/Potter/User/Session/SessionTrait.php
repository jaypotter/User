<?php

declare(strict_types=1);

namespace Potter\User\Session;

use Potter\Database\Table\TableInterface;
use Potter\Database\Column\Column;

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
    }
    
    final public function createTableIfNotExists(): void
    {
        $this->getTable()->createTableIfNotExists(
            new Column('Common_Id', 'int', notNull: true),
            new Column('Session_Name', 'varchar(255)', notNull: true)
        );
    }
    
    abstract public function getTable(): TableInterface;
}
