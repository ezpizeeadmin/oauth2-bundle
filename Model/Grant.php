<?php

declare(strict_types=1);

namespace Ezpizee\Bundle\OAuth2Bundle\Model;

use Ezpizee\Bundle\OAuth2Bundle\OAuth2Grants;
use RuntimeException;

class Grant
{
    /**
     * @var string
     */
    private $grant;

    public function __construct(string $grant)
    {
        if (!OAuth2Grants::has($grant)) {
            throw new RuntimeException(sprintf('The \'%s\' grant is not supported.', $grant));
        }

        $this->grant = $grant;
    }

    public function __toString(): string
    {
        return $this->grant;
    }
}
