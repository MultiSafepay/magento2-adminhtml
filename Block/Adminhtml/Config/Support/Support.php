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
use Magento\Framework\Escaper;
use Magento\Framework\View\Element\Template;
use MultiSafepay\ConnectCore\Util\VersionUtil;

class Support extends Template implements RendererInterface
{
    private const MULTISAFEPAY_DOCS_UPGRADE_LINK
        = 'https://docs.multisafepay.com/integrations/ecommerce-integrations/magento2/#7-updates';

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
     * @var Escaper
     */
    private $escaper;

    /**
     * Support constructor.
     *
     * @param VersionUtil $versionUtil
     * @param Template\Context $context
     * @param Escaper $escaper
     * @param array $data
     */
    public function __construct(
        VersionUtil $versionUtil,
        Template\Context $context,
        Escaper $escaper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->versionUtil = $versionUtil;
        $this->escaper = $escaper;
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
     * @return Escaper
     */
    public function getEscaper(): Escaper
    {
        return $this->escaper;
    }

    /**
     * @return string
     */
    public function getModuleVersion(): string
    {
        return $this->versionUtil->getPluginVersion();
    }

    /**
     * @return array
     */
    public function isNewVersionAvailable(): array
    {
        return $this->versionUtil->getNewVersionsDataIfExist();
    }

    /**
     * @return string
     */
    public function getUpdateDocsLink(): string
    {
        return self::MULTISAFEPAY_DOCS_UPGRADE_LINK;
    }
}
