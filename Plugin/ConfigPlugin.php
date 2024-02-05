<?php
/*
 * Copyright © Ihor Oleksiienko (https://github.com/torys877)
 * See LICENSE for license details.
 */

namespace Crypto\Currency\Plugin;

class ConfigPlugin
{
    private $config;

    public function __construct(\Crypto\Currency\Model\Config $config)
    {
        $this->config = $config;
    }

    public function afterGetValue(
        \Magento\Framework\App\Config\ScopeConfigInterface $subject,
        $result,
        $path = null,
        $scope = \Magento\Framework\App\Config\ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
        $scopeCode = null
    ) {
        if ($path === 'system/currency/installed') {
            return $result . ',' . implode(',', $this->config->getAllowedCurrencies());
        }
        return $result;
    }
}
