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

// phpcs:ignoreFile
namespace MultiSafepay\ConnectAdminhtml\Block\Adminhtml\Form\Field;

use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\CollectionFactory;
use Magento\Framework\Data\Form\Element\Factory;
use Magento\Framework\DataObject;
use Magento\Framework\Escaper;
use Magento\Framework\View\Asset\Repository;
use MultiSafepay\ConnectAdminhtml\Model\Config\Source\CardIconTypes;

/**
 * Based on Magento\Framework\Data\Form\Element\Radios
 */
class CreditCardIconRadios extends AbstractElement
{
    public const DEFAULT_IMG_URL = 'MultiSafepay_ConnectCore::images/multisafepay_creditcard_default.png';
    public const ALTERNATIVE_IMG_URL = 'MultiSafepay_ConnectCore::images/multisafepay_creditcard_alternative.png';
    public const CLASSIC_IMG_URL = 'MultiSafepay_ConnectCore::images/multisafepay_creditcard_classic.png';

    /**
     * @var Repository
     */
    private $assetRepository;

    /**
     * @param Repository $assetRepository
     * @param Factory $factoryElement
     * @param CollectionFactory $factoryCollection
     * @param Escaper $escaper
     * @param array $data
     */
    public function __construct(
        Repository $assetRepository,
        Factory $factoryElement,
        CollectionFactory $factoryCollection,
        Escaper $escaper,
        $data = []
    ) {
        $this->assetRepository = $assetRepository;
        parent::__construct($factoryElement, $factoryCollection, $escaper, $data);
        $this->setType('radios');
    }

    /**
     * @inheritDoc
     */
    public function getElementHtml(): string
    {
        $html = '';
        $value = $this->getValue();
        if ($values = $this->getValues()) {
            foreach ($values as $option) {
                $html .= $this->_optionToHtml($option, $value);
            }
        }
        $html .= $this->getAfterElementHtml();
        return $html;
    }

    /**
     * Render choices.
     *
     * @param array $option
     * @param string[] $selected
     * @return string
     */
    protected function _optionToHtml(array $option, $selected): string
    {
        switch ($option['value']) {
            case CardIconTypes::DEFAULT:
                $imageUrl = $this->assetRepository->getUrl(self::DEFAULT_IMG_URL);
                break;
            case CardIconTypes::ALTERNATIVE:
                $imageUrl = $this->assetRepository->getUrl(self::ALTERNATIVE_IMG_URL);
                break;
            case CardIconTypes::CLASSIC:
                $imageUrl = $this->assetRepository->getUrl(self::CLASSIC_IMG_URL);
                break;
            default:
                $imageUrl = '';
                break;
        }

        $html = '<div class="admin__field admin__field-option admin-field-option-multisafepay">' .
            '<img src="' . $imageUrl . '" class="multisafepay-payment-icon" />' .
            '<input type="radio"' . $this->getRadioButtonAttributes($option);
        $option = new DataObject($option);
        $optionId = $this->getHtmlId() . $option['value'];
        $html .= 'value="' . $this->_escape(
                $option['value']
            ) . '" class="admin__control-radio" id="' .$optionId  .'"';
        if ($option['value'] === $selected) {
            $html .= ' checked="checked"';
        }
        $html .= ' />';
        $html .= '<label class="admin__field-label multisafepay-icon-label" for="' .
            $this->getHtmlId() .
            $option['value'] .
            '"><span>' .
            $option['label'] .
            '</span></label>';

        $html .= '</div>';

        return $html;
    }

    /**
     * @inheritDoc
     */
    public function getHtmlAttributes(): array
    {
        return array_merge(parent::getHtmlAttributes(), ['name']);
    }

    /**
     * Get a choice's HTML attributes.
     *
     * @param array $option
     * @return string
     */
    protected function getRadioButtonAttributes(array $option): string
    {
        $html = '';
        foreach ($this->getHtmlAttributes() as $attribute) {
            if ($value = $this->getDataUsingMethod($attribute, $option['value'])) {
                $html .= ' ' . $attribute . '="' . $value . '" ';
            }
        }
        return $html;
    }
}
