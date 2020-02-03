<?php

declare(strict_types=1);

namespace Ezpizee\Bundle\OAuth2Bundle\Tests\Acceptance;

use DateTime;
use Ezpizee\Bundle\OAuth2Bundle\Manager\Doctrine\RefreshTokenManager as DoctrineRefreshTokenManager;
use Ezpizee\Bundle\OAuth2Bundle\Model\AccessToken;
use Ezpizee\Bundle\OAuth2Bundle\Model\Client;
use Ezpizee\Bundle\OAuth2Bundle\Model\RefreshToken;

/**
 * @TODO   This should be in the Integration tests folder but the current tests infrastructure would need improvements first.
 * @covers \Ezpizee\Bundle\OAuth2Bundle\Manager\Doctrine\RefreshTokenManager
 */
final class DoctrineRefreshTokenManagerTest extends AbstractAcceptanceTest
{
    public function testClearExpired(): void
    {
        $em = $this->client->getContainer()->get('doctrine.orm.entity_manager');

        $doctrineRefreshTokenManager = new DoctrineRefreshTokenManager($em);

        $client = new Client('client', 'secret');
        $em->persist($client);
        $em->flush();

        timecop_freeze(new DateTime());

        try {
            $testData = $this->buildClearExpiredTestData($client);

            /** @var RefreshToken $token */
            foreach ($testData['input'] as $token) {
                $em->persist($token->getAccessToken());
                $doctrineRefreshTokenManager->save($token);
            }

            $em->flush();

            $this->assertSame(3, $doctrineRefreshTokenManager->clearExpired());
        } finally {
            timecop_return();
        }

        $this->assertSame(
            $testData['output'],
            $em->getRepository(RefreshToken::class)->findBy([], ['identifier' => 'ASC'])
        );
    }

    private function buildClearExpiredTestData(Client $client): array
    {
        $validRefreshTokens = [
            $this->buildRefreshToken('1111', '+1 day', $client),
            $this->buildRefreshToken('2222', '+1 hour', $client),
            $this->buildRefreshToken('3333', '+1 second', $client),
            $this->buildRefreshToken('4444', 'now', $client),
        ];

        $expiredRefreshTokens = [
            $this->buildRefreshToken('5555', '-1 day', $client),
            $this->buildRefreshToken('6666', '-1 hour', $client),
            $this->buildRefreshToken('7777', '-1 second', $client),
        ];

        return [
            'input' => array_merge($validRefreshTokens, $expiredRefreshTokens),
            'output' => $validRefreshTokens,
        ];
    }

    private function buildRefreshToken(string $identifier, string $modify, Client $client): RefreshToken
    {
        return new RefreshToken(
            $identifier,
            (new DateTime())->modify($modify),
            new AccessToken(
                $identifier,
                (new DateTime('+1 day')),
                $client,
                null,
                []
            )
        );
    }
}
