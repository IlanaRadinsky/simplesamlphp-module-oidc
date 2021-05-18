<?php

namespace SimpleSAML\Modules\OpenIDConnect\Server\RequestTypes;

use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\RequestTypes\AuthorizationRequest as OAuth2AuthorizationRequest;
use SimpleSAML\Modules\OpenIDConnect\Server\Exceptions\OidcServerException;
use SimpleSAML\Modules\OpenIDConnect\Utils\Arr;

class AuthorizationRequest extends OAuth2AuthorizationRequest
{
    /**
     * @var string|null
     */
    protected $nonce;

    /**
     * @return string|null
     */
    public function getNonce(): ?string
    {
        return $this->nonce;
    }

    /**
     * @param string $nonce
     */
    public function setNonce(string $nonce): void
    {
        $this->nonce = $nonce;
    }
}