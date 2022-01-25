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

class CardPaymentTypes implements OptionSourceInterface
{
    public const REDIRECT_PAYMENT_TYPE = 'redirect';
    public const CREDIT_CARD_COMPONENT_PAYMENT_TYPE = 'credit_card';
    public const PAYMENT_REQUEST_PAYMENT_TYPE = 'payment_request';

    /**
     * {@inheritdoc}
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => self::REDIRECT_PAYMENT_TYPE, 'label' => __('Redirect')],
            ['value' => self::CREDIT_CARD_COMPONENT_PAYMENT_TYPE, 'label' => __('Credit Card Component')],
            //['value' => self::PAYMENT_REQUEST_PAYMENT_TYPE, 'label' => __('Payment Request API')]
        ];
    }
}
