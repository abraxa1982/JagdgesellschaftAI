<?php

declare(strict_types=1);

namespace JagdGesellschaft\Security;

use Symfony\Component\Security\Core\User\UserInterface;

final class User implements UserInterface
{
    public function __construct(
        private readonly string $battleNetId,
        private readonly string $battleTag,
    ) {}

    public function __serialize(): array
    {
        return [
            'battleNetId' => $this->battleNetId,
            'battleTag' => $this->battleTag,
        ];
    }

    /** @param array<string, string> $data */
    public function __unserialize(array $data): void
    {
        $this->battleNetId = $data['battleNetId'];
        $this->battleTag = $data['battleTag'];
    }

    public function getUserIdentifier(): string
    {
        if ('' === $this->battleNetId) {
            throw new \LogicException('battleNetId must not be empty.');
        }

        return $this->battleNetId;
    }

    public function getBattleTag(): string
    {
        return $this->battleTag;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function eraseCredentials(): void {}
}
