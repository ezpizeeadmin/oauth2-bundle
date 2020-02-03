<?php

declare(strict_types=1);

namespace Ezpizee\Bundle\OAuth2Bundle\EventListener;

use Ezpizee\Bundle\OAuth2Bundle\Event\AuthorizationRequestResolveEvent;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Listener sets currently authenticated user to authorization request context
 */
final class AuthorizationRequestUserResolvingListener
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function onAuthorizationRequest(AuthorizationRequestResolveEvent $event): void
    {
        $user = $this->security->getUser();
        if ($user instanceof UserInterface) {
            $event->setUser($user);
        }
    }
}
