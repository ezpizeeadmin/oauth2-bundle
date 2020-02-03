<?php

declare(strict_types=1);

namespace Ezpizee\Bundle\OAuth2Bundle\Manager;

use Ezpizee\Bundle\OAuth2Bundle\Model\RefreshToken;

interface RefreshTokenManagerInterface
{
    public function find(string $identifier): ?RefreshToken;

    public function save(RefreshToken $refreshToken): void;

    public function clearExpired(): int;
}
