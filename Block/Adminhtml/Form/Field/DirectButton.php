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

namespace MultiSafepay\ConnectAdminhtml\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class DirectButton extends Field
{
    protected $_template = 'MultiSafepay_ConnectAdminhtml::config/general/direct-button.phtml';

    /**
     * Retrieve element HTML markup
     *
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        $html = $element->getElementHtml();
        $paymentCode = $this->getPaymentCode($element);

        $this->addData([
            'element' => $element,
            'element_html' => $html,
            'field_id' => $element->getHtmlId(),
            'field_name' => $element->getName(),
            'initial_value' => (string)$element->getValue(),
            'payment_code' => $paymentCode,
            'warning_message' => $this->getWarningMessage($paymentCode),
            'acknowledgement_label' => $this->getAcknowledgementLabel($paymentCode),
        ]);

        return $this->_toHtml();
    }

    /**
     * Get the payment code associated with the form element based on its configuration path.
     *
     * @param AbstractElement $element
     * @return string
     */
    private function getPaymentCode(AbstractElement $element): string
    {
        $fieldConfig = $element->getData('field_config');
        $configPath = $fieldConfig['config_path'] ?? '';

        if (strpos($configPath, 'multisafepay_applepay') !== false) {
            return 'applepay';
        }

        if (strpos($configPath, 'multisafepay_googlepay') !== false) {
            return 'googlepay';
        }

        return 'unknown';
    }

    /**
     * Get the warning message based on the payment method associated with the element.
     *
     * @param string $paymentCode
     * @return string
     */
    private function getWarningMessage(string $paymentCode): string
    {
        if ($paymentCode === 'applepay') {
            return (string)__(
                'Apple Pay Direct requires prerequisites to be completed before this option will work correctly.'
            );
        }

        if ($paymentCode === 'googlepay') {
            return (string)__(
                'Google Pay Direct requires prerequisites to be completed before this option will work correctly.'
            );
        }

        return (string)__(
            'This direct button requires prerequisites to be completed before it will work correctly.'
        );
    }

    /**
     * Get the label for the acknowledgement checkbox based on the payment method.
     *
     * @param string $paymentCode
     * @return string
     */
    private function getAcknowledgementLabel(string $paymentCode): string
    {
        if ($paymentCode === 'applepay') {
            return (string)__(
                'I confirm that I have completed the Apple Pay Direct prerequisites.'
            );
        }

        if ($paymentCode === 'googlepay') {
            return (string)__(
                'I confirm that I have completed the Google Pay Direct prerequisites.'
            );
        }

        return (string)__(
            'I confirm that I have completed the required prerequisites.'
        );
    }
}
