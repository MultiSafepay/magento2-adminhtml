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

use Magento\Framework\App\Config\ScopeConfigInterface;
use MultiSafepay\ConnectAdminhtml\Model\Config\Source\Methods;
use MultiSafepay\ConnectCore\Model\Ui\Gateway\GenericGatewayConfigProvider;
use MultiSafepay\ConnectCore\Test\Integration\AbstractTestCase;

class MethodsTest extends AbstractTestCase
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var GenericGatewayConfigProvider
     */
    protected $genericGatewayConfigProvider;

    /**
     * Set up the test data and mock objects
     */
    protected function setUp(): void
    {
        $this->scopeConfig = $this->getMockBuilder(ScopeConfigInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->genericGatewayConfigProvider = $this->getMockBuilder(GenericGatewayConfigProvider::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->genericGatewayConfigProvider->method('isMultisafepayGenericMethod')
            ->willReturnCallback(function ($methodCode) {
                return $methodCode === GenericGatewayConfigProvider::CODE;
            });
    }

    /**
     * Test if the toOptionArray method returns the correct array with the correct values
     *
     * @return void
     */
    public function testToOptionArrayWithDifferentPaymentMethodScenarios()
    {
        $this->scopeConfig->method('getValue')
            ->willReturn([
                'multisafepay_ideal' => ['title' => 'iDEAL', 'is_multisafepay' => '1'],
                'braintree' => ['title' => 'Credit Card'],
                'multisafepay_creditcard' => ['is_multisafepay' => '1'],
                'multisafepay_credicard_recurring' => ['title' => 'Card Payment (Recurring)', 'is_multisafepay' => '1'],
                GenericGatewayConfigProvider::CODE => ['title' => 'Generic Method'],
            ]);

        $methods = new Methods($this->scopeConfig, $this->genericGatewayConfigProvider);
        $result = $methods->toOptionArray();

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertEquals(['value' => '', 'label' => __('-- No Default --')], $result[0]);
        $this->assertEquals(['value' => 'multisafepay_ideal', 'label' => 'iDEAL'], $result[1]);
    }

    /**
     * Test if the toOptionArray method returns the correct value when no methods are available
     *
     * @return void
     */
    public function testToOptionsArrayReturnsNoDefaultOnlyWhenNoMethodsAvailable()
    {
        $this->scopeConfig->method('getValue')
            ->willReturn([]);

        $methods = new Methods($this->scopeConfig, $this->genericGatewayConfigProvider);
        $result = $methods->toOptionArray();

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertEquals([['value' => '', 'label' => __('-- No Default --')]], $result);
    }
}
