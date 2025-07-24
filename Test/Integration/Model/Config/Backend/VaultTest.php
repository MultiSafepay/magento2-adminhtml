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

namespace MultiSafepay\ConnectAdminhtml\Test\Integration\Model\Config\Backend;

use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use MultiSafepay\ConnectCore\Test\Integration\AbstractTestCase;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;
use MultiSafepay\ConnectAdminhtml\Model\Config\Backend\Vault;

class VaultTest extends AbstractTestCase
{
    /**
     * @var Vault
     */
    public $vault;

    /**
     * @var WriterInterface
     */
    public $writer;

    /**
     * @var ScopeConfigInterface
     */
    public $config;

    /**
     * @throws LocalizedException
     */
    protected function setUp(): void
    {
        $context = $this->getObjectManager()->create(Context::class);
        $registry = $this->getObjectManager()->create(Registry::class);
        $this->config = $this->createMock(ScopeConfigInterface::class);
        $cacheTypeList = $this->getObjectManager()->create(TypeListInterface::class);
        $this->writer = $this->createMock(WriterInterface::class);
        $resource = $this->createMock(AbstractResource::class);
        $resourceCollection = $this->createMock(AbstractDb::class);

        $this->vault = new Vault(
            $context,
            $registry,
            $this->config,
            $cacheTypeList,
            $this->writer,
            $resource,
            $resourceCollection
        );
    }

    public function testAfterSaveWithRecurringMethod()
    {
        $this->vault->setGroupId('multisafepay_creditcard');
        $this->vault->setValue('1');

        $this->writer->expects($this->exactly(1))
            ->method('save');

        $this->vault->afterSave();
    }

    public function testAfterSaveWithTokenizationEnabled()
    {
        $this->vault->setGroupId('multisafepay_creditcard');
        $this->vault->setValue('1');

        $this->config->expects($this->any())
            ->method('getValue')
            ->willReturn('1');

        $this->writer->expects($this->exactly(2))
            ->method('save');

        $this->vault->afterSave();
    }

    public function testAfterSaveWithTokenizationDisabled()
    {
        $this->vault->setGroupId('multisafepay_creditcard');
        $this->vault->setValue('1');

        $this->config->expects($this->any())
            ->method('getValue')
            ->willReturn('0');

        $this->writer->expects($this->exactly(1))
            ->method('save');

        $this->vault->afterSave();
    }

    public function testAfterSaveWithDifferentMethod()
    {
        $this->vault->setGroupId('multisafepay_afterpay');
        $this->vault->setValue('1');

        $this->writer->expects($this->never())
            ->method('save');

        $this->vault->afterSave();
    }
}
