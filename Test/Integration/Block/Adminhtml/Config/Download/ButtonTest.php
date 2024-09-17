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

namespace MultiSafepay\ConnectAdminhtml\Test\Block\Adminhtml\Config\Download;

use MultiSafepay\ConnectAdminhtml\Block\Adminhtml\Config\Download\Button;
use MultiSafepay\ConnectCore\Test\Integration\AbstractTestCase;

class ButtonTest extends AbstractTestCase
{
    /**
     * Test if the button returns correct log url
     *
     * @return void
     */
    public function testButtonReturnsCorrectLogUrl(): void
    {
        $button = $this->getObjectManager()->create(Button::class);

        $this->assertStringContainsString('/multisafepay/download/multisafepaylog/', $button->getLogUrl());
    }
}
