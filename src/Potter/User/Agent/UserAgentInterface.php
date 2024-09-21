<?php

declare(strict_types=1);

namespace Potter\User\Agent;

use Potter\Database\Table\Aware\TableAwareInterface;

interface UserAgentInterface extends TableAwareInterface
{
    public function createTableIfNotExists(): void;
    public function getCommonId(): int;
    public function getServerAPI(): string;
    public function getUserAgent(): string;
    public function initiate(): void;
    public function isConsoleUser(): bool;
}
