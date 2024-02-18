<?php declare(strict_types=1);

/**
 * @author Siteation (https://siteation.dev/)
 * @copyright Copyright 2021 Siteation (https://siteation.dev/)
 * @license MIT
 */

namespace Siteation\StoreInfoMenus\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class Menu extends AbstractFieldArray
{
    protected function _prepareToRender()
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
}
