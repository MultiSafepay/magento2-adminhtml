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

use MultiSafepay\ConnectAdminhtml\Model\Config\Source\SecondChancePaymentLink;
use MultiSafepay\ConnectCore\Service\Order\CancelMultisafepayOrderPaymentLink;
use MultiSafepay\ConnectCore\Test\Integration\AbstractTestCase;

class SecondChancePaymentLinkTest extends AbstractTestCase
{
    /**
     * Test if the toOptionArray method returns the correct array with the correct values
     *
     * @return void
     */
    public function testToOptionArray()
    {
        $result = $this->getObjectManager()->create(SecondChancePaymentLink::class)->toOptionArray();

        $this->assertIsArray($result);
        $this->assertCount(3, $result);
        $this->assertEquals(
            CancelMultisafepayOrderPaymentLink::DISABLE_PRETRANSACTION_CANCELLING_OPTION,
            $result[0]['value']
        );

        $this->assertEquals('Don\'t cancel', $result[0]['label']->render());
        $this->assertEquals(
            CancelMultisafepayOrderPaymentLink::CANCEL_BACK_BUTTON_PRETRANSACTION_OPTION,
            $result[1]['value']
        );

        $this->assertEquals('Cancel when cancel button is pressed', $result[1]['label']->render());
        $this->assertEquals(
            CancelMultisafepayOrderPaymentLink::CANCEL_ALWAYS_PRETRANSACTION_OPTION,
            $result[2]['value']
        );

        $this->assertEquals(
            'Cancel when cancel button pressed and when order is canceled',
            $result[2]['label']->render()
        );
    }
}
