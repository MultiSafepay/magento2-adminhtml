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
use MultiSafepay\ConnectCore\Util\CaptureUtil;

class PaymentAction implements OptionSourceInterface
{
    /**
     * {@inheritdoc}
     */
    public function toOptionArray(): array
    {
        return [
            [
                'value' => CaptureUtil::PAYMENT_ACTION_AUTHORIZE_ONLY,
                'label' => __('Authorize Only'),
            ],
            [
                'value' => CaptureUtil::PAYMENT_ACTION_AUTHORIZE_AND_CAPTURE,
                'label' => __('Authorize and Capture')
            ]
        ];
    }
}
