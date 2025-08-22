<?php

declare(strict_types=1);

namespace Mezzio\Authentication\OAuth2\Entity;

use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\UserEntityInterface;

class UserEntity implements UserEntityInterface
{
    use EntityTrait;

    /**
     * Create a new user instance.
     *
     * @param non-empty-string|int $identifier
     */
    public function __construct(string|int $identifier)
    {
        $this->setIdentifier((string) $identifier);
    }
}
