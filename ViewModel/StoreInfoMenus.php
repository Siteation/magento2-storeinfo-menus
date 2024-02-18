<?php declare(strict_types=1);

namespace Siteation\StoreInfoMenus\ViewModel;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Model\ScopeInterface;

class StoreInfoMenus implements ArgumentInterface
{
    protected $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function getStoreMenu(string $attribute): array
    {
        $path = sprintf('siteation_storeinfo_menus/%s/menu', $attribute);
        $value = $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE);
        return is_string($value) ? json_decode($value, true) : (array) $value;
    }

    public function getAboutMenu(): array
    {
        $menu = $this->getStoreMenu('about');
        return !empty($menu) ? $menu : [];
    }

    public function getServicesMenu(): array
    {
        $menu = $this->getStoreMenu('services');
        return !empty($menu) ? $menu : [];
    }

    public function getLegalMenu(): array
    {
        $menu = $this->getStoreMenu('legal');
        return !empty($menu) ? $menu : [];
    }

    public function getCustom1Menu(): array
    {
        $menu = $this->getStoreMenu('custom_1');
        return !empty($menu) ? $menu : [];
    }

    public function getCustom2Menu(): array
    {
        $menu = $this->getStoreMenu('custom_2');
        return !empty($menu) ? $menu : [];
    }
}
