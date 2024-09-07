<?php

declare(strict_types=1);

namespace Potter\User\Session;

use Potter\{
    Aware\AwareTrait,
    Database\Table\Aware\TableAwareTrait
};

final class Session extends AbstractSession
{
    use AwareTrait, SessionTrait, TableAwareTrait;
    
    public function __construct(?string $sessionName = null)
    {
        if (!is_null($sessionName)) {
            $this->setSessionName($sessionName);
        }
        $this->startSession();
        if (!$this->hasTable()) {
            return;
        }
        $this->createTableIfNotExists();
    }
}
