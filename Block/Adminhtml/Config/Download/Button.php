<?php
/**
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is provided with Magento in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * Copyright © 2021 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 *
 */

declare(strict_types=1);

namespace MultiSafepay\ConnectAdminhtml\Block\Adminhtml\Config\Download;

use Magento\Backend\Block\Widget\Button as ButtonTemplate;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Exception\LocalizedException;

class Button extends Field
{
    protected $_template = 'MultiSafepay_ConnectAdminhtml::config/general/download_button.phtml';

    /**
     * @param AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element): string
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();

        return parent::render($element);
    }

    /**
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        return $this->_toHtml();
    }

    /**
     * @return string
     */
    public function getLogUrl(): string
    {
        return $this->getUrl('multisafepay/download/multisafepaylog', ['_secure' => true]);
    }

    /**
     * @return string
     * @throws LocalizedException
     */
    public function getLogButtonHtml(): string
    {
        $button = $this->getLayout()->createBlock(ButtonTemplate::class)->setData(
            [
                'id' => 'download_multisafepay_log',
                'label' => __('Download'),
            ]
        );

        return $button->toHtml();
    }
}
