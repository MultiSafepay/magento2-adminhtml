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
 * Copyright © 2022 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 *
 */

declare(strict_types=1);

namespace MultiSafepay\ConnectAdminhtml\Block\Adminhtml\Form\Field;

use Magento\Framework\View\Element\Html\Select;
use Magento\Backend\Block\Template\Context;
use Magento\Customer\Model\Customer\Attribute\Source\GroupSourceLoggedInOnlyInterface;

class CustomerGroupColumn extends Select
{
    protected $customerGroupData;

    /**
     * CustomColumn constructor.
     *
     * @param Context $context
     * @param GroupSourceLoggedInOnlyInterface $customerGroupData
     * @param array $data
     */
    public function __construct(
        Context $context,
        GroupSourceLoggedInOnlyInterface $customerGroupData,
        array $data = []
    ) {
        $this->customerGroupData = $customerGroupData;
        parent::__construct($context, $data);
    }

    /**
     * Set the title of the input field
     *
     * @param string $value
     * @return CustomerGroupColumn
     */
    public function setInputName(string $value): CustomerGroupColumn
    {
        return $this->setName($value);
    }

    /**
     * Set the ID of the input field
     *
     * @param string $value
     * @return CustomerGroupColumn
     */
    public function setInputId(string $value): CustomerGroupColumn
    {
        return $this->setId($value);
    }

    /**
     * Render HTML
     *
     * @return string
     */
    public function _toHtml(): string
    {
        if (!$this->getOptions()) {
            $this->setOptions($this->getSourceOptions());
        }
        return parent::_toHtml();
    }

    /**
     * Get all the groups as options and add the guest group
     *
     * @return array
     */
    private function getSourceOptions(): array
    {
        $customerGroups = $this->customerGroupData->toOptionArray();
        array_unshift($customerGroups, ['value' => 0, 'label' => __('Guests')->render()]);

        return $customerGroups;
    }
}
