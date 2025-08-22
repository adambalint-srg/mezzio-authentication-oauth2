<?php

declare(strict_types=1);

namespace Mezzio\Authentication\OAuth2\Repository\Pdo;

use League\OAuth2\Server\Entities\ScopeEntityInterface;
use PDO;

use function array_reduce;
use function trim;

class AbstractRepository
{
    public function __construct(protected PDO $pdo)
    {
    }

    /**
     * Return a string of scopes, separated by space
     * from ScopeEntityInterface[]
     *
     * @param ScopeEntityInterface[] $scopes
     */
    protected function scopesToString(array $scopes): string
    {
        if (empty($scopes)) {
            return '';
        }

        return trim(array_reduce(
            $scopes,
            static function (?string $result, ScopeEntityInterface $item): string {
                $result = $result ?? '';

                return $result . ' ' . $item->getIdentifier();
            }
        ));
    }
}
