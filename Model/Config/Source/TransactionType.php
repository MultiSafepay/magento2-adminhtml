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

class TransactionType implements OptionSourceInterface
{
    public const DIRECT_VALUE = 'direct';
    public const REDIRECT_VALUE = 'redirect';

    /**
     * @inheritdoc
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => self::DIRECT_VALUE, 'label' => __('Yes')],
            ['value' => self::REDIRECT_VALUE, 'label' => __('No, redirect to the MultiSafepay payment page')],
        ];
    }
}
