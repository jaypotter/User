<?php

declare(strict_types=1);

namespace Potter\User\Session;

use Potter\Database\Column\Column;
use Potter\Database\Table\TableInterface;
use Potter\User\Agent\UserAgent;
use Potter\User\IPAddress\UserIPAddress;

trait SessionTrait 
{
    private int $commonId;
    
    final public function createTableIfNotExists(): void
    {
        $this->getTable()->createTableIfNotExists(
            new Column('Common_Id', 'int', primaryKey: true),
            new Column('Session_Id', 'varchar(255)', notNull: true),
            new Column('User_Agent', 'int', notNull: true),
            new Column('Last_Seen', 'timestamp', notNull: true, columnDefault: 'CURRENT_TIMESTAMP'));
    }
    
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
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!$this->hasTable()) {
            return;
        }
        $this->createTableIfNotExists();
        $sessionTable = $this->getTable();
        $database = $sessionTable->getDatabase();
        $userAgent = new UserAgent($database->getTable('UserAgents'));
        $userAgentId = $userAgent->getCommonId();
        $sessionId = $this->getSessionId();
        $result = $sessionTable->getRecords(['Session_Id' => $sessionId, 'User_Agent' => $userAgentId])->toArray();
        if (empty($result)) {
            $database->getCommonTable()->getTable()->insertRecord([]);
            $this->commonId = $database->getLastInsertId();
            $sessionTable->insertRecord([
                'Common_Id' =>  $this->commonId,
                'Session_Id' => $sessionId,
                'User_Agent' => $userAgentId]);
        } else {
            $this->commonId = $result[0]['Common_Id'];
            $lastSeen = date("Y-m-d H:i:s");
                $sessionTable->updateRecords(['Last_Seen' => $lastSeen], ['Session_Id' => $sessionId]);
        }
        new UserIPAddress($this->commonId, $database->getTable('UserIPAddresses'));
    }

    abstract public function getTable(): TableInterface;
    abstract public function hasTable(): bool;
}
