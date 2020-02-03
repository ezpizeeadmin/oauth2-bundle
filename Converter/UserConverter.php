<?php

declare(strict_types=1);

namespace Ezpizee\Bundle\OAuth2Bundle\Converter;

use Ezpizee\Bundle\OAuth2Bundle\League\Entity\User;
use League\OAuth2\Server\Entities\UserEntityInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class UserConverter implements UserConverterInterface
{
    public function toLeague(?UserInterface $user): UserEntityInterface
    {
        $userEntity = new User();
        if ($user instanceof UserInterface) {
            $userEntity->setIdentifier($user->getUsername());
        }

        return $userEntity;
    }
}
