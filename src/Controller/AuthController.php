<?php

declare(strict_types=1);

namespace JagdGesellschaft\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AuthController extends AbstractController
{
    #[Route('/auth/battlenet', name: 'auth_battlenet_start')]
    public function start(ClientRegistry $clientRegistry): Response
    {
        return $clientRegistry->getClient('battle_net')->redirect([], []);
    }

    #[Route('/auth/battlenet/check', name: 'auth_battlenet_check')]
    public function check(): never
    {
        throw new \LogicException('This route is intercepted by BattleNetAuthenticator and should never be reached.');
    }
}
