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

use Magento\Customer\Api\Data\GroupInterface;
use Magento\Customer\Model\GroupManagement;
use Magento\Framework\Convert\DataObject;
use Magento\Framework\Exception\LocalizedException;
use MultiSafepay\ConnectAdminhtml\Model\Config\Source\CustomerGroups;
use MultiSafepay\ConnectCore\Test\Integration\AbstractTestCase;

class CustomerGroupsTest extends AbstractTestCase
{
    /**
     * Test if the toOptionArray method returns the correct array with the correct values
     *
     * @return void
     * @throws LocalizedException
     */
    public function testCustomerGroupsReturnsExpectedValues(): void
    {
        $groupManagement = $this->createMock(GroupManagement::class);
        $groupManagement->method('getLoggedInGroups')
            ->willReturn([
                $this->createMockGroup(1, 'Group 1'),
                $this->createMockGroup(2, 'Group 2'),
            ]);

        $converter = $this->createMock(DataObject::class);
        $converter->method('toOptionArray')
            ->willReturn([
                ['value' => 1, 'label' => 'Group 1'],
                ['value' => 2, 'label' => 'Group 2'],
            ]);

        $customerGroups = $this->getObjectManager()->create(CustomerGroups::class, [
            'groupManagement' => $groupManagement,
            'converter' => $converter,
        ]);

        $result = $customerGroups->toOptionArray();

        $this->assertIsArray($result);
        $this->assertCount(3, $result);
        $this->assertEquals([
            ['value' => 0, 'label' => __('Guests')],
            ['value' => 1, 'label' => 'Group 1'],
            ['value' => 2, 'label' => 'Group 2'],
        ], $result);
    }

    /**
     * Test if the toOptionArray method returns the correct array with the correct values when no groups are available
     *
     * @return void
     * @throws LocalizedException
     */
    public function testcustomerGroupsReturnsGuestsOnlyWhenNoGroupsAvailable(): void
    {
        $groupManagement = $this->createMock(GroupManagement::class);
        $groupManagement->method('getLoggedInGroups')
            ->willReturn([]);

        $converter = $this->createMock(DataObject::class);
        $converter->method('toOptionArray')
            ->willReturn([]);

        $customerGroups = $this->getObjectManager()->create(CustomerGroups::class, [
            'groupManagement' => $groupManagement,
            'converter' => $converter,
        ]);

        $result = $customerGroups->toOptionArray();

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertEquals([
            ['value' => 0, 'label' => __('Guests')],
        ], $result);
    }

    /**
     * Test if the toOptionArray method throws an exception when invalid data is provided
     *
     * @return void
     * @throws LocalizedException
     */
    public function testCustomerGroupsThrowsExceptionWhenInvalidDataProvided(): void
    {
        $groupManagement = $this->createMock(GroupManagement::class);
        $groupManagement->method('getLoggedInGroups')
            ->will($this->throwException(new LocalizedException(__('Invalid data provided'))));

        $converter = $this->createMock(DataObject::class);

        $this->expectException(LocalizedException::class);
        $this->expectExceptionMessage('Invalid data provided');

        $customerGroups = $this->getObjectManager()->create(CustomerGroups::class, [
            'groupManagement' => $groupManagement,
            'converter' => $converter,
        ]);

        $customerGroups->toOptionArray();
    }

    /**
     * Create a mock group
     *
     * @param int $id
     * @param string $code
     * @return GroupInterface
     */
    private function createMockGroup(int $id, string $code): GroupInterface
    {
        $mockGroup = $this->getMockBuilder(GroupInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mockGroup->method('getId')
            ->willReturn($id);

        $mockGroup->method('getCode')
            ->willReturn($code);

        return $mockGroup;
    }
}
