<?php
/*
 * Copyright © Ihor Oleksiienko (https://github.com/torys877)
 * See LICENSE for license details.
 */

namespace Crypto\Currency\Plugin;

class CheckoutBlockCartGridPlugin
{
    public function aroundToHtml(\Magento\Checkout\Block\Cart\Grid $subject, callable $proceed, ...$args)
    {
        \Crypto\Currency\Model\Config::enableHtml();
        $result = $proceed(...$args);
        \Crypto\Currency\Model\Config::disableHtml();
        return $result;
    }
}
