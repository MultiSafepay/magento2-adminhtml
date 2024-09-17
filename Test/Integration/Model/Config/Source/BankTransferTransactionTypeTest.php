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

use MultiSafepay\ConnectAdminhtml\Model\Config\Source\BankTransferTransactionType;
use MultiSafepay\ConnectCore\Model\Api\Builder\OrderRequestBuilder\TransactionTypeBuilder;
use MultiSafepay\ConnectCore\Test\Integration\AbstractTestCase;

class BankTransferTransactionTypeTest extends AbstractTestCase
{
    /**
     * Test if the toOptionArray method returns the correct array with the correct values
     *
     * @return void
     */
    public function testToOptionArray()
    {
        $result = $this->getObjectManager()->create(BankTransferTransactionType::class)->toOptionArray();

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertEquals(TransactionTypeBuilder::TRANSACTION_TYPE_REDIRECT_VALUE, $result[0]['value']);
        $this->assertEquals('Yes', $result[0]['label']->render());
        $this->assertEquals(TransactionTypeBuilder::TRANSACTION_TYPE_DIRECT_VALUE, $result[1]['value']);
        $this->assertEquals('No, redirect to the "Thank You" page first', $result[1]['label']->render());
    }
}
