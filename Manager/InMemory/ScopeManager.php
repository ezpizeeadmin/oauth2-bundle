<?php

declare(strict_types=1);

namespace Ezpizee\Bundle\OAuth2Bundle\Manager\InMemory;

use Ezpizee\Bundle\OAuth2Bundle\Manager\ScopeManagerInterface;
use Ezpizee\Bundle\OAuth2Bundle\Model\Scope;

final class ScopeManager implements ScopeManagerInterface
{
    /**
     * @var Scope[]
     */
    private $scopes = [];

    /**
     * {@inheritdoc}
     */
    public function find(string $identifier): ?Scope
    {
        return $this->scopes[$identifier] ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function save(Scope $scope): void
    {
        $this->scopes[(string) $scope] = $scope;
    }
}
