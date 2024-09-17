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

use MultiSafepay\ConnectAdminhtml\Model\Config\Source\TimeUnits;
use MultiSafepay\ConnectCore\Test\Integration\AbstractTestCase;

class TimeUnitsTest extends AbstractTestCase
{
    /**
     * Test if the toOptionArray method returns the correct array with the correct values
     *
     * @return void
     */
    public function testToOptionArray()
    {
        $result = $this->getObjectManager()->create(TimeUnits::class)->toOptionArray();

        $this->assertIsArray($result);
        $this->assertCount(4, $result);
        $this->assertEquals(0, $result[0]['value']);
        $this->assertEquals('Seconds', $result[0]['label']->render());
        $this->assertEquals(1, $result[1]['value']);
        $this->assertEquals('Minutes', $result[1]['label']->render());
        $this->assertEquals(2, $result[2]['value']);
        $this->assertEquals('Hours', $result[2]['label']->render());
        $this->assertEquals(3, $result[3]['value']);
        $this->assertEquals('Days', $result[3]['label']->render());
    }
}
