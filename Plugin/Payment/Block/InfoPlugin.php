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

namespace MultiSafepay\ConnectAdminhtml\Plugin\Payment\Block;

use Magento\Framework\Escaper;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\LayoutInterface;
use Magento\Payment\Block\Info;
use Magento\Payment\Helper\Data;
use MultiSafepay\ConnectCore\Model\Ui\Gateway\ApplePayConfigProvider;
use MultiSafepay\ConnectCore\Model\Ui\Gateway\CreditCardConfigProvider;
use MultiSafepay\ConnectCore\Model\Ui\Gateway\GooglePayConfigProvider;
use MultiSafepay\ConnectCore\Service\Process\AddCardPaymentInformation;
use MultiSafepay\ConnectCore\Service\Process\AddWalletInformation;
use MultiSafepay\ConnectCore\Util\AmountUtil;
use MultiSafepay\ConnectCore\Util\GiftcardUtil;
use MultiSafepay\ConnectCore\Util\PaymentMethodUtil;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class InfoPlugin
{
    private const MULTIAFEPAY_GIFTCARD_PAYMENT_ADDITIONAL_TEMPLATE_PATH =
        'MultiSafepay_ConnectAdminhtml::payment/info/giftcard.phtml';

    /**
     * @var LayoutInterface
     */
    private $layout;

    /**
     * @var PaymentMethodUtil
     */
    private $paymentMethodUtil;

    /**
     * @var AmountUtil
     */
    private $amountUtil;

    /**
     * @var Escaper
     */
    private $escaper;

    /**
     * @var Data
     */
    private $paymentHelper;

    /**
     * InfoPlugin constructor.
     *
     * @param LayoutInterface $layout
     * @param PaymentMethodUtil $paymentMethodUtil
     * @param AmountUtil $amountUtil
     * @param Escaper $escaper
     * @param Data $paymentHelper
     */
    public function __construct(
        LayoutInterface $layout,
        PaymentMethodUtil $paymentMethodUtil,
        AmountUtil $amountUtil,
        Escaper $escaper,
        Data $paymentHelper
    ) {
        $this->layout = $layout;
        $this->paymentMethodUtil = $paymentMethodUtil;
        $this->amountUtil = $amountUtil;
        $this->escaper = $escaper;
        $this->paymentHelper = $paymentHelper;
    }

    /**
     * @param Info $subject
     * @return Info
     * @throws LocalizedException
     */
    public function beforeToHtml(Info $subject): Info
    {
        if (($parentBlock = $subject->getParentBlock())
            && $this->paymentMethodUtil->isMultisafepayPaymentByCode($subject->getMethod()->getCode())
        ) {
            $paymentInfo = $subject->getInfo();
            $giftcardData = $paymentInfo->getAdditionalInformation(
                GiftcardUtil::MULTISAFEPAY_GIFTCARD_PAYMENT_ADDITIONAL_DATA_PARAM_NAME
            );

            if ($giftcardData && ($container = $parentBlock->getParentBlock())) {
                $block = $this->layout->createBlock(
                    Template::class,
                    '',
                    [
                        'data' => [
                            'method' => $subject->getMethod(),
                            'giftcard_data' => $giftcardData,
                            'amount_util' => $this->amountUtil,
                            'escaper' => $this->escaper,
                            'template' => self::MULTIAFEPAY_GIFTCARD_PAYMENT_ADDITIONAL_TEMPLATE_PATH,
                        ],
                    ]
                );

                $container->setChild('order_payment_additional', $block);
            }
        }

        return $subject;
    }

    /**
     * Add additional payment information to the payment info block HTML for MultiSafepay card and wallet payments
     *
     * @param Info $subject
     * @param $result
     * @return mixed
     * @throws LocalizedException
     */
    public function afterToHtml(Info $subject, $result)
    {
        $methodCode = $subject->getMethod()->getCode();
        $isMultiSafepayPaymentMethod = $this->paymentMethodUtil->isMultisafepayPaymentByCode($methodCode);
        $applicableMethods = [
            CreditCardConfigProvider::CODE,
            ApplePayConfigProvider::CODE,
            GooglePayConfigProvider::CODE,
        ];

        if (!$isMultiSafepayPaymentMethod && !in_array($methodCode, $applicableMethods, true)) {
            return $result;
        }

        $additionalInformation = $subject->getInfo()->getAdditionalInformation();

        if (empty($additionalInformation)) {
            return $result;
        }

        $titlesByGatewayCode = $this->getPaymentMethodTitlesByGatewayCode();

        $cardPaymentResult = $this->getCardPaymentHtml($additionalInformation, $result, $titlesByGatewayCode);
        if ($cardPaymentResult !== null) {
            return $cardPaymentResult;
        }

        $walletPaymentResult = $this->getWalletPaymentHtml($additionalInformation, $result, $titlesByGatewayCode);
        if ($walletPaymentResult !== null) {
            return $walletPaymentResult;
        }

        return $result;
    }

    /**
     * Get the additional HTML for card payments
     *
     * @param array $additionalInformation
     * @param string $result
     * @param array $titlesByGatewayCode
     * @return string|null
     */
    private function getCardPaymentHtml(
        array $additionalInformation,
        string $result,
        array $titlesByGatewayCode
    ): ?string {
        $cardCode = $additionalInformation[AddCardPaymentInformation::CARD_PAYMENT_ADDITIONAL_DATA_PARAM_NAME] ?? null;
        if ($cardCode === null || !isset($titlesByGatewayCode[$cardCode])) {
            return null;
        }

        return $result . __(' - Paid with ') . $this->escaper->escapeHtml($titlesByGatewayCode[$cardCode]);
    }

    /**
     * Get the additional HTML for wallet payments
     *
     * @param array $additionalInformation
     * @param string $result
     * @param array $titlesByGatewayCode
     * @return string|null
     */
    private function getWalletPaymentHtml(
        array $additionalInformation,
        string $result,
        array $titlesByGatewayCode
    ): ?string {
        $walletType = $additionalInformation[AddWalletInformation::WALLET_CARD_TYPE_ADDITIONAL_DATA_PARAM_NAME] ?? null;
        if ($walletType === null || !isset($titlesByGatewayCode[$walletType])) {
            return null;
        }

        return $result . __(' - Paid with ') . $this->escaper->escapeHtml($titlesByGatewayCode[$walletType]);
    }

    /**
     * Get an array of payment method titles, indexed by their gateway code, for all payment methods
     *
     * @return array
     */
    private function getPaymentMethodTitlesByGatewayCode(): array
    {
        $methods = $this->paymentHelper->getPaymentMethods();
        $titlesByGatewayCode = [];

        foreach ($methods as $code => $method) {
            if (strpos($code, '_recurring') !== false) {
                continue;
            }

            if (!isset($method['gateway_code'], $method['title'])) {
                continue;
            }

            $titlesByGatewayCode[$method['gateway_code']] = $method['title'];
        }

        return $titlesByGatewayCode;
    }
}
