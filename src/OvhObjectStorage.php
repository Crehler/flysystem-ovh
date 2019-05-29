<?php

namespace Engineor\Flysystem;

use OpenCloud\OpenStack;
use OpenCloud\Common\Exceptions\CredentialError;

class OvhObjectStorage extends OpenStack
{
    const IDENTITY_ENDPOINT = 'https://auth.cloud.ovh.net/v2.0/';

    /**
     * Constant containing name of the region for European datacenter (currently located in Strasbourg, France)
     *
     * @const REGION_EUROPE
     */
    const REGION_EUROPE = 'SBG-1';

    /**
     * Constant containing name of the region for American datacenter (currently located in Beauharnois, Canada)
     *
     * @const REGION_US
     */
    const REGION_US = 'BHS-1';

    /**
     * @param array $secret
     * @param array $options
     */
    public function __construct(array $secret, array $options = [])
    {
        if (!isset($secret['region']) || !$secret['region']) {
            $secret['region'] = self::REGION_EUROPE;
        }

        if (!isset($secret['identity_endpoint']) || !$secret['identity_endpoint']) {
            $secret['identity_endpoint'] = self::IDENTITY_ENDPOINT;
        }

        $identityEndpoint = $secret['identity_endpoint'];
        unset($secret['identity_endpoint']);

        parent::__construct($identityEndpoint, $secret, $options);
    }

    /**
     * Check whether required secret keys are set and return Runabove API credentials
     * {@inheritDoc}
     */
    public function getCredentials()
    {
        $secret = $this->getSecret();

        if (!isset($secret['username']) || !isset($secret['password'])) {
            throw new CredentialError('Unrecognized credential secret');
        }

        return parent::getCredentials();
    }

    /**
     *
     * @return \OpenCloud\ObjectStore\Resource\Container
     */
    public function getContainer()
    {
        $store = $this->objectStoreService('swift', $this->getSecret()['region']);
        return $store->getContainer($this->getSecret()['container']);
    }
}
