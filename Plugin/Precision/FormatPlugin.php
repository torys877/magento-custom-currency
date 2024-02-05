<?php
/**
 * Copyright © Ihor Oleksiienko (https://github.com/torys877)
 * See LICENSE for license details.
 */
declare(strict_types=1);

namespace Crypto\Currency\Plugin\Precision;

use Magento\Framework\Locale\Format;

class FormatPlugin extends BasePlugin
{
    public function afterGetPriceFormat(Format $subject, array $result): array
    {
        if (!$this->isCurrencyPrecision()) {
            return $result;
        }

        $result['precision'] = $this->getCurrencyPrecision();
        $result['requiredPrecision'] = $this->getCurrencyPrecision();

        return $result;
    }
}
