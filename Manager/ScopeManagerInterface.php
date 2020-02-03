<?php

declare(strict_types=1);

namespace Ezpizee\Bundle\OAuth2Bundle\Manager;

use Ezpizee\Bundle\OAuth2Bundle\Model\Scope;

interface ScopeManagerInterface
{
    public function find(string $identifier): ?Scope;

    public function save(Scope $scope): void;
}
