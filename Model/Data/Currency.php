<?php

/*
 * Copyright © Ihor Oleksiienko (https://github.com/torys877)
 * See LICENSE for license details.
 */

namespace Crypto\Currency\Model\Data;

use Crypto\Currency\Api\Data\CurrencyInterface;
use Crypto\Currency\Model\ResourceModel\Currency as CurrencyResource;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Currency extends AbstractModel implements CurrencyInterface, IdentityInterface
{
    /**
     * Currency page cache tag
     */
    const CACHE_TAG = 'crypto_custom_currency';

    /**
     * @var string
     */
    protected $_cacheTag = 'crypto_custom_currency';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'crypto_custom_currency';

    /**
     * @var string
     */
    protected $_idFieldName = self::ENTITY_ID;

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init(CurrencyResource::class);
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Save from collection data
     *
     * @param array $data
     * @return $this|bool
     */
    public function saveCollection(array $data)
    {
        if (isset($data[$this->getId()])) {
            $this->addData($data[$this->getId()]);
            $this->getResource()->save($this);
        }
        return $this;
    }

    public function getCode(): ?string
    {
        return $this->getData(self::CODE) === null ? null
            : (string)$this->getData(self::CODE);
    }

    public function setCode(string $code): CurrencyInterface
    {
        $this->setData(self::CODE, $code);

        return $this;
    }

    public function getSymbol(): ?string
    {
        return $this->getData(self::SYMBOL) === null ? null
            : (string)$this->getData(self::SYMBOL);
    }

    public function setSymbol(string $symbol): CurrencyInterface
    {
        $this->setData(self::SYMBOL, $symbol);

        return $this;
    }

    public function getPrecision(): ?int
    {
        return $this->getData(self::PRECISION) === null ? null
            : (string)$this->getData(self::PRECISION);
    }

    public function setPrecision(int $precision): CurrencyInterface
    {
        $this->setData(self::PRECISION, $precision);

        return $this;
    }

    public function getCreatedAt(): ?string
    {
        return $this->getData(self::CREATED_AT) === null ? null
            : (string)$this->getData(self::CREATED_AT);
    }

    public function setCreatedAt(string $createdAt): CurrencyInterface
    {
        $this->setData(self::CREATED_AT, $createdAt);

        return $this;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->getData(self::UPDATED_AT) === null ? null
            : (string)$this->getData(self::UPDATED_AT);
    }

    public function setUpdatedAt(string $updatedAt): CurrencyInterface
    {
        $this->setData(self::UPDATED_AT, $updatedAt);

        return $this;
    }

    public function getName(): ?string
    {
        return $this->getData(self::NAME) === null ? null
            : (string)$this->getData(self::NAME);
    }

    public function setName(string $name): CurrencyInterface
    {
        $this->setData(self::NAME, $name);

        return $this;
    }

    public function getFormatPrecision(): ?string
    {
        return $this->getData(self::FORMAT_PRECISION) === null ? null
            : (string)$this->getData(self::FORMAT_PRECISION);
    }

    public function setFormatPrecision(string $formatPrecision): CurrencyInterface
    {
        $this->setData(self::FORMAT_PRECISION, $formatPrecision);

        return $this;
    }

    public function getPlural(): ?string
    {
        return $this->getData(self::PLURAL) === null ? null
            : (string)$this->getData(self::PLURAL);
    }

    public function setPlural(string $plural): CurrencyInterface
    {
        $this->setData(self::PLURAL, $plural);

        return $this;
    }

    public function getFormat(): ?string
    {
        return $this->getData(self::FORMAT) === null ? null
            : (string)$this->getData(self::FORMAT);
    }

    public function setFormat(string $format): CurrencyInterface
    {
        $this->setData(self::FORMAT, $format);

        return $this;
    }

    public function getFormatHtml(): ?string
    {
        return $this->getData(self::FORMAT_HTML) === null ? null
            : (string)$this->getData(self::FORMAT_HTML);
    }

    public function setFormatHtml(string $formatHtml): CurrencyInterface
    {
        $this->setData(self::FORMAT_HTML, $formatHtml);

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->getData(self::STATUS) === null ? null
            : (string)$this->getData(self::STATUS);
    }

    public function setStatus(int $status): CurrencyInterface
    {
        $this->setData(self::STATUS, $status);

        return $this;
    }

    public function getSymbolHtml(): ?string
    {
        return $this->getData(self::SYMBOL_HTML) === null ? null
            : (string)$this->getData(self::SYMBOL_HTML);
    }

    public function setSymbolHtml(string $symbolHtml): CurrencyInterface
    {
        $this->setData(self::SYMBOL_HTML, $symbolHtml);

        return $this;
    }
}
