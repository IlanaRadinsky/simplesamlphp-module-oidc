<?php

/*
 * This file is part of the simplesamlphp-module-oidc.
 *
 * (c) Sergio Gómez <sergio@uco.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SimpleSAML\Modules\OpenIDConnect\Repositories;

use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use SimpleSAML\Modules\OpenIDConnect\Entity\ScopeEntity;

class ScopeRepository extends AbstractDatabaseRepository implements ScopeRepositoryInterface
{
    /**
     * @codeCoverageIgnore
     */
    public function getTableName()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getScopeEntityByIdentifier($identifier)
    {
        $scopes = $this->config->getArray('scopes');

        if (false === array_key_exists($identifier, $scopes)) {
            return null;
        }

        $scope = $scopes[$identifier];
        $description = $scope['description'] ?? null;
        $icon = $scope['icon'] ?? null;
        $attributes = $scope['attributes'] ?? [];

        $scope = ScopeEntity::fromData(
            $identifier,
            $description,
            $icon,
            $attributes
        );

        return $scope;
    }

    /**
     * {@inheritdoc}
     */
    public function finalizeScopes(
        array $scopes,
        $grantType,
        ClientEntityInterface $clientEntity,
        $userIdentifier = null
    ) {
        return array_filter($scopes, function (ScopeEntityInterface $scope) use ($clientEntity) {
            return in_array($scope->getIdentifier(), $clientEntity->getScopes(), true);
        });
    }
}
