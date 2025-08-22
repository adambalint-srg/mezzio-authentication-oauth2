<?php

declare(strict_types=1);

namespace Mezzio\Authentication\OAuth2\Entity;

trait RevokableTrait
{
    protected bool $revoked = false;

    public function isRevoked(): bool
    {
        return $this->revoked;
    }

    public function setRevoked(bool $revoked): void
    {
        $this->revoked = $revoked;
    }
}
