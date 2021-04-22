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

use Magento\Framework\Data\OptionSourceInterface;

class PaymentAction implements OptionSourceInterface
{
    public const PAYMENT_ACTION_AUTHORIZE_ONLY = 'authorize';
    public const PAYMENT_ACTION_AUTHORIZE_AND_CAPTURE = 'initialize';

    /**
     * {@inheritdoc}
     */
    public function toOptionArray(): array
    {
        return [
            [
                'value' => self::PAYMENT_ACTION_AUTHORIZE_ONLY,
                'label' => __('Authorize Only'),
            ],
            [
                'value' => self::PAYMENT_ACTION_AUTHORIZE_AND_CAPTURE,
                'label' => __('Authorize and Capture')
            ]
        ];
    }
}
