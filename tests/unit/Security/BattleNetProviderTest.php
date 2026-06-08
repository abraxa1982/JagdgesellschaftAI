<?php

declare(strict_types=1);

namespace JagdGesellschaft\Tests\Unit\Security;

use JagdGesellschaft\Security\BattleNetProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(BattleNetProvider::class)]
final class BattleNetProviderTest extends TestCase
{
    #[Test]
    public function authorizationUrlContainsRegion(): void
    {
        $provider = new BattleNetProvider(['clientId' => 'id', 'clientSecret' => 'secret', 'region' => 'eu']);

        self::assertStringContainsString('eu.battle.net', $provider->getBaseAuthorizationUrl());
    }

    #[Test]
    public function tokenUrlContainsRegion(): void
    {
        $provider = new BattleNetProvider(['clientId' => 'id', 'clientSecret' => 'secret', 'region' => 'us']);

        self::assertStringContainsString('us.battle.net', $provider->getBaseAccessTokenUrl([]));
    }

    #[Test]
    public function defaultRegionIsEu(): void
    {
        $provider = new BattleNetProvider(['clientId' => 'id', 'clientSecret' => 'secret']);

        self::assertStringContainsString('eu.battle.net', $provider->getBaseAuthorizationUrl());
    }
}
