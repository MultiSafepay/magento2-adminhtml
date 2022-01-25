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
use MultiSafepay\ConnectCore\Service\Order\CancelMultisafepayOrderPaymentLink;

class SecondChancePaymentLink implements OptionSourceInterface
{

    /**
     * {@inheritdoc}
     */
    public function toOptionArray(): array
    {
        return [
            [
                'value' => CancelMultisafepayOrderPaymentLink::DISABLE_PRETRANSACTION_CANCELLING_OPTION,
                'label' => __('Don\'t cancel')
            ],
            [
                'value' => CancelMultisafepayOrderPaymentLink::CANCEL_BACK_BUTTON_PRETRANSACTION_OPTION,
                'label' => __('Cancel when cancel button is pressed')
            ],
            [
                'value' => CancelMultisafepayOrderPaymentLink::CANCEL_ALWAYS_PRETRANSACTION_OPTION,
                'label' => __('Cancel when cancel button pressed and when order is canceled')
            ]
        ];
    }
}
