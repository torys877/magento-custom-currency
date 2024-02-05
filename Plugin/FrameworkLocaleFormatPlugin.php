<?php
/*
 * Copyright © Ihor Oleksiienko (https://github.com/torys877)
 * See LICENSE for license details.
 */

namespace Crypto\Currency\Plugin;

use Crypto\Currency\Model\Config;
use Magento\Framework\App\State;
use Magento\Framework\Locale\FormatInterface;

class FrameworkLocaleFormatPlugin
{
    protected Config $config;
    protected State $appState;

    public function __construct(
        Config $config,
        State $appState
    ) {
        $this->config = $config;
        $this->appState = $appState;
    }

    public function afterGetPriceFormat(FormatInterface $subject, $result)
    {
        $currency = $this->config->getCurrency();
        if (!$currency) {
            return $result;
        }

        $pattern = $this->config->getPattern();
        //$result['pattern'] = preg_replace('/%s(?![ $])/', '%s ', $result['pattern']);
        $result['pattern'] = str_replace('{{amount}}', '%s', $pattern);

        $currency = $this->config->getCurrency();

        if (isset($currency['format_precision'])) {
            $result['precision'] = $currency['format_precision'];
            $result['requiredPrecision'] = $currency['format_precision'];
        }
        return $result;
    }
}
