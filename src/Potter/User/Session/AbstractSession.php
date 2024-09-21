<?php

declare(strict_types=1);

namespace Potter\User\Session;

use Potter\Database\Table\Aware\AbstractTableAware;

abstract class AbstractSession extends AbstractTableAware implements SessionInterface
{
    abstract public function createTableIfNotExists(): void;
    abstract public function getSessionId(): string;
    abstract protected function setSessionId(string $sessionId): string;
    abstract public function getSessionName(): string;
    abstract protected function setSessionName(string $sessionName): string;
    abstract public function startSession(): void;
}
