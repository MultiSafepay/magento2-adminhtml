<?php
/**
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is provided with Magento in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * Copyright © 2021 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 *
 */

namespace MultiSafepay\ConnectAdminhtml\Plugin\Payment\Block;

use Magento\Framework\Escaper;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\LayoutInterface;
use Magento\Payment\Block\Info;
use MultiSafepay\ConnectCore\Util\AmountUtil;
use MultiSafepay\ConnectCore\Util\GiftcardUtil;
use MultiSafepay\ConnectCore\Util\PaymentMethodUtil;

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
     * InfoPlugin constructor.
     *
     * @param LayoutInterface $layout
     * @param PaymentMethodUtil $paymentMethodUtil
     * @param AmountUtil $amountUtil
     * @param Escaper $escaper
     */
    public function __construct(
        LayoutInterface $layout,
        PaymentMethodUtil $paymentMethodUtil,
        AmountUtil $amountUtil,
        Escaper $escaper
    ) {
        $this->layout = $layout;
        $this->paymentMethodUtil = $paymentMethodUtil;
        $this->amountUtil = $amountUtil;
        $this->escaper = $escaper;
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
}
