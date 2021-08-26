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

namespace MultiSafepay\ConnectAdminhtml\Observer;

use Exception;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use MultiSafepay\ConnectCore\Logger\Logger;
use MultiSafepay\ConnectCore\Util\NotificationUtil;

class BackendAuthUserLoginSuccess implements ObserverInterface
{
    /**
     * @var NotificationUtil
     */
    private $notificationUtil;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * PreDispatchAdminActionController constructor.
     *
     * @param NotificationUtil $notificationUtil
     * @param Logger $logger
     */
    public function __construct(
        NotificationUtil $notificationUtil,
        Logger $logger
    ) {
        $this->notificationUtil = $notificationUtil;
        $this->logger = $logger;
    }

    /**
     * @param Observer $observer
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(Observer $observer)
    {
        try {
            $this->notificationUtil->addNewReleaseNotification();
        } catch (Exception $exception) {
            $this->logger->critical($exception);
        }
    }
}
