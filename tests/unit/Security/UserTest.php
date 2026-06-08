<?php

declare(strict_types=1);

namespace JagdGesellschaft\Tests\Unit\Security;

use JagdGesellschaft\Security\User;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(User::class)]
final class UserTest extends TestCase
{
    #[Test]
    public function getUserIdentifierReturnsBattleNetId(): void
    {
        $user = new User('12345', 'Haku#1234');

        self::assertSame('12345', $user->getUserIdentifier());
    }

    #[Test]
    public function getBattleTagReturnsBattleTag(): void
    {
        $user = new User('12345', 'Haku#1234');

        self::assertSame('Haku#1234', $user->getBattleTag());
    }

    #[Test]
    public function rolesContainRoleUser(): void
    {
        $user = new User('12345', 'Haku#1234');

        self::assertContains('ROLE_USER', $user->getRoles());
    }

    #[Test]
    public function serializationRoundTripPreservesAllData(): void
    {
        $user = new User('99887', 'Raid#7777');
        $serialized = serialize($user);

        /** @var User $restored */
        $restored = unserialize($serialized);

        self::assertSame('99887', $restored->getUserIdentifier());
        self::assertSame('Raid#7777', $restored->getBattleTag());
        self::assertContains('ROLE_USER', $restored->getRoles());
    }

    #[Test]
    public function eraseCredentialsIsNoop(): void
    {
        $user = new User('12345', 'Haku#1234');
        $user->eraseCredentials();

        self::assertSame('12345', $user->getUserIdentifier());
        self::assertSame('Haku#1234', $user->getBattleTag());
    }
}
