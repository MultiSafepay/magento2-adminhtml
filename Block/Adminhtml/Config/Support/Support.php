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

namespace MultiSafepay\ConnectAdminhtml\Block\Adminhtml\Config\Support;

use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\Renderer\RendererInterface;
use Magento\Framework\View\Element\Template;
use MultiSafepay\ConnectCore\Util\VersionUtil;

class Support extends Template implements RendererInterface
{
    /**
     * @var string
     * @codingStandardsIgnoreLine
     */
    protected $_template = 'MultiSafepay_ConnectAdminhtml::config/support/support.phtml';

    /**
     * @var VersionUtil
     */
    private $versionUtil;

    /**
     * Support constructor.
     * @param VersionUtil $versionUtil
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        VersionUtil $versionUtil,
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->versionUtil = $versionUtil;
    }

    /**
     * @inheritDoc
     */
    public function render(AbstractElement $element): string
    {
        /**
         * @noinspection PhpUndefinedMethodInspection
         */
        $this->setElement($element);

        return $this->toHtml();
    }

    /**
     * @return string
     */
    public function getModuleVersion(): string
    {
        return $this->versionUtil->getPluginVersion();
    }
}
