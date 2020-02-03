<?php

declare(strict_types=1);

namespace Ezpizee\Bundle\OAuth2Bundle\Manager;

use Ezpizee\Bundle\OAuth2Bundle\Model\AuthorizationCode;

interface AuthorizationCodeManagerInterface
{
    public function find(string $identifier): ?AuthorizationCode;

    public function save(AuthorizationCode $authCode): void;
}
