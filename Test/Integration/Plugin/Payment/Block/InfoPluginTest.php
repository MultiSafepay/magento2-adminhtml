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

namespace MultiSafepay\ConnectAdminhtml\Test\Integration\Plugin\Payment\Block;

use Magento\Framework\Escaper;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\LayoutInterface;
use Magento\Payment\Block\Info;
use Magento\Payment\Helper\Data;
use Magento\Payment\Model\InfoInterface;
use MultiSafepay\ConnectAdminhtml\Plugin\Payment\Block\InfoPlugin;
use MultiSafepay\ConnectCore\Model\Ui\Gateway\ApplePayConfigProvider;
use MultiSafepay\ConnectCore\Model\Ui\Gateway\CreditCardConfigProvider;
use MultiSafepay\ConnectCore\Model\Ui\Gateway\GooglePayConfigProvider;
use MultiSafepay\ConnectCore\Service\Process\AddCardPaymentInformation;
use MultiSafepay\ConnectCore\Service\Process\AddWalletInformation;
use MultiSafepay\ConnectCore\Test\Integration\AbstractTestCase;
use MultiSafepay\ConnectCore\Util\AmountUtil;
use MultiSafepay\ConnectCore\Util\PaymentMethodUtil;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class InfoPluginTest extends AbstractTestCase
{
    /**
     * @var PaymentMethodUtil|MockObject
     */
    private $paymentMethodUtilMock;

    /**
     * @var Data|MockObject
     */
    private $paymentHelperMock;

    /**
     * @var InfoPlugin
     */
    private $plugin;

    /**
     * @return void
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $layoutMock = $this->createMock(LayoutInterface::class);
        $this->paymentMethodUtilMock = $this->createMock(PaymentMethodUtil::class);
        $amountUtilMock = $this->createMock(AmountUtil::class);
        $escaperMock = $this->createMock(Escaper::class);
        $escaperMock->method('escapeHtml')
            ->willReturnCallback(static function ($value) {
                return $value;
            });

        $this->paymentHelperMock = $this->createMock(Data::class);

        $this->plugin = new InfoPlugin(
            $layoutMock,
            $this->paymentMethodUtilMock,
            $amountUtilMock,
            $escaperMock,
            $this->paymentHelperMock
        );
    }

    /**
     * Test that the original result is returned when the payment method is not a MultiSafepay method
     *
     * @return void
     * @throws Exception
     * @throws LocalizedException
     */
    public function testAfterToHtmlReturnsOriginalResultWhenMethodIsNotApplicable(): void
    {
        $result = '<span>Payment</span>';
        $methodCode = 'checkmo';

        $subject = $this->createInfoBlockMock($methodCode, []);

        $this->paymentMethodUtilMock->expects($this->once())
            ->method('isMultisafepayPaymentByCode')
            ->with($methodCode)
            ->willReturn(false);

        $this->paymentHelperMock->expects($this->never())
            ->method('getPaymentMethods');

        self::assertSame($result, $this->plugin->afterToHtml($subject, $result));
    }

    /**
     * Test that the card payment title is appended to the original result when the gateway code from the additional
     * information matches a payment method
     *
     * @return void
     * @throws Exception
     * @throws LocalizedException
     */
    public function testAfterToHtmlAppendsCardPaymentTitle(): void
    {
        $result = '<span>Payment</span>';
        $methodCode = CreditCardConfigProvider::CODE;
        $cardGatewayCode = 'visa';

        $subject = $this->createInfoBlockMock(
            $methodCode,
            [
                AddCardPaymentInformation::CARD_PAYMENT_ADDITIONAL_DATA_PARAM_NAME => $cardGatewayCode,
            ]
        );

        $this->paymentMethodUtilMock->expects($this->once())
            ->method('isMultisafepayPaymentByCode')
            ->with($methodCode)
            ->willReturn(false);

        $this->paymentHelperMock->expects($this->once())
            ->method('getPaymentMethods')
            ->willReturn([
                'multisafepay_visa' => [
                    'gateway_code' => 'visa',
                    'title' => 'Visa',
                ],
            ]);

        $expected = $result . ' - Paid with ' . 'Visa';

        self::assertEquals($expected, (string)$this->plugin->afterToHtml($subject, $result));
    }

    /**
     * Test that the wallet payment title is appended to the original result when the gateway code from the additional
     * information matches a payment method
     *
     * @return void
     * @throws Exception
     * @throws LocalizedException
     */
    public function testAfterToHtmlAppendsWalletPaymentTitle(): void
    {
        $result = '<span>Payment</span>';
        $methodCode = ApplePayConfigProvider::CODE;
        $walletGatewayCode = 'applepay';

        $subject = $this->createInfoBlockMock(
            $methodCode,
            [
                AddWalletInformation::WALLET_CARD_TYPE_ADDITIONAL_DATA_PARAM_NAME => $walletGatewayCode,
            ]
        );

        $this->paymentMethodUtilMock->expects($this->once())
            ->method('isMultisafepayPaymentByCode')
            ->with($methodCode)
            ->willReturn(false);

        $this->paymentHelperMock->expects($this->once())
            ->method('getPaymentMethods')
            ->willReturn([
                'multisafepay_applepay' => [
                    'gateway_code' => 'applepay',
                    'title' => 'Apple Pay',
                ],
            ]);

        $expected = $result . ' - Paid with ' . 'Apple Pay';

        self::assertEquals($expected, (string)$this->plugin->afterToHtml($subject, $result));
    }

    /**
     * Test that if a recurring payment method has the same gateway code as a non-recurring method,
     * the recurring method is ignored
     *
     * @return void
     * @throws Exception
     * @throws LocalizedException
     */
    public function testAfterToHtmlIgnoresRecurringMethodsInLookupMap(): void
    {
        $result = '<span>Payment</span>';
        $methodCode = GooglePayConfigProvider::CODE;
        $walletGatewayCode = 'googlepay';

        $subject = $this->createInfoBlockMock(
            $methodCode,
            [
                AddWalletInformation::WALLET_CARD_TYPE_ADDITIONAL_DATA_PARAM_NAME => $walletGatewayCode,
            ]
        );

        $this->paymentMethodUtilMock->expects($this->once())
            ->method('isMultisafepayPaymentByCode')
            ->with($methodCode)
            ->willReturn(false);

        $this->paymentHelperMock->expects($this->once())
            ->method('getPaymentMethods')
            ->willReturn([
                'multisafepay_googlepay_recurring' => [
                    'gateway_code' => 'googlepay',
                    'title' => 'Google Pay Recurring',
                ],
            ]);

        self::assertSame($result, $this->plugin->afterToHtml($subject, $result));
    }

    /**
     * Test that if the gateway code from the additional information does not match any payment method,
     * the original result is returned
     *
     * @return void
     * @throws Exception
     * @throws LocalizedException
     */
    public function testAfterToHtmlReturnsOriginalResultWhenGatewayCodeDoesNotMatch(): void
    {
        $result = '<span>Payment</span>';
        $methodCode = CreditCardConfigProvider::CODE;

        $subject = $this->createInfoBlockMock(
            $methodCode,
            [
                AddCardPaymentInformation::CARD_PAYMENT_ADDITIONAL_DATA_PARAM_NAME => 'mastercard',
            ]
        );

        $this->paymentMethodUtilMock->expects($this->once())
            ->method('isMultisafepayPaymentByCode')
            ->with($methodCode)
            ->willReturn(false);

        $this->paymentHelperMock->expects($this->once())
            ->method('getPaymentMethods')
            ->willReturn([
                'multisafepay_visa' => [
                    'gateway_code' => 'visa',
                    'title' => 'Visa',
                ],
            ]);

        self::assertSame($result, $this->plugin->afterToHtml($subject, $result));
    }

    /**
     * Create a mock for the Info block with the specified method code and additional information
     *
     * @param string $methodCode
     * @param array $additionalInformation
     * @return Info|MockObject
     * @throws Exception
     */
    private function createInfoBlockMock(string $methodCode, array $additionalInformation)
    {
        $methodMock = new class ($methodCode) {
            /**
             * @var string
             */
            private $code;

            /**
             * @param string $code
             */
            public function __construct(string $code)
            {
                $this->code = $code;
            }

            /**
             * @return string
             */
            public function getCode(): string
            {
                return $this->code;
            }
        };

        $paymentInfoMock = $this->createMock(InfoInterface::class);
        $paymentInfoMock->method('getAdditionalInformation')
            ->willReturn($additionalInformation);

        $subject = $this->createMock(Info::class);
        $subject->method('getMethod')
            ->willReturn($methodMock);
        $subject->method('getInfo')
            ->willReturn($paymentInfoMock);

        return $subject;
    }
}
