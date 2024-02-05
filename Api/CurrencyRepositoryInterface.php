<?php
/*
 * Copyright © Ihor Oleksiienko (https://github.com/torys877)
 * See LICENSE for license details.
 */
declare(strict_types=1);

namespace Crypto\Currency\Api;

use Crypto\Currency\Api\Data\CurrencyInterface;
use Crypto\Currency\Model\ResourceModel\Currency\Collection;
use Crypto\Currency\Model\ResourceModel\Currency\Collection as CurrencyCollection;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

interface CurrencyRepositoryInterface
{
    /**
     * @param int $currencyId
     * @return CurrencyInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $currencyId): CurrencyInterface;

    /**
     * @param string $currencyCode
     * @return CurrencyInterface
     * @throws NoSuchEntityException
     */
    public function getByCode(string $currencyCode): CurrencyInterface;

    /**
     *
     * @param CurrencyInterface $currency
     * @return CurrencyInterface
     * @throws CouldNotSaveException
     */
    public function save(CurrencyInterface $currency): CurrencyInterface;

    /**
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return Collection
     */
    public function getList(SearchCriteriaInterface $searchCriteria): Collection;

    /**
     * @return CurrencyCollection
     */
    public function getAllActiveCurrencies(): CurrencyCollection;
}
