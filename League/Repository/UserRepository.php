<?php

declare(strict_types=1);

namespace Ezpizee\Bundle\OAuth2Bundle\League\Repository;

use Ezpizee\Bundle\OAuth2Bundle\Converter\UserConverterInterface;
use Ezpizee\Bundle\OAuth2Bundle\Event\UserResolveEvent;
use Ezpizee\Bundle\OAuth2Bundle\Manager\ClientManagerInterface;
use Ezpizee\Bundle\OAuth2Bundle\Model\Grant as GrantModel;
use Ezpizee\Bundle\OAuth2Bundle\OAuth2Events;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class UserRepository implements UserRepositoryInterface
{
    /**
     * @var ClientManagerInterface
     */
    private $clientManager;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var UserConverterInterface
     */
    private $userConverter;

    public function __construct(
        ClientManagerInterface $clientManager,
        EventDispatcherInterface $eventDispatcher,
        UserConverterInterface $userConverter
    ) {
        $this->clientManager = $clientManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->userConverter = $userConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function getUserEntityByUserCredentials(
        $username,
        $password,
        $grantType,
        ClientEntityInterface $clientEntity
    ) {
        $client = $this->clientManager->find($clientEntity->getIdentifier());

        $event = $this->eventDispatcher->dispatch(
            new UserResolveEvent(
                $username,
                $password,
                new GrantModel($grantType),
                $client
            ),
            OAuth2Events::USER_RESOLVE
        );

        $user = $event->getUser();

        if (null === $user) {
            return null;
        }

        return $this->userConverter->toLeague($user);
    }
}
