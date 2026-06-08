<?php

declare(strict_types=1);

namespace JagdGesellschaft\Security;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

final class BattleNetResourceOwner implements ResourceOwnerInterface
{
    /** @param array<mixed> $response */
    public function __construct(private readonly array $response) {}

    public function getId(): string
    {
        $id = $this->response['id'] ?? '';

        return \is_scalar($id) ? (string) $id : '';
    }

    public function getBattleTag(): string
    {
        $tag = $this->response['battletag'] ?? '';

        return \is_string($tag) ? $tag : '';
    }

    /** @return array<mixed> */
    public function toArray(): array
    {
        return $this->response;
    }
}
