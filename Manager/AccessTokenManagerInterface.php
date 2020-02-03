<?php

declare(strict_types=1);

namespace Ezpizee\Bundle\OAuth2Bundle\Manager;

use Ezpizee\Bundle\OAuth2Bundle\Model\AccessToken;

interface AccessTokenManagerInterface
{
    public function find(string $identifier): ?AccessToken;

    public function save(AccessToken $accessToken): void;

    public function clearExpired(): int;
}
