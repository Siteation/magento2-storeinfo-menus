<?php declare(strict_types=1);

/**
 * @author Siteation (https://siteation.dev/)
 * @copyright Copyright 2023 Siteation (https://siteation.dev/)
 * @license MIT
 */

namespace Siteation\StoreInfoMenus\Block\Adminhtml\Form\Field;

use Magento\Backend\Block\Template\Context;
use Magento\Framework\View\Helper\SecureHtmlRenderer;
use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\Data\Form\Element\AbstractElement;

class Menu extends AbstractFieldArray
{
    public function __construct(
        Context $context,
        SecureHtmlRenderer $secureRenderer,
        array $data = []
    ) {
        $this->secureRenderer = $secureRenderer;
        parent::__construct($context, $data);
    }

    protected function _prepareToRender(): void
    {
        $this->addColumn('url', [
            'label' => __('Link'),
            'class' => 'required-entry'
        ]);

        $this->addColumn('text', [
            'label' => __('Label'),
            'class' => 'required-entry'
        ]);

        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }

    protected function _getElementHtml(AbstractElement $element): string
    {
        $id = $element['html_id'];
        $html = parent::_getElementHtml($element);

        $scriptString = <<<script
            require(['jquery', 'Magento_Theme/js/sortable'], function ($) {
                $('#$id').sortable({ containment: 'parent', items: 'tbody tr', tolerance: 'pointer' });
            });
        script;

        $html .= $this->secureRenderer->renderTag('script', [], $scriptString, false);

        return $html;
    }
}
