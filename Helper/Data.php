<?php

namespace Rollbar\Magento2\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{

    /**
     * @var EncryptorInterface
     */
    private $encryptor;

    public function __construct(
        Context $context,
        EncryptorInterface $encryptor
    )
    {
        parent::__construct($context);
        $this->encryptor = $encryptor;
    }

    const CONFIG_PREFIX = 'rollbar/configuration/';


    public function getEnabled(): bool
    {
        return $this->isSetFlag('enabled');
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        $accessToken = $this->getConfigValue('access_token');
        return $this->encryptor->decrypt($accessToken);
    }

    /**
     * @return string
     */
    public function getEnvironment(): string
    {
        return $this->getConfigValue('environment');
    }

    /**
     * @param string $flag
     * @return bool
     */
    private function isSetFlag(string $flag) {
        return $this->scopeConfig->isSetFlag(self::CONFIG_PREFIX . $flag, ScopeInterface::SCOPE_WEBSITE);
    }

    /**
     * @param string $value
     * @return mixed
     */
    private function getConfigValue(string $value) {
        return $this->scopeConfig->getValue(self::CONFIG_PREFIX . $value, ScopeInterface::SCOPE_WEBSITE);
    }
}
