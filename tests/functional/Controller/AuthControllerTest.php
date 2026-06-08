<?php

declare(strict_types=1);

namespace JagdGesellschaft\Tests\Functional\Controller;

use JagdGesellschaft\Controller\AuthController;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @internal
 */
#[CoversClass(AuthController::class)]
final class AuthControllerTest extends WebTestCase
{
    #[Test]
    public function startRedirectsToBattleNet(): void
    {
        $client = self::createClient();
        $client->request('GET', '/auth/battlenet');

        self::assertResponseRedirects();
        self::assertStringContainsString('battle.net/oauth/authorize', (string) $client->getResponse()->headers->get('Location'));
    }

    #[Test]
    public function checkRouteWithoutAuthCodeDoesNotReturn500(): void
    {
        $client = self::createClient();
        $client->request('GET', '/auth/battlenet/check');

        self::assertNotSame(500, $client->getResponse()->getStatusCode());
    }

    #[Test]
    public function homeRouteIsPublicWithoutLogin(): void
    {
        $client = self::createClient();
        $client->request('GET', '/');

        self::assertResponseIsSuccessful();
    }
}
