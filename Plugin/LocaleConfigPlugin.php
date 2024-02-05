<?php
/*
 * Copyright © Ihor Oleksiienko (https://github.com/torys877)
 * See LICENSE for license details.
 */

namespace Crypto\Currency\Plugin;

use Crypto\Currency\Model\Config;

class LocaleConfigPlugin
{
    protected Config $config;

    public function __construct(
        Config $config
    ) {
        $this->config = $config;
    }

    public function afterGetAllowedCurrencies(\Magento\Framework\Locale\Config $subject, $result)
    {
        $currencies = $this->config->getAllowedCurrencies();
        $result = array_merge($result, $currencies);
        return $result;
    }
}
