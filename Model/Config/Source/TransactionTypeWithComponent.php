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

namespace MultiSafepay\ConnectAdminhtml\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use MultiSafepay\ConnectCore\Model\Api\Builder\OrderRequestBuilder\TransactionTypeBuilder;

class TransactionTypeWithComponent extends TransactionType
{
    /**
     * @inheritdoc
     */
    public function toOptionArray(): array
    {
        return [
            [
                'value' => TransactionTypeBuilder::TRANSACTION_TYPE_REDIRECT_VALUE,
                'label' => __('Redirect'),
            ],
            [
                'value' => TransactionTypeBuilder::TRANSACTION_TYPE_DIRECT_VALUE,
                'label' => __('Direct (deprecated)'),
            ],
            [
                'value' => PaymentTypes::PAYMENT_COMPONENT_PAYMENT_TYPE,
                'label' => __('Payment Component'),
            ],
        ];
    }
}
