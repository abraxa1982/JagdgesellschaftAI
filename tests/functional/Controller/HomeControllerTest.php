<?php

declare(strict_types=1);

namespace JagdGesellschaft\Tests\Functional\Controller;

use JagdGesellschaft\Controller\HomeController;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @internal
 */
#[CoversClass(HomeController::class)]
final class HomeControllerTest extends WebTestCase
{
    #[Test]
    public function homepageReturnsSuccessfulResponse(): void
    {
        $client = self::createClient();
        $client->request('GET', '/');

        self::assertResponseIsSuccessful();
    }

    #[Test]
    public function homepageDisplaysGuildName(): void
    {
        $client = self::createClient();
        $client->request('GET', '/');

        self::assertSelectorTextContains('h2', 'Jagdgesellschaft');
    }

    #[Test]
    public function homepageIncludesGuildLogo(): void
    {
        $client = self::createClient();
        $client->request('GET', '/');

        self::assertSelectorExists('img[src*="jagdgesellschaft.png"]');
    }
}
