<?php declare(strict_types=1);

/**
 * @author Siteation (https://siteation.dev/)
 * @copyright Copyright 2023 Siteation (https://siteation.dev/)
 * @license MIT
 */

namespace Siteation\StoreInfoMenus\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\Data\Form\Element\AbstractElement;

class Menu extends AbstractFieldArray
{
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

        $script = "<script>
            document.addEventListener('DOMContentLoaded', function(event) {
                require(['jquery', 'Magento_Theme/js/sortable'], function ($) {
                    $('#" . $id . "').sortable({
                        containment: 'parent',
                        items: 'tbody tr',
                        tolerance: 'pointer'
                    });

                    $('#" . $id . " tbody tr td:last-child').prepend('<span class=\"draggable-handle\" style=\"display: inline-flex; justify-content: center; align-items: center; margin-block: 0.5rem; margin-inline-end: 2rem; vertical-align: baseline;\"></span>');
                });
            });
        </script>";

        $html .= $script;

        return $html;
    }
}
