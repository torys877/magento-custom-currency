<?php
/*
 * Copyright © Ihor Oleksiienko (https://github.com/torys877)
 * See LICENSE for license details.
 */

namespace Crypto\Currency\Plugin;

use Crypto\Currency\Model\Config;
use Magento\Framework\Locale\FormatInterface;

class CatalogProductViewPlugin
{
    private Config $config;
    private FormatInterface $_localeFormat;

    public function __construct(
        Config $config,
        FormatInterface $localeFormat
    ) {
        $this->config = $config;
        $this->_localeFormat = $localeFormat;
    }

    public function afterGetJsonConfig(
        \Magento\Catalog\Block\Product\View $subject,
        $result
    ) {
        $array = json_decode($result, true);
        $format = $this->_localeFormat->getPriceFormat();

        $currency = $this->config->getCurrency();

        if ($currency) {
            $pattern = $this->config->getPatternHtml();
            $format['pattern'] = str_replace('{{amount}}', '%s', $pattern);
            if (isset($currency['precision'])) {
                $format['precision'] = $currency['precision'];
                $format['requiredPrecision'] = $currency['precision'];
            }
        }

        $array['priceFormatHTML'] = $format;
        return json_encode($array);
    }
}
