<?php

namespace spec\SimpleSAML\Module\oidc\Services;

use PhpSpec\ObjectBehavior;
use SimpleSAML\Module\oidc\Services\ConfigurationService;
use SimpleSAML\Module\oidc\Services\OidcOpenIdProviderMetadataService;

class OidcOpenIdProviderMetadataServiceSpec extends ObjectBehavior
{
    public function let(
        ConfigurationService $configurationService
    ): void {
        $configurationService->getOpenIDScopes()->shouldBeCalled()
            ->willReturn(['openid' => 'openid']);

        $configurationService->getSimpleSAMLSelfURLHost()->shouldBeCalled()
            ->willReturn('http://localhost');
        $configurationService->getOpenIdConnectModuleURL('authorize.php')
            ->willReturn('http://localhost/authorize.php');
        $configurationService->getOpenIdConnectModuleURL('token.php')
            ->willReturn('http://localhost/token.php');
        $configurationService->getOpenIdConnectModuleURL('userinfo.php')
            ->willReturn('http://localhost/userinfo.php');
        $configurationService->getOpenIdConnectModuleURL('jwks.php')
            ->willReturn('http://localhost/jwks.php');
        $configurationService->getOpenIdConnectModuleURL('logout.php')
            ->willReturn('http://localhost/logout.php');

        $configurationService->getAcrValuesSupported()->willReturn([]);

        $this->beConstructedWith($configurationService);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(OidcOpenIdProviderMetadataService::class);
    }

    public function it_returns_expected_metadata(): void
    {
        $this->getMetadata()->shouldBe([
            'issuer' => 'http://localhost',
            'authorization_endpoint' => 'http://localhost/authorize.php',
            'token_endpoint' => 'http://localhost/token.php',
            'userinfo_endpoint' => 'http://localhost/userinfo.php',
            'end_session_endpoint' => 'http://localhost/logout.php',
            'jwks_uri' => 'http://localhost/jwks.php',
            'scopes_supported' => ['openid'],
            'response_types_supported' => ['code', 'token', 'id_token', 'id_token token'],
            'subject_types_supported' => ['public'],
            'id_token_signing_alg_values_supported' => ['RS256'],
            'code_challenge_methods_supported' => ['plain', 'S256'],
            'token_endpoint_auth_methods_supported' => ['client_secret_post', 'client_secret_basic'],
            'request_parameter_supported' => false,
            'grant_types_supported' => ['authorization_code', 'refresh_token'],
            'claims_parameter_supported' => true,
            'backchannel_logout_supported' => true,
            'backchannel_logout_session_supported' => true,
        ]);
    }
}
