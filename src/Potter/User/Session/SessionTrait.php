<?php

declare(strict_types=1);

namespace Potter\User\Session;

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
}
