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

namespace MultiSafepay\ConnectAdminhtml\Test\Integration\Model\Config\Source;

use Magento\Framework\Exception\LocalizedException;
use MultiSafepay\ConnectAdminhtml\Model\Config\Source\PendingPaymentStatuses;
use MultiSafepay\ConnectCore\Test\Integration\AbstractTestCase;

class PendingPaymentStatusesTest extends AbstractTestCase
{
    /**
     * Test if the toOptionArray method returns the correct array with the correct values
     *
     * @return void
     * @throws LocalizedException
     */
    public function testToOptionArray()
    {
        $result = $this->getObjectManager()->create(PendingPaymentStatuses::class)->toOptionArray();

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertArrayHasKey('value', $result[1]);
        $this->assertEquals('pending_payment', $result[1]['value']);
        $this->assertArrayHasKey('label', $result[1]);
        $this->assertEquals('Pending Payment', $result[1]['label']);
    }
}
