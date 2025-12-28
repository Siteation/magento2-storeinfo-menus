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

    public function getStoreMenuHeading(string $attribute): string
    {
        $path = sprintf('siteation_storeinfo_menus/%s/menu_heading', $attribute);
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE) ?: '';
    }

    public function getStoreMenu(string $attribute): array
    {
        $path = sprintf('siteation_storeinfo_menus/%s/menu', $attribute);
        $value = $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE);
        return is_string($value) ? json_decode($value, true) : (array) $value;
    }

    public function getMenuHeading($id): string
    {
        return $this->getStoreMenuHeading($id);
    }

    public function getMenu($id): array
    {
        $menu = $this->getStoreMenu($id);
        return !empty($menu) ? $menu : [];
    }

    public function getAboutMenu(): array
    {
        return $this->getMenu('about');
    }

    /**
     * @deprecated
     *
     * use the getMenu() instead
     */
    public function getServicesMenu(): array
    {
        return $this->getMenu('services');
    }

    /**
     * @deprecated
     *
     * use the getMenu() instead
     */
    public function getLegalMenu(): array
    {
        return $this->getMenu('legal');
    }

    /**
     * @deprecated
     *
     * use the getMenu() instead
     */
    public function getCustom1Menu(): array
    {
        return $this->getMenu('custom_1');
    }

    /**
     * @deprecated
     *
     * use the getMenu() instead
     */
    public function getCustom2Menu(): array
    {
        return $this->getMenu('custom_2');
    }

    public function getUrl($route = '', $params = []) {
        // Fixes case when using `tel:` as the url
        if (str_starts_with($route, 'tel:')) {
            return $route;
        }
        return $this->urlBuilder->getUrl($route, $params);
    }
}
