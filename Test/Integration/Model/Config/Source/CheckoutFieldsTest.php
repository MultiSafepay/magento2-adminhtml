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

use MultiSafepay\ConnectAdminhtml\Model\Config\Source\CheckoutFields;
use MultiSafepay\ConnectCore\Test\Integration\AbstractTestCase;

class CheckoutFieldsTest extends AbstractTestCase
{
    /**
     * Test if the toOptionArray method returns the correct array with the correct values
     *
     * @return void
     */
    public function testToOptionArray()
    {
        $result = $this->getObjectManager()->create(CheckoutFields::class)->toOptionArray();

        $this->assertIsArray($result);
        $this->assertCount(3, $result);
        $this->assertEquals(CheckoutFields::DATE_OF_BIRTH, $result[0]['value']);
        $this->assertEquals('Date Of Birth', $result[0]['label']->render());
        $this->assertEquals(CheckoutFields::ACCOUNT_NUMBER, $result[1]['value']);
        $this->assertEquals('Bank Account', $result[1]['label']->render());
        $this->assertEquals(CheckoutFields::EMAIL_ADDRESS, $result[2]['value']);
        $this->assertEquals('E-mail Address', $result[2]['label']->render());
    }
}
