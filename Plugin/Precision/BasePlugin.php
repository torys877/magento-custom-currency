<?php
/**
 * Copyright © Ihor Oleksiienko (https://github.com/torys877)
 * See LICENSE for license details.
 */
declare(strict_types=1);

namespace Crypto\Currency\Plugin\Precision;

use Crypto\Currency\Api\CurrencyRepositoryInterface;
use Crypto\Currency\Api\Data\CurrencyInterface;
use Crypto\Currency\Api\Data\CurrencyInterfaceFactory;
use Magento\Framework\Registry;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Store\Model\StoreManagerInterface;

class BasePlugin
{
    public const DEFAULT_CURRENCY_PRECISION = 2;
    private CurrencyRepositoryInterface $currencyRepository;
    private CurrencyInterfaceFactory $currencyFactory;
    private StoreManagerInterface $storeManager;
    private Registry $coreRegistry;

    public function __construct(
        CurrencyRepositoryInterface $currencyRepository,
        CurrencyInterfaceFactory $currencyFactory,
        StoreManagerInterface $storeManager,
        Registry $coreRegistry
    ) {
        $this->currencyRepository = $currencyRepository;
        $this->currencyFactory = $currencyFactory;
        $this->storeManager = $storeManager;
        $this->coreRegistry = $coreRegistry;
    }

    public function getCurrencyPrecision(?string $code = null): int
    {
        if ($this->getCurrency($code)->getPrecision()) {
            return (int) $this->getCurrency($code)->getPrecision();
        }

        return self::DEFAULT_CURRENCY_PRECISION;
    }

    public function isCurrencyPrecision(?string $code = null): bool
    {
        if ($this->getCurrency($code)->getPrecision()) {
            return true;
        }

        return false;
    }

    public function getCurrency(?string $code = null): CurrencyInterface
    {
        $currencyCode = $this->getCode($code);
        try {
            $currency = $this->currencyRepository->getByCode($currencyCode);
        } catch (\Exception $e) {
            $currency = $this->currencyFactory->create();
        }

        return $currency;
    }

    protected function getCode(?string $code = null): ?string
    {
        /** @var ?OrderInterface $order */
        $order = $this->coreRegistry->registry('sales_order') ??
            $this->coreRegistry->registry('current_order');

        if (!$code && $order && $order instanceof OrderInterface) {
            $code = $order->getOrderCurrencyCode();
        }

        if (!$code) {
            $code = $this->storeManager->getStore()->getCurrentCurrency()->getCode();
        }

        return $code;
    }
}
