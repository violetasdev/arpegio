<?php

    $spBaseUrl = 'http://localhost/arpegio/plugin/onelogin'; //or http://<your_domain>

    $settingsInfo = array (
        'sp' => array (
            'entityId' => $spBaseUrl.'/demo1/metadata.php',
            'assertionConsumerService' => array (
                'url' => $spBaseUrl.'/demo1/index.php?acs',
            ),
            'singleLogoutService' => array (
                'url' => $spBaseUrl.'/demo1/index.php?sls',
            ),
            'NameIDFormat' => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
        ),
        'idp' => array (
            'entityId' => 'https://app.onelogin.com/saml/metadata/25d4787d-831b-4326-986f-bca608ff2894',
            'singleSignOnService' => array (
                'url' => 'https://lanix.onelogin.com/trust/saml2/http-post/sso/807433',
            ),
            'singleLogoutService' => array (
                'url' => 'https://lanix.onelogin.com/trust/saml2/http-redirect/slo/807433',
            ),
            'x509cert' => 'MIIEaDCCA1CgAwIBAgIUOMsjaVCct0mmRaVGXjGECKsNnNgwDQYJKoZIhvcNAQEF
BQAwczELMAkGA1UEBhMCQ08xCzAJBgNVBAgMAkRDMQ8wDQYDVQQHDAZCb2dvdGEx
DjAMBgNVBAoMBUxhbml4MRUwEwYDVQQLDAxPbmVMb2dpbiBJZFAxHzAdBgNVBAMM
Fk9uZUxvZ2luIEFjY291bnQgNzgyMDQwHhcNMTcwNjAxMTM0MDAxWhcNMjIwNjAy
MTM0MDAxWjBzMQswCQYDVQQGEwJDTzELMAkGA1UECAwCREMxDzANBgNVBAcMBkJv
Z290YTEOMAwGA1UECgwFTGFuaXgxFTATBgNVBAsMDE9uZUxvZ2luIElkUDEfMB0G
A1UEAwwWT25lTG9naW4gQWNjb3VudCA3ODIwNDCCASIwDQYJKoZIhvcNAQEBBQAD
ggEPADCCAQoCggEBAOmdrx+9k6KKMHgfbV8+8HvqYejQ00mU6qYUlLkZ0qHwSgm4
G58RJVQql+ctMUGTf1wZnbmZ1Vc7M43DECAs3jXjSlQgOFY//pYOUQqgUvZxDCMd
/vL6jCFdDEsn0VEisiMyrJ/FkKrWA08nbACQ1ZvRWfdLtNMBANlvi+kKgvoW3eJg
SMd1aNYswoRym66Kr2hAEshYnrZ5Iu2X6YyWzQNObXsSqgnIwt/H5quZF1VuE5+c
lgysmHTDYZPrA+dweJ0pfnH04+C6fqmIzy+XY0yNC3NbsTaS/bA5QkIoAtmwwOFa
jArv/nV8fAy+30d4WRtNHvzRpNvx32zZ8o3UIAkCAwEAAaOB8zCB8DAMBgNVHRMB
Af8EAjAAMB0GA1UdDgQWBBRF8ggKWJSoC8sixWdhUmx1nUD3UjCBsAYDVR0jBIGo
MIGlgBRF8ggKWJSoC8sixWdhUmx1nUD3UqF3pHUwczELMAkGA1UEBhMCQ08xCzAJ
BgNVBAgMAkRDMQ8wDQYDVQQHDAZCb2dvdGExDjAMBgNVBAoMBUxhbml4MRUwEwYD
VQQLDAxPbmVMb2dpbiBJZFAxHzAdBgNVBAMMFk9uZUxvZ2luIEFjY291bnQgNzgy
MDSCFDjLI2lQnLdJpkWlRl4xhAirDZzYMA4GA1UdDwEB/wQEAwIHgDANBgkqhkiG
9w0BAQUFAAOCAQEAqg70KiBA1V6x3LHnsXnuojSHQ1+NwbZ9gWl6Dp+1bnDWXqG8
62zRyWaNa9waJGz0CKpV3IvgH3gAd8+2sA2qNIkuW1OmcKWWIpnUr1F3Sfw6stV+
NEyIgmjg73kkacLDbppgh+fbrtA1gUJfinvcxd6yKFuyPwWTQXhUlHksdfFlSOEV
BGIXEyparT5GCPN660oe2Udtl2pQcF/CUXzqPNA7N/wQ+SSdvfjSNmJGxBGb1AaW
AFgliMg+piJffDzml0u+GHJb8tTPIveSGjXJ7DWT6wrYcpmrenNBGzhOQf50yIFy
6RZFOWhfjfSBqvAq3hqxABYAOXTr2vpG5SB7rg==',
        ),
    );
