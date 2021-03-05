<?php

declare(strict_types=1);

namespace MultiSafepay\ConnectAdminhtml\Model\Config\Source;

use Magento\Sales\Model\Config\Source\Order\Status;
use Magento\Sales\Model\Order;

class PendingPaymentStatuses extends Status
{
    /**
     * @var string
     */
    protected $_stateStatuses = Order::STATE_PENDING_PAYMENT;
}
