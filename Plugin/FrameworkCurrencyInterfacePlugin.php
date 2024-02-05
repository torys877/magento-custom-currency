<?php
/*
 * Copyright © Ihor Oleksiienko (https://github.com/torys877)
 * See LICENSE for license details.
 */

namespace Crypto\Currency\Plugin;

use Crypto\Currency\Model\Config;

use Laminas\I18n\View\Helper\CurrencyFormat;
use Magento\Framework\App\State;
use Magento\Framework\Locale\Resolver;
use Magento\Store\Model\StoreManagerInterface;

class FrameworkCurrencyInterfacePlugin
{
    protected Config $config;
    protected State $appState;
    protected StoreManagerInterface $storeManager;
    protected Resolver $localeResolver;
    protected CurrencyFormat $currencyFormat;

    public function __construct(
        \Crypto\Currency\Model\Config $config,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\State $appState,
        \Magento\Framework\Locale\Resolver $localeResolver,
        CurrencyFormat $currencyFormat
    ) {
        $this->config = $config;
        $this->storeManager = $storeManager;
        $this->appState = $appState;
        $this->localeResolver = $localeResolver;
        $this->currencyFormat = $currencyFormat;
    }

    public function aroundToCurrency(\Magento\Framework\CurrencyInterface $subject, callable $proceed, ...$args)
    {
        $args = $args + [null, []];
        list($value, $options) = $args;

        $currency = $this->config->getCurrency();

        if (!$currency || isset($options['display']) && $options['display']) {
            return $proceed(...$args);
        }

        $locale = $this->localeResolver->getLocale();
        $formatOptions = [
            'locale' => $locale,
            'number_format' => '#,##0.00',
        ];

        if (isset($currency['format_precision'])) {
            $formatOptions['precision'] = $currency['format_precision'];
        }

        $valueStr = ($this->currencyFormat)(
            $value,
            $currency['crypto_code'] ?? $currency['code'],
            true,
            $locale,
            '#,##0.00'
        );

        $pattern = $this->config->getPattern();

        return str_replace('{{amount}}', $valueStr, $pattern);
    }
}
