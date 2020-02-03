<?php

declare(strict_types=1);

namespace Ezpizee\Bundle\OAuth2Bundle\Tests\Fixtures;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

final class SecurityTestController extends AbstractController
{
    public function helloAction(): Response
    {
        /** @var UserInterface $user */
        $user = $this->getUser();

        return new Response(
            sprintf('Hello, %s', (null !== $user) ? $user->getUsername() : 'guest')
        );
    }

    public function scopeAction(): Response
    {
        return new Response('Only certain scopes should be able to access this action.');
    }

    public function rolesAction(): Response
    {
        $roles = $this->get('security.token_storage')->getToken()->getUser()->getRoles();

//        $roles = array_map(function (string $role): string {
//            return $role;
//        }, $roles);
        return new Response(
            sprintf(
                'These are the roles I have currently assigned: %s',
                implode(', ', $roles)
            )
        );
    }
}
