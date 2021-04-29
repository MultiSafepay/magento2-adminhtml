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

namespace MultiSafepay\ConnectAdminhtml\Plugin\AdminNotification\Block\Grid\Renderer;

use Magento\AdminNotification\Block\Grid\Renderer\Notice;
use Magento\Framework\DataObject;
use Closure;
use Magento\Framework\Escaper;

class NoticePlugin
{
    private const MULTISAFEPAY_NOTIFICATION_GRID_ITEM_CLASS = 'mutlisafepay-notification-grid-item';

    /**
     * @var Escaper
     */
    private $escaper;

    /**
     * NoticePlugin constructor.
     *
     * @param Escaper $escaper
     */
    public function __construct(Escaper $escaper)
    {
        $this->escaper = $escaper;
    }

    /**
     * @param Notice $subject
     * @param Closure $proceed
     * @param DataObject $row
     * @return string
     */
    public function aroundRender(Notice $subject, Closure $proceed, DataObject $row): string
    {
        if (strpos($row->getData("title"), 'MultiSafepay') !== false) {
            return '<div class="' . self::MULTISAFEPAY_NOTIFICATION_GRID_ITEM_CLASS . '">' . $this->parentRender($row)
                   . '</div>';
        }

        return $proceed($row);
    }

    /**
     * @param DataObject $row
     * @return string
     */
    private function parentRender(DataObject $row): string
    {
        return '<span class="grid-row-title">' .
               $this->escaper->escapeHtml($row->getTitle()) .
               '</span>' .
               ($row->getDescription() ? '<br />' . $this->escaper->escapeHtml($row->getDescription()) : '');
    }
}
