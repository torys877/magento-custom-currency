<?php

/*
 * Copyright © Ihor Oleksiienko (https://github.com/torys877)
 * See LICENSE for license details.
 */

namespace Crypto\Currency\Model\ResourceModel\Currency;

use Crypto\Currency\Model\Data\Currency as Model;
use Crypto\Currency\Model\ResourceModel\Currency as ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'crypto_custom_currency_collection';

    /**
     * Initialize collection model.
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }

    protected function _toOptionArray($valueField = Model::ENTITY_ID, $labelField = Model::CODE, $additional = [])
    {
        return parent::_toOptionArray($valueField, $labelField, $additional);
    }
}
