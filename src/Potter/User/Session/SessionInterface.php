<?php

declare(strict_types=1);

namespace Potter\User\Session;

use Potter\Database\Table\Aware\TableAwareInterface;

interface SessionInterface extends TableAwareInterface
{
    public function getSessionId(): string;
    public function getSessionName(): string;
    public function startSession(): void;
}
