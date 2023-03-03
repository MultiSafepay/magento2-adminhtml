<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is provided with Magento in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * See DISCLAIMER.md for disclaimer details.
 */

declare(strict_types=1);

namespace MultiSafepay\ConnectAdminhtml\Block\Adminhtml\Config;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Widget\Button;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Exception\LocalizedException;

class ValidateApiKeyButton extends Field
{
    private const TEMPLATE_PATH = 'MultiSafepay_ConnectAdminhtml::config/general/validate_api_key_button.phtml';
    private const CHECK_BUTTON_ID = 'multisafepay_validate_button';

    /**
     * @param AbstractElement $element
     * @return string
     * @throws LocalizedException
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        /** @var Template $block */
        $block = $this->_layout->createBlock(Template::class);
        $button = $this->getLayout()->createBlock(Button::class)
            ->setData([
                'id' => self::CHECK_BUTTON_ID,
                'label' => __('Validate API Key'),
                'class' => 'primary',
            ]);
        $block->setTemplate(self::TEMPLATE_PATH)
            ->setData('send_button', $button->toHtml())
            ->setData('ajax_url', $this->getAjaxUrl())
            ->setData('store_id', $this->getStoreId())
            ->setData('button_id', self::CHECK_BUTTON_ID);

        return $block->toHtml();
    }

    /**
     * @param AbstractElement $element
     * @return string
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function _renderScopeLabel(AbstractElement $element): string
    {
        return '';
    }

    /**
     * @return string
     */
    private function getAjaxUrl(): string
    {
        return $this->getUrl('multisafepay/api/validate', ['_secure' => true]);
    }

    /**
     * @return string
     */
    public function getCheckButtonId(): string
    {
        return self::CHECK_BUTTON_ID;
    }

    /**
     * Get store identifier
     *
     * @return  int
     * @throws LocalizedException
     */
    public function getStoreId(): int
    {
        $storeId = null;

        if ($website = $this->getRequest()->getParam('website')) {
            $storeIds = $this->_storeManager->getWebsite((int)$website)->getStoreIds();
            $storeId = array_pop($storeIds);
        }

        return (int)($storeId ?: $this->getRequest()->getParam('store', 0));
    }
}
