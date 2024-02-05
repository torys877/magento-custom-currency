<?php
/*
 * Copyright © Ihor Oleksiienko (https://github.com/torys877)
 * See LICENSE for license details.
 */

namespace Crypto\Currency\Observer;

use Crypto\Currency\Model\Config;
use Crypto\Currency\Model\Context;

class BlockBefore implements \Magento\Framework\Event\ObserverInterface
{
    private Config $config;

    public function __construct(
        Config $config
    ) {
        $this->config = $config;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $block = $observer->getData('block');
        $class = get_class($block);
        $name = $block->getNameInLayout();

        $status = Context::current();

        $htmlblocks = $this->config->getEnabledHTMLBlocks();
        foreach ($htmlblocks as $htmlblock) {
            if ($block instanceof $htmlblock) {
                $status = true;
                break;
            }
        }

        switch($status) {
            case true:
                \Crypto\Currency\Model\Config::enableHtml();
        }
        Context::push($status);

        return $this;
    }
}
