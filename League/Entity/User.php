<?php

declare(strict_types=1);

namespace Ezpizee\Bundle\OAuth2Bundle\League\Entity;

use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\UserEntityInterface;

final class User implements UserEntityInterface
{
    use EntityTrait;
}
