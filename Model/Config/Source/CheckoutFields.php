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

namespace MultiSafepay\ConnectAdminhtml\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class CheckoutFields implements OptionSourceInterface
{
    /**
     * Return possible checkout fields which the merchant can use
     *
     * @return string[][]
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => 'date_of_birth', 'label' => __('Date Of Birth')],
            ['value' => 'account_number', 'label' => __('Bank Account')],
            ['value' => 'email_address', 'label' => __('E-mail Address')],
        ];
    }
}
