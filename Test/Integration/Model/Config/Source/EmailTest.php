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

use MultiSafepay\ConnectAdminhtml\Model\Config\Source\Email;
use MultiSafepay\ConnectCore\Test\Integration\AbstractTestCase;

class EmailTest extends AbstractTestCase
{
    /**
     * Test if the toOptionArray method returns the correct array with the correct values
     *
     * @return void
     */
    public function testToOptionArray()
    {
        $result = $this->getObjectManager()->create(Email::class)->toOptionArray();

        $this->assertIsArray($result);
        $this->assertCount(3, $result);
        $this->assertEquals(Email::BEFORE_TRANSACTION, $result[0]['value']);
        $this->assertEquals('Immediately after placing the order', $result[0]['label']->render());
        $this->assertEquals(Email::AFTER_TRANSACTION, $result[1]['value']);
        $this->assertEquals('On transaction initialized status', $result[1]['label']->render());
        $this->assertEquals(Email::AFTER_PAID_TRANSACTION, $result[2]['value']);
        $this->assertEquals('On transaction completed status', $result[2]['label']->render());
    }
}
