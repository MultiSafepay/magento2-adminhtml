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

class Email implements OptionSourceInterface
{
    public const BEFORE_TRANSACTION = 'before_transaction';
    public const AFTER_TRANSACTION = 'after_transaction';
    public const AFTER_PAID_TRANSACTION = 'after_paid_transaction';

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => self::BEFORE_TRANSACTION, 'label' => __('Immediately after placing the order')],
            ['value' => self::AFTER_TRANSACTION, 'label' => __('On transaction initialized status')],
            ['value' => self::AFTER_PAID_TRANSACTION, 'label' => __('On transaction completed status')],
        ];
    }
}
