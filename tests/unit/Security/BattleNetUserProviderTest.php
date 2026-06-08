<?php

declare(strict_types=1);

namespace JagdGesellschaft\Tests\Unit\Security;

use JagdGesellschaft\Security\BattleNetUserProvider;
use JagdGesellschaft\Security\User;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @internal
 */
#[CoversClass(BattleNetUserProvider::class)]
final class BattleNetUserProviderTest extends TestCase
{
    private BattleNetUserProvider $provider;

    protected function setUp(): void
    {
        $this->provider = new BattleNetUserProvider();
    }

    #[Test]
    public function supportsUserClass(): void
    {
        self::assertTrue($this->provider->supportsClass(User::class));
    }

    #[Test]
    public function doesNotSupportOtherClass(): void
    {
        self::assertFalse($this->provider->supportsClass(\stdClass::class));
    }

    #[Test]
    public function refreshUserReturnsUnchangedUser(): void
    {
        $user = new User('42', 'Tank#1');
        $refreshed = $this->provider->refreshUser($user);

        self::assertSame($user, $refreshed);
    }

    #[Test]
    public function refreshUserThrowsForUnsupportedClass(): void
    {
        $unsupported = $this->createStub(UserInterface::class);

        $this->expectException(UnsupportedUserException::class);
        $this->provider->refreshUser($unsupported);
    }

    #[Test]
    public function loadUserByIdentifierThrowsUserNotFoundException(): void
    {
        $this->expectException(UserNotFoundException::class);
        $this->provider->loadUserByIdentifier('any-id');
    }
}
