<?php

declare(strict_types=1);

namespace JagdGesellschaft\Security;

use League\OAuth2\Client\OptionProvider\HttpBasicAuthOptionProvider;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

final class BattleNetProvider extends AbstractProvider
{
    private string $battleNetRegion;

    /**
     * @param array<string, mixed>  $options
     * @param array<string, object> $collaborators
     */
    public function __construct(array $options = [], array $collaborators = [])
    {
        $this->battleNetRegion = isset($options['region']) && \is_string($options['region']) ? $options['region'] : 'eu';
        unset($options['region']);
        if (!isset($collaborators['optionProvider'])) {
            $collaborators['optionProvider'] = new HttpBasicAuthOptionProvider();
        }
        parent::__construct($options, $collaborators);
    }

    public function getBaseAuthorizationUrl(): string
    {
        return "https://{$this->battleNetRegion}.battle.net/oauth/authorize";
    }

    /** @param array<mixed> $params */
    public function getBaseAccessTokenUrl(array $params): string
    {
        return "https://{$this->battleNetRegion}.battle.net/oauth/token";
    }

    public function getResourceOwnerDetailsUrl(AccessToken $token): string
    {
        return "https://{$this->battleNetRegion}.battle.net/oauth/userinfo";
    }

    /** @return array<string> */
    protected function getDefaultScopes(): array
    {
        return ['openid'];
    }

    protected function getScopeSeparator(): string
    {
        return ' ';
    }

    /** @param array<mixed>|string $data */
    protected function checkResponse(ResponseInterface $response, $data): void
    {
        if ($response->getStatusCode() >= 400) {
            if (\is_array($data)) {
                $raw = $data['error_description'] ?? $data['error'] ?? null;
                $message = \is_string($raw) ? $raw : $response->getReasonPhrase();
            } else {
                $message = $response->getReasonPhrase();
            }

            throw new IdentityProviderException($message, $response->getStatusCode(), $data);
        }
    }

    /** @param array<mixed> $response */
    protected function createResourceOwner(array $response, AccessToken $token): BattleNetResourceOwner
    {
        return new BattleNetResourceOwner($response);
    }
}
