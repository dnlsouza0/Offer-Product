<?php

namespace Oderco\DayOffer\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;
use Laminas\Log\Logger;
use Laminas\Log\Writer\Stream;


class Config extends AbstractHelper
{
    const BASE = 'dayoffer';
    const GENERAL_GROUP = '/general';
    const MODULE_ENABLED = self::BASE . self::GENERAL_GROUP . '/active';
    const DURATION_TIME = self::BASE . self::GENERAL_GROUP . '/duration_time';
    const BUTTON_TEXT = self::BASE . self::GENERAL_GROUP . '/button_text';
    const PRODUCT = self::BASE . self::GENERAL_GROUP . '/product_list';
    const DATE_INIT = self::BASE . self::GENERAL_GROUP . '/date_init';
    const CUSTOM_CSS = self::BASE . self::GENERAL_GROUP . '/custom_css';

    protected $scopeConfig;

    protected $logger;

    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    public function getConfigValue($field, $storeId = null){
        try {
            return $this->scopeConfig->getValue($field, ScopeInterface::SCOPE_STORE, $storeId);
        }
        catch(\Exception $e){
            $this->createLog($e->getMessage());
            throw $e;
        }
    }

    public function isModuleEnabled($storeId = null){
        try {

            return filter_var(
                $externalServiceKey = $this->scopeConfig->getValue(
                    self::MODULE_ENABLED,
                    ScopeInterface::SCOPE_STORE,
                    $storeId
                ),
                FILTER_VALIDATE_BOOLEAN
            );

        } catch (\Exception $e) {
            $this->createLog($e->getMessage);
            throw $e;
        }
    }

    public function verifyIfConfigIsOk()
    {
        if (
            $this->getConfigValue(self::DURATION_TIME) !== "" &&
            $this->getConfigValue(self::DURATION_TIME) !== null &&
            $this->getConfigValue(self::BUTTON_TEXT) !== "" &&
            $this->getConfigValue(self::BUTTON_TEXT) !== null &&
            $this->getConfigValue(self::PRODUCT) !== "" &&
            $this->getConfigValue(self::PRODUCT) !== null
        )
            return true;

        else
            throw new LocalizedException(__("Important configuration data empty"));
    }

    public static function createLog($data, $logName = false){
        if ($logName){
            $logName = 'oderco_log';
        }
        $writer = new Stream(BP . '/var/log/' . $logName . '.log');
        $logger = new Logger();
        $logger->addWriter($writer);
        $logger->info(json_encode($data, JSON_PRETTY_PRINT));
    }
}
