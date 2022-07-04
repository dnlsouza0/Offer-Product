<?php

namespace Oderco\DayOffer\Block\Html\Header;

use Magento\Framework\View\Element\Template;
use Oderco\DayOffer\Helper\Config;
use Magento\Catalog\Model\Product;
use Magento\Framework\Pricing\PriceCurrencyInterface;

class Offer extends Template
{

    protected $configHelper;
    protected $product;
    protected $priceCurrency;

    public function __construct(
        Template\Context $context,
        Config $config,
        Product $product,
        PriceCurrencyInterface $priceCurrency,
        array $data = []
    )
    {
        $this->configHelper = $config;
        $this->product = $product;
        $this->priceCurrency = $priceCurrency;
        parent::__construct($context, $data);
    }

    public function moduleIsEnable(){
        return $this->configHelper->isModuleEnabled();
    }

    public function getBtnText(){
        return $this->configHelper->getConfigValue($this->configHelper::BUTTON_TEXT);
    }

    public function getDurationTime(){
        return $this->configHelper->getConfigValue($this->configHelper::DURATION_TIME);
    }

    public function getProduct(){
        $productId = $this->configHelper->getConfigValue($this->configHelper::PRODUCT);
        return $this->product->load($productId);

    }

    public function initOffer(){
        $dateInit = $this->configHelper->getConfigValue($this->configHelper::DATE_INIT);
        $currentData = date("Y-m-d H:i:s");

        if (strtotime($dateInit) <= strtotime($currentData)){
            if (!$this->expirationTime()){
                return true;
            }
        }
        return false;
    }

    public function expirationTime(){
        date_default_timezone_set('America/Sao_Paulo');
        $time = $this->configHelper->getConfigValue($this->configHelper::DURATION_TIME);
        $dateInit = $this->configHelper->getConfigValue($this->configHelper::DATE_INIT);
        $currentData = date("Y-m-d H:i:s");

        $timeduration = $time + strtotime($dateInit);

        if ($timeduration < strtotime($currentData)){
            return true;
        }
        return false;
    }

    public function getCurrencySymbol($storeId = null)
    {
        return $this->priceCurrency->getCurrencySymbol($storeId);
    }

    public function getCustomCss(){
        return $this->configHelper->getConfigValue($this->configHelper::CUSTOM_CSS);
    }
}
