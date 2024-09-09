<?php

declare(strict_types=1);

namespace Potter\User\Agent;

use Potter\Database\{
    Column\Column,
    Table\TableInterface
};

trait UserAgentTrait 
{
    final public function createTableIfNotExists(): void
    {
        $this->getTable()->createTableIfNotExists(
            new Column('Common_Id', 'int', primaryKey: true),
            new Column('User_Agent', 'varchar(255)', notNull: true));
    }
    
    final public function getServerAPI(): string
    {
        return php_sapi_name();
    }
    
    final public function getUserAgent(): string
    {
        return $this->isConsoleUser() ? $this->getServerAPI() : $_SERVER['HTTP_USER_AGENT'];
    }
    
    final public function initiate(): void
    {
        if (!$this->hasTable()) {
            return;
        }
        $this->createTableIfNotExists();
        $userAgentTable = $this->getTable();
        $database = $userAgentTable->getDatabase();
        $database->getCommonTable()->getTable()->insertRecord([]);
        $userAgentCommonId = $database->getLastInsertId();
        $userAgentTable->insertRecord([
            'Common_Id' => $userAgentCommonId,
            'User_Agent' => $this->getUserAgent()]);
    }
    
    final public function isConsoleUser(): bool
    {
        return $this->getServerAPI() === 'cli';
    }
    
    abstract public function getTable(): TableInterface;
    abstract public function hasTable(): bool;
}
