<?php

declare(strict_types=1);

namespace Siteation\StoreInfoMenus\Test\Unit\ViewModel;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Context;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use Siteation\StoreInfoMenus\ViewModel\StoreInfoMenus;

class StoreInfoMenusTest extends TestCase
{
    private ScopeConfigInterface&Stub $scopeConfig;
    private Context&Stub $context;
    private StoreInfoMenus $viewModel;

    protected function setUp(): void
    {
        $this->scopeConfig = $this->createStub(ScopeConfigInterface::class);
        $this->context = $this->createStub(Context::class);
        $this->context->method('getUrlBuilder')->willReturn($this->createStub(UrlInterface::class));
        $this->viewModel = $this->viewModelFor($this->scopeConfig);
    }

    private function viewModelWith(UrlInterface $urlBuilder): StoreInfoMenus
    {
        $context = $this->createStub(Context::class);
        $context->method('getUrlBuilder')->willReturn($urlBuilder);

        return new StoreInfoMenus($this->scopeConfig, $context);
    }

    private function viewModelFor(ScopeConfigInterface $config): StoreInfoMenus
    {
        return new StoreInfoMenus($config, $this->context);
    }

    public function testMenuIsDecodedFromJsonConfig(): void
    {
        $config = $this->createMock(ScopeConfigInterface::class);
        $config->expects($this->once())
            ->method('getValue')
            ->with('siteation_storeinfo_menus/about/menu')
            ->willReturn('[{"url":"about","text":"About"}]');

        $this->assertSame([['url' => 'about', 'text' => 'About']], $this->viewModelFor($config)->getMenu('about'));
    }

    public function testMenuFromArrayConfigIsReturnedAsIs(): void
    {
        $this->scopeConfig->method('getValue')->willReturn([['url' => 'a', 'text' => 'A']]);

        $this->assertSame([['url' => 'a', 'text' => 'A']], $this->viewModel->getStoreMenu('legal'));
    }

    public function testMissingMenuIsAnEmptyArray(): void
    {
        $this->scopeConfig->method('getValue')->willReturn(null);

        $this->assertSame([], $this->viewModel->getMenu('services'));
    }

    public function testHeadingDefaultsToEmptyString(): void
    {
        $this->scopeConfig->method('getValue')->willReturn(null);

        $this->assertSame('', $this->viewModel->getMenuHeading('about'));
    }

    public function testHeadingReadsTheMenuHeadingPath(): void
    {
        $config = $this->createMock(ScopeConfigInterface::class);
        $config->expects($this->once())
            ->method('getValue')
            ->with('siteation_storeinfo_menus/custom_1/menu_heading')
            ->willReturn('Help');

        $this->assertSame('Help', $this->viewModelFor($config)->getStoreMenuHeading('custom_1'));
    }

    public function testDeprecatedAccessorsDelegateToTheirMenu(): void
    {
        $paths = [];
        $this->scopeConfig->method('getValue')->willReturnCallback(
            function (string $path) use (&$paths) {
                $paths[] = $path;
                return null;
            }
        );

        $this->viewModel->getAboutMenu();
        $this->viewModel->getServicesMenu();
        $this->viewModel->getLegalMenu();
        $this->viewModel->getCustom1Menu();
        $this->viewModel->getCustom2Menu();

        $this->assertSame([
            'siteation_storeinfo_menus/about/menu',
            'siteation_storeinfo_menus/services/menu',
            'siteation_storeinfo_menus/legal/menu',
            'siteation_storeinfo_menus/custom_1/menu',
            'siteation_storeinfo_menus/custom_2/menu',
        ], $paths);
    }

    public function testTelAndAnchorLinksBypassTheUrlBuilder(): void
    {
        $urlBuilder = $this->createMock(UrlInterface::class);
        $urlBuilder->expects($this->never())->method('getUrl');
        $viewModel = $this->viewModelWith($urlBuilder);

        $this->assertSame('tel:+31201234567', $viewModel->getUrl('tel:+31201234567'));
        $this->assertSame('#top', $viewModel->getUrl('#top'));
    }

    public function testRoutesGoThroughTheUrlBuilder(): void
    {
        $urlBuilder = $this->createMock(UrlInterface::class);
        $urlBuilder->expects($this->once())
            ->method('getUrl')
            ->with('contact', ['a' => 1])
            ->willReturn('https://shop.test/contact');

        $this->assertSame('https://shop.test/contact', $this->viewModelWith($urlBuilder)->getUrl('contact', ['a' => 1]));
    }

    public function testExternalUrlDetection(): void
    {
        $base = 'https://shop.test/';

        $this->assertTrue($this->viewModel->isExternal('https://other.test/x', $base));
        $this->assertFalse($this->viewModel->isExternal('https://shop.test/x', $base));
        $this->assertFalse($this->viewModel->isExternal('/relative', $base));
    }
}
