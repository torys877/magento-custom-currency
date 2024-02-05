<?php
/*
 * Copyright © Ihor Oleksiienko (https://github.com/torys877)
 * See LICENSE for license details.
 */

namespace Crypto\Currency\Plugin;

use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\Locale\FormatInterface as LocaleFormat;

class CheckoutDefaultConfigProviderPlugin
{
    private CheckoutSession $checkoutSession;
    private LocaleFormat $localeFormat;

    public function __construct(
        CheckoutSession $checkoutSession,
        LocaleFormat $localeFormat
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->localeFormat = $localeFormat;
    }

    public function afterGetConfig(\Magento\Checkout\Model\ConfigProviderInterface $subject, $output)
    {
        \Crypto\Currency\Model\Config::enableHtml();

        $output['priceFormatHtml'] = $this->localeFormat->getPriceFormat(
            null,
            $this->checkoutSession->getQuote()->getQuoteCurrencyCode()
        );
        $output['basePriceFormatHtml'] = $this->localeFormat->getPriceFormat(
            null,
            $this->checkoutSession->getQuote()->getBaseCurrencyCode()
        );

        \Crypto\Currency\Model\Config::disableHtml();
        return $output;
    }
}
