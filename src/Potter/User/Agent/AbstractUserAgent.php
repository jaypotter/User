<?php

declare(strict_types=1);

namespace Potter\User\Agent;

abstract class AbstractUserAgent implements UserAgentInterface
{
    abstract public function createTableIfNotExists(): void;
    abstract public function getCommonId(): int;
    abstract public function getServerAPI(): string;
    abstract public function getUserAgent(): string;
    abstract public function initiate(): void;
    abstract public function isConsoleUser(): bool;
}
