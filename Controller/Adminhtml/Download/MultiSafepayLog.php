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

declare(strict_types=1);

namespace MultiSafepay\ConnectAdminhtml\Controller\Adminhtml\Download;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use MultiSafepay\ConnectCore\Util\ZipUtil;

class MultiSafepayLog extends Action
{
    /**
     * @var ZipUtil
     */
    private $zipUtil;

    /**
     * MultiSafepayLog constructor.
     *
     * @param Context $context
     * @param ZipUtil $zipUtil
     */
    public function __construct(
        Context $context,
        ZipUtil $zipUtil
    ) {
        parent::__construct($context);
        $this->zipUtil = $zipUtil;
    }

    /**
     * @return ResponseInterface
     * @throws Exception
     */
    public function execute(): ResponseInterface
    {
        return $this->zipUtil->zipLogFiles();
    }
}
