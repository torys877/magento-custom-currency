<?php
/*
 * Copyright © Ihor Oleksiienko (https://github.com/torys877)
 * See LICENSE for license details.
 */

namespace Crypto\Currency\Plugin;

use Crypto\Currency\Model\Config;
use Laminas\I18n\View\Helper\CurrencyFormat;

use Magento\Framework\Locale\Resolver;
use Magento\Framework\Pricing\PriceCurrencyInterface;

class FrameworkPricingRenderAmountPlugin
{
    protected Config $config;
    protected Resolver $localeResolver;

    protected CurrencyFormat $currencyFormat;

    public function __construct(
        Resolver $localeResolver,
        Config $config,
        CurrencyFormat $currencyFormat
    ) {
        $this->localeResolver = $localeResolver;
        $this->config = $config;
        $this->currencyFormat = $currencyFormat;
    }

    public function aroundFormatCurrency(\Magento\Framework\Pricing\Render\AmountRenderInterface $subject, callable $proceed, $amount, $includeContainer = true, $precision = PriceCurrencyInterface::DEFAULT_PRECISION)
    {
        $currency = $this->config->getCurrency();

        if (!$currency) {
            return $proceed($amount, $includeContainer, $precision);
        }

        $locale = $this->localeResolver->getLocale();
        $formatOptions = [
            'locale' => $locale,
            'number_format' => '#,##0.00',
        ];

        if (isset($currency['format_precision'])) {
            $formatOptions['precision'] = $currency['format_precision'];
        }

        $amountStr = ($this->currencyFormat)(
            $amount,
            $currency['crypto_code'] ?? $currency['code'],
            true,
            $locale,
            '#,##0.00'
        );

        $pattern = $this->config->getPatternHtml();

        $result = str_replace('{{amount}}', $amountStr, $pattern);

        if ($includeContainer) {
            return '<span class="price">' . $result . '</span>';
        }

        return $result;
    }
}
