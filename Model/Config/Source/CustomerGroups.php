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

namespace MultiSafepay\ConnectAdminhtml\Model\Config\Source;

use Magento\Customer\Api\GroupManagementInterface;
use Magento\Framework\Convert\DataObject;
use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\Exception\LocalizedException;

class CustomerGroups implements OptionSourceInterface
{

    /**
     * @var array
     */
    protected $options;

    /**
     * @var GroupManagementInterface
     */
    protected $groupManagement;

    /**
     * @var DataObject
     */
    protected $converter;

    /**
     * @param GroupManagementInterface $groupManagement
     * @param DataObject $converter
     */
    public function __construct(
        GroupManagementInterface $groupManagement,
        DataObject $converter
    ) {
        $this->groupManagement = $groupManagement;
        $this->converter = $converter;
    }

    /**
     * @return array
     * @throws LocalizedException
     */
    public function toOptionArray(): array
    {
        if (!$this->options) {
            $groups = $this->groupManagement->getLoggedInGroups();
            $this->options = $this->converter->toOptionArray($groups, 'id', 'code');
            array_unshift($this->options, ['value' => 0, 'label' => __('Guests')]);
        }
        return $this->options;
    }
}
