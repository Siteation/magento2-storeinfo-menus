<?php declare(strict_types=1);

/**
 * StoreInfo Menus module for Magento
 *
 * @author Siteation (https://siteation.dev/)
 * @copyright Copyright 2023 Siteation (https://siteation.dev/)
 * @license MIT
 */

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Siteation_StoreInfoMenus',
    __DIR__
);
