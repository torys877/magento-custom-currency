<?php

/*
 * Copyright © Ihor Oleksiienko (https://github.com/torys877)
 * See LICENSE for license details.
 */

namespace Crypto\Currency\Model\ResourceModel;

use Crypto\Currency\Api\Data\CurrencyInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Currency extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'crypto_custom_currency_resource_model';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('crypto_custom_currency', CurrencyInterface::ENTITY_ID);
        $this->_useIsObjectNew = true;
    }
}
