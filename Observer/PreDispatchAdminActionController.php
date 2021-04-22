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
use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use MultiSafepay\ConnectCore\Logger\Logger;
use MultiSafepay\ConnectCore\Util\NotificationUtil;

class PreDispatchAdminActionController implements ObserverInterface
{
    /**
     * @var NotificationUtil
     */
    private $notificationUtil;

    /**
     * @var Session
     */
    private $backendSession;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * PreDispatchAdminActionController constructor.
     *
     * @param NotificationUtil $notificationUtil
     * @param Session $backendAuthSession
     * @param Logger $logger
     */
    public function __construct(
        NotificationUtil $notificationUtil,
        Session $backendAuthSession,
        Logger $logger
    ) {
        $this->notificationUtil = $notificationUtil;
        $this->backendSession = $backendAuthSession;
        $this->logger = $logger;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        if ($this->backendSession->isLoggedIn()) {
            try {
                $this->notificationUtil->addNewReleaseNotification();
            } catch (Exception $exception) {
                $this->logger->critical($exception);
            }
        }
    }
}
