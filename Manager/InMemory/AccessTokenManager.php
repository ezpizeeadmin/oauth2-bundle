<?php

declare(strict_types=1);

namespace Ezpizee\Bundle\OAuth2Bundle\Manager\InMemory;

use DateTime;
use Ezpizee\Bundle\OAuth2Bundle\Manager\AccessTokenManagerInterface;
use Ezpizee\Bundle\OAuth2Bundle\Model\AccessToken;

final class AccessTokenManager implements AccessTokenManagerInterface
{
    /**
     * @var AccessToken[]
     */
    private $accessTokens = [];

    /**
     * {@inheritdoc}
     */
    public function find(string $identifier): ?AccessToken
    {
        return $this->accessTokens[$identifier] ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function save(AccessToken $accessToken): void
    {
        $this->accessTokens[$accessToken->getIdentifier()] = $accessToken;
    }

    public function clearExpired(): int
    {
        $count = \count($this->accessTokens);

        $now = new DateTime();
        $this->accessTokens = array_filter($this->accessTokens, function (AccessToken $accessToken) use ($now): bool {
            return $accessToken->getExpiry() >= $now;
        });

        return $count - \count($this->accessTokens);
    }
}
