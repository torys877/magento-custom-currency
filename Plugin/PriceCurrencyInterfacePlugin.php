<?php
/*
 * Copyright © Ihor Oleksiienko (https://github.com/torys877)
 * See LICENSE for license details.
 */

namespace Crypto\Currency\Plugin;

use Crypto\Currency\Model\Config;
use Magento\Framework\Pricing\PriceCurrencyInterface;

class PriceCurrencyInterfacePlugin
{
    protected Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function beforeRoundPrice(
        PriceCurrencyInterface $subject,
        $price,
        $precision = 2
    ) {
        $currency = $this->config->getCurrency();

        if (!$currency) {
            return [$price, $precision];
        }

        $currency = array_merge([
            'precision' => $precision,
        ], $currency);

        return [$price, $currency['precision']];
    }

    public function aroundRound(
        \Magento\Framework\Pricing\PriceCurrencyInterface $subject,
        callable $proceed,
        $price
    ) {
        $currency = $this->config->getCurrency();

        if (!$currency) {
            return $proceed($price);
        }

        $currency = array_merge([
            'precision' => 2,
        ], $currency);

        return round($price, $currency['precision']);
    }
}
