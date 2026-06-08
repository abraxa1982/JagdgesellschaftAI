<?php

declare(strict_types=1);

namespace JagdGesellschaft\Security;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Security\Authenticator\OAuth2Authenticator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

final class BattleNetAuthenticator extends OAuth2Authenticator implements AuthenticationEntryPointInterface
{
    public function __construct(
        private readonly ClientRegistry $clientRegistry,
        private readonly RouterInterface $router,
    ) {}

    public function supports(Request $request): bool
    {
        return 'auth_battlenet_check' === $request->attributes->get('_route');
    }

    public function authenticate(Request $request): Passport
    {
        $client = $this->clientRegistry->getClient('battle_net');
        $accessToken = $this->fetchAccessToken($client);

        return new SelfValidatingPassport(
            new UserBadge(
                $accessToken->getToken(),
                function () use ($accessToken): User {
                    $values = $accessToken->getValues();
                    $idToken = $values['id_token'] ?? '';
                    $rawSubFallback = $values['sub'] ?? '';
                    $sub = \is_scalar($rawSubFallback) ? (string) $rawSubFallback : '';

                    if (\is_string($idToken) && '' !== $idToken) {
                        $parts = explode('.', $idToken);
                        if (3 === \count($parts)) {
                            $decoded = base64_decode(strtr($parts[1], '-_', '+/'), true);
                            if (false !== $decoded) {
                                $payload = json_decode($decoded, true);
                                if (\is_array($payload)) {
                                    $rawSub = $payload['sub'] ?? $sub;
                                    $rawTag = $payload['battle_tag'] ?? '';
                                    $sub = \is_scalar($rawSub) ? (string) $rawSub : $sub;
                                    $battleTag = \is_scalar($rawTag) ? (string) $rawTag : '';
                                    if ('' !== $sub && '' !== $battleTag) {
                                        return new User($sub, $battleTag);
                                    }
                                }
                            }
                        }
                    }

                    throw new \RuntimeException('BattleNet id_token missing or invalid.');
                }
            )
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): Response
    {
        return new RedirectResponse($this->router->generate('home'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        return new Response($exception->getMessageKey(), Response::HTTP_FORBIDDEN);
    }

    public function start(Request $request, ?AuthenticationException $authException = null): Response
    {
        return new RedirectResponse($this->router->generate('auth_battlenet_start'));
    }
}
