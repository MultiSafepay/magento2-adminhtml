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

class CheckoutFields implements OptionSourceInterface
{
    public const DATE_OF_BIRTH = 'date_of_birth';
    public const ACCOUNT_NUMBER = 'account_number';
    public const EMAIL_ADDRESS = 'email_address';

    /**
     * Return possible checkout fields which the merchant can use
     *
     * @return string[][]
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => self::DATE_OF_BIRTH, 'label' => __('Date Of Birth')],
            ['value' => self::ACCOUNT_NUMBER, 'label' => __('Bank Account')],
            ['value' => self::EMAIL_ADDRESS, 'label' => __('E-mail Address')],
        ];
    }
}
