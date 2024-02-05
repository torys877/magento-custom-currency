<?php
/*
 * Copyright © Ihor Oleksiienko (https://github.com/torys877)
 * See LICENSE for license details.
 */

namespace Crypto\Currency\Model;

use Crypto\Currency\Model\ResourceModel\Currency\Collection;
use Crypto\Currency\Model\ResourceModel\Currency\CollectionFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\App\State;
use Magento\Framework\View\Asset\Repository;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

class Config
{
    public static $enabledHtml = false;
    public static $override = [];
    protected $cache = [];
    private ScopeConfigInterface $scopeConfig;
    private CollectionFactory $collectionFactory;
    private StoreManagerInterface $storeManager;
    private ResourceConnection $resourceConnection;
    private LoggerInterface $logger;
    private State $appState;
    private Repository $assetRepo;
    private array $currencies;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface                    $scopeConfig,
        \Crypto\Currency\Model\ResourceModel\Currency\CollectionFactory $collectionFactory,
        \Magento\Store\Model\StoreManagerInterface                            $storeManager,
        \Magento\Framework\App\ResourceConnection                             $resourceConnection,
        \Psr\Log\LoggerInterface                                              $logger,
        \Magento\Framework\App\State                                          $appState,
        \Magento\Framework\View\Asset\Repository                              $assetRepo,
        $currencies = []
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->collectionFactory = $collectionFactory;
        $this->storeManager = $storeManager;
        $this->resourceConnection = $resourceConnection;
        $this->logger = $logger;
        $this->appState = $appState;
        $this->assetRepo = $assetRepo;
        $this->currencies = $currencies;
    }

    public static function enableHtml()
    {
        self::$enabledHtml = true;
    }

    public static function disableHtml()
    {
        self::$enabledHtml = false;
    }

    public function getAllowedCurrencies()
    {
        if (isset($this->cache['allowed'])) {
            return $this->cache['allowed'];
        }

        //@TODO
        $connection = $this->resourceConnection->getConnection();
        $tableName = $this->resourceConnection->getTableName('crypto_custom_currency');

        if (!$connection->isTableExists($tableName)) {
            return [];
        }

        return $this->cache['allowed'] = $connection->fetchCol("SELECT code FROM $tableName");
    }

    public function getCurrency($code = null)
    {
        $currency = $this->_getCurrency($code);
        return $currency ? array_merge($currency, self::$override) : $currency;
    }

    public function _getCurrency($code = null)
    {
        $storeId = $this->storeManager->getStore()->getStoreId();
        if ($code === null) {
            $code = $this->storeManager->getStore()->getCurrentCurrency()->getCode();
        }
//        var_dump($code);die();
        $key = "currency:$code:$storeId";

        if (isset($this->cache[$key])) {
            return $this->cache[$key];
        }

        $currencies = $this->getCurrencies();
        if (isset($currencies[$code])) {
            return $this->cache[$key] = $currencies[$code];
        }

        return $this->cache[$key] = false;
    }

    public function getCurrencies()
    {
        $storeId = $this->storeManager->getStore()->getStoreId();
        $key = 'currencies:' . $storeId;

        if (isset($this->cache[$key])) {
            return $this->cache[$key];
        }

        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();

        $collection->addFieldToFilter('status', 1);
        $collection->addFieldToSelect('*');
        $collection->load();

        $currencies = [];

        foreach ($collection as $item) {
            $data = $item->getData();

            if (!isset($data['name'])) {
                $data['name'] = $data['code'];
            }

            $data['singular'] = $data['name'];

            $currency = $data;

            if (empty($currency['symbol'])) {
                $currency['symbol'] = $currency['code'];
            }

            if ('' === trim($currency['precision'] ?? '')) {
                $currency['precision'] = 2;
            }

            if ('' === trim($currency['format_precision'] ?? '')) {
                $currency['format_precision'] = $currency['precision'];
            }

            if (isset($currency['symbol_html']) && !empty($currency['symbol_html'])) {
                $symbolHtml = str_replace([
                    '{{symbol}}'
                ], [
                    $currency['symbol']
                ], $currency['symbol_html']);
            } else {
                $symbolHtml = $currency['symbol'];
            }

            $currency['symbol_html_final'] = $symbolHtml;

            if (isset($currency['format']) && !empty($currency['format'])) {
                $format = str_replace([
                    '{{symbol}}', '{{symbol_html}}',
                ], [
                    $currency['symbol'], $symbolHtml,
                ], $currency['format']);

                $currency['format_final'] = $format;
            } else {
                $currency['format_final'] = '';
            }

            if (isset($currency['format_html']) && !empty($currency['format_html'])) {
                $formatHtml = str_replace([
                    '{{symbol}}', '{{symbol_html}}',
                ], [
                    $currency['symbol'], $symbolHtml,
                ], $currency['format_html']);

                $currency['format_html_final'] = $formatHtml;
            } else {
                $currency['format_html_final'] = $currency['format_final'];
            }

            $currency['symbol_html_final'] = $this->parse($currency['symbol_html_final']);
            $currency['format_html_final'] = $this->parse($currency['format_html_final']);

            $currencies[$item->getCode()] = $currency;
        }

        return $this->cache[$key] = $currencies;
    }

    public function getEnabledHTMLBlocks()
    {
        $key = 'htmlblocks';

        if (isset($this->cache[$key])) {
            return $this->cache[$key];
        }

        $htmlblocks = $this->scopeConfig->getValue(
            'customcurrency/general/htmlblocks',
            \Magento\Store\Model\ScopeInterface::SCOPE_WEBSITE
        );

        $blocks = array_map(function ($item) {
            return trim($item);
        }, preg_split("/[\n\r ]+/", trim($htmlblocks)));

        return $blocks;
    }

    public function parse($string)
    {
        $parsed = $string;
        $matches = [];
        preg_match_all('/{{(.*?)}}/mi', $string, $matches);
        foreach ($matches[1] as $k => $match) {
            if (strpos($match, '::') === false) {
                continue;
            }
            $value = $this->assetRepo->getUrl($match);
            if ($value) {
                $parsed = str_replace($matches[0][$k], $value, $parsed);
            }
        }
        return $parsed;
    }

    public function getPatternHtml()
    {
        $currency = $this->getCurrency();
        return $currency['format_html_final'];
    }

    public function getPatternTxt()
    {
        $currency = $this->getCurrency();
        return $currency['format_final'];
    }

    public function getPattern()
    {
        if (self::$enabledHtml && $this->appState->getAreaCode() === \Magento\Framework\App\Area::AREA_FRONTEND) {
            return $this->getPatternHtml();
        } else {
            return $this->getPatternTxt();
        }
    }

    public static function beginOverride($settings)
    {
        self::$override = $settings;
    }

    public static function endOverride()
    {
        self::$override = [];
    }
}
