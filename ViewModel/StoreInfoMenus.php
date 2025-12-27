<?php declare(strict_types=1);

/**
 * @author Siteation (https://siteation.dev/)
 * @copyright Copyright 2023 Siteation (https://siteation.dev/)
 * @license MIT
 */

namespace Siteation\StoreInfoMenus\ViewModel;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Model\ScopeInterface;

class StoreInfoMenus implements ArgumentInterface
{
    /** @var UrlInterface */
    protected $urlBuilder;

    public function __construct(
        private ScopeConfigInterface $scopeConfig,
        private Context $context
    ) {
        $this->urlBuilder = $context->getUrlBuilder();
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

    public function getUrl($route = '', $params = []) {
        // Fixes case when using `tel:` as the url
        if (str_starts_with($route, 'tel:')) {
            return $route;
        }
        return $this->urlBuilder->getUrl($route, $params);
    }
}
