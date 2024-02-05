<?php
/**
 * Copyright © Ihor Oleksiienko (https://github.com/torys877)
 * See LICENSE for license details.
 */
declare(strict_types=1);

namespace Crypto\Currency\Plugin\Precision;

use Magento\Framework\CurrencyInterface;

class FrameworkCurrencyInterfacePlugin extends BasePlugin
{
    /**
     * @param CurrencyInterface $subject
     * @param callable $proceed
     * @param int|float|null $value
     * @param array $options
     * @return mixed
     */
    public function aroundToCurrency(
        CurrencyInterface $subject,
        callable $proceed,
        $value = null,
        array $options = []
    ) {
        if (!$this->isCurrencyPrecision()) {
            return $proceed($value, $options);
        }

        $options['precision'] = $this->getCurrencyPrecision();
        return $proceed($value, $options);
    }
}
