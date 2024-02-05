<?php
/*
 * Copyright © Ihor Oleksiienko (https://github.com/torys877)
 * See LICENSE for license details.
 */

namespace Crypto\Currency\Observer;

use Crypto\Currency\Model\Context;

class BlockAfter implements \Magento\Framework\Event\ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $block = $observer->getData('block');
        $class = get_class($block);
        $name = $block->getNameInLayout();

        $status = Context::pop();
        $current = Context::current();

        switch($current) {
            case false:
                \Crypto\Currency\Model\Config::disableHtml();
                break;
            case true:
                \Crypto\Currency\Model\Config::enableHtml();
                break;
        }

        return $this;
    }
}
