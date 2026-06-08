<?php

declare(strict_types=1);

namespace JagdGesellschaft\Tests\Unit\Security;

use JagdGesellschaft\Security\BattleNetResourceOwner;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(BattleNetResourceOwner::class)]
final class BattleNetResourceOwnerTest extends TestCase
{
    #[Test]
    public function getIdReturnsStringId(): void
    {
        $owner = new BattleNetResourceOwner(['id' => 123, 'battletag' => 'Foo#1']);

        self::assertSame('123', $owner->getId());
    }

    #[Test]
    public function getBattleTagReturnsBattleTag(): void
    {
        $owner = new BattleNetResourceOwner(['id' => 123, 'battletag' => 'Foo#1']);

        self::assertSame('Foo#1', $owner->getBattleTag());
    }

    #[Test]
    public function toArrayReturnsRawResponse(): void
    {
        $data = ['id' => 123, 'battletag' => 'Foo#1'];
        $owner = new BattleNetResourceOwner($data);

        self::assertSame($data, $owner->toArray());
    }
}
