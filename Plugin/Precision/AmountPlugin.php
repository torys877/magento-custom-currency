<?php
/**
 * Copyright © Ihor Oleksiienko (https://github.com/torys877)
 * See LICENSE for license details.
 */
declare(strict_types=1);

namespace Crypto\Currency\Plugin\Precision;

use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\Pricing\Render\AmountRenderInterface;

class AmountPlugin extends BasePlugin
{
    public function aroundFormatCurrency(
        AmountRenderInterface $subject,
        callable $proceed,
        float $amount,
        bool $includeContainer = true,
        int $precision = PriceCurrencyInterface::DEFAULT_PRECISION
    ) {
        if (!$this->isCurrencyPrecision()) {
            return $proceed($amount, $includeContainer, $precision);
        }

        return $proceed($amount, $includeContainer, $this->getCurrencyPrecision());
    }
}
