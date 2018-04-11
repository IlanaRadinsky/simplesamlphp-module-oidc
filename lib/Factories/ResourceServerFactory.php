<?php

/*
 * This file is part of the simplesamlphp-module-oidc.
 *
 * (c) Sergio Gómez <sergio@uco.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SimpleSAML\Modules\OpenIDConnect\Factories;

use League\OAuth2\Server\CryptKey;
use League\OAuth2\Server\ResourceServer;
use SimpleSAML\Modules\OpenIDConnect\Repositories\AccessTokenRepository;
use SimpleSAML\Utils\Config;

class ResourceServerFactory
{
    /**
     * @var AccessTokenRepository
     */
    private $accessTokenRepository;

    public function __construct(AccessTokenRepository $accessTokenRepository)
    {
        $this->accessTokenRepository = $accessTokenRepository;
    }

    public function build()
    {
        $publicKeyPath = Config::getCertPath('oidc_module.crt');

        return new ResourceServer(
            $this->accessTokenRepository,
            new CryptKey($publicKeyPath)
        );
    }
}
