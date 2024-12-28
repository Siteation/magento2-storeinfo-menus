# Siteation Magento2 Storeinfo Menus

[![Packagist Version](https://img.shields.io/packagist/v/siteation/magento2-storeinfo-menus?style=for-the-badge)](https://packagist.org/packages/siteation/magento2-storeinfo-menus)
![Supported Magento Versions](https://img.shields.io/badge/magento-%202.3_|_2.4-brightgreen.svg?logo=magento&longCache=true&style=for-the-badge)
[![Hyvä Themes Supported](https://img.shields.io/badge/Hyva_Themes-Supported-3df0af.svg?longCache=true&style=for-the-badge)](https://hyva.io/)
![License](https://img.shields.io/github/license/Siteation/magento2-storeinfo-menus?color=%23234&style=for-the-badge)

This module lets you add static links to your Magento 2 footer. It includes pre-populated "About Us," "Services," and "Legal" menus, along with two customizable options.

## Installation

Install the package via;

```bash
composer require siteation/magento2-storeinfo-menus
bin/magento setup:upgrade
```

> This Module require Magento 2.4 or higher!
> For more requirements see the `composer.json`.

## How to use

Go to `Stores > Configration > Siteation > Store Menus` and add you menu items

| Admin        | Storefront   |
| ------------ | ------------ |
| ![preview-1] | ![preview-2] |

Starting with Version 1.1 of Storeinfo Menus,
you can now rearrange menu items by dragging and dropping the fields to change their order.

![preview-3]

[preview-1]: ./assets/preview-admin.webp "Preview of the Magento2 admin Siteation StoreInfo Menus"
[preview-2]: ./assets/preview.webp "Preview of the Siteation StoreInfo Menus"
[preview-3]: ./assets/preview-dragable.gif "Preview of drag functionality"
