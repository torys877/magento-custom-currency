<?php
/**
 * Copyright © Ihor Oleksiienko (https://github.com/torys877)
 * See LICENSE for license details.
 */
declare(strict_types=1);

namespace Crypto\Currency\Model;

use Crypto\Currency\Api\CurrencyRepositoryInterface;
use Crypto\Currency\Api\Data\CurrencyInterface;
use Crypto\Currency\Model\Data\Currency as CurrencyEntity;
use Crypto\Currency\Model\Data\CurrencyFactory;
use Crypto\Currency\Model\ResourceModel\Currency as Resource;
use Crypto\Currency\Model\ResourceModel\Currency\Collection;
use Crypto\Currency\Model\ResourceModel\Currency\Collection as CurrencyCollection;
use Crypto\Currency\Model\ResourceModel\Currency\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class CurrencyRepository implements CurrencyRepositoryInterface
{
    protected Resource $resource;
    protected CollectionProcessorInterface $collectionProcessor;
    protected CollectionFactory $collectionFactory;
    protected CurrencyFactory $currencyFactory;
    protected SearchCriteriaBuilder $searchCriteriaBuilder;

    public function __construct(
        Resource $resource,
        CollectionProcessorInterface $collectionProcessor,
        CollectionFactory $collectionFactory,
        CurrencyFactory $currencyFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->resource = $resource;
        $this->collectionProcessor = $collectionProcessor;
        $this->collectionFactory = $collectionFactory;
        $this->currencyFactory = $currencyFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    public function getById(int $currencyId): CurrencyInterface
    {
        /** @var CurrencyEntity $currency */
        $currency = $this->currencyFactory->create();
        $this->resource->load($currency, $currencyId);

        if (!$currency->getEntityId()) {
            throw new NoSuchEntityException(__('The currency with the "%1" ID doesn\'t exist.', $currencyId));
        }

        return $currency;
    }

    public function getByCode(string $currencyCode): CurrencyInterface
    {
        /** @var CurrencyEntity $currency */
        $currency = $this->currencyFactory->create();
        $this->resource->load($currency, $currencyCode, CurrencyInterface::CODE);

        if (!$currency->getEntityId()) {
            throw new NoSuchEntityException(__('The currency with the "%1" code doesn\'t exist.', $currencyCode));
        }

        return $currency;
    }

    public function getAll(): Collection
    {
        return $this->collectionFactory->create();
    }

    public function save(CurrencyInterface $currency): CurrencyInterface
    {
        try {
            $this->resource->save($currency);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }

        return $currency;
    }

    public function getList(SearchCriteriaInterface $searchCriteria): Collection
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        return $collection;
    }

    /**
     * @return CurrencyCollection
     */
    public function getAllActiveCurrencies(): CurrencyCollection
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(CurrencyInterface::STATUS, CurrencyInterface::STATUS_ENABLE)
            ->create();

        return $this->getList($searchCriteria);
    }
}
