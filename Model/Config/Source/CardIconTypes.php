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

class CardIconTypes implements OptionSourceInterface
{
    public const DEFAULT = 'default';
    public const ALTERNATIVE = 'alternative';
    public const CLASSIC = 'classic';

    /**
     * {@inheritdoc}
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => self::DEFAULT, 'label' => __('Default')],
            ['value' => self::ALTERNATIVE, 'label' => __('Alternative (Grayscale)')],
            ['value' => self::CLASSIC, 'label' => __('Classic')]
        ];
    }
}
