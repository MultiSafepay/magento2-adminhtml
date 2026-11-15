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

use Magento\Framework\Exception\LocalizedException;
use MultiSafepay\ConnectAdminhtml\Model\Config\Backend\ManualCapture;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Data\Collection\AbstractDb;
use MultiSafepay\ConnectAdminhtml\Model\Config\Backend\Vault;
use MultiSafepay\ConnectCore\Test\Integration\AbstractTestCase;

class ManualCaptureTest extends AbstractTestCase
{
    /**
     * @var ManualCapture
     */
    public $manualCapture;

    /**
     * @var WriterInterface
     */
    public $writer;

    /**
     * @throws LocalizedException
     */
    protected function setUp(): void
    {
        $context = $this->getObjectManager()->create(Context::class);
        $registry = $this->getObjectManager()->create(Registry::class);
        $config = $this->getObjectManager()->create(ScopeConfigInterface::class);
        $cacheTypeList = $this->getObjectManager()->create(TypeListInterface::class);
        $this->writer = $this->createMock(WriterInterface::class);
        $resource = $this->createMock(AbstractResource::class);
        $resourceCollection = $this->createMock(AbstractDb::class);

        $this->manualCapture = new ManualCapture(
            $context,
            $registry,
            $config,
            $cacheTypeList,
            $this->writer,
            $resource,
            $resourceCollection
        );
    }

    /**
     * Test if the writer is called twice when the manual capture is enabled
     *
     * @return void
     */
    public function testAfterSaveWithManualCaptureEnabled()
    {
        $this->manualCapture->setGroupId('multisafepay_creditcard');
        $this->manualCapture->setValue('1');

        $this->writer->expects($this->exactly(2))->method('save');

        //phpcs:ignore
        @$this->manualCapture->afterSave();
    }

    /**
     * Test if the writer is called twice when the manual capture is disabled
     *
     * @return void
     */
    public function testAfterSaveWithManualCaptureDisabled()
    {
        $this->manualCapture->setGroupId('multisafepay_creditcard');
        $this->manualCapture->setValue('0');

        $this->writer->expects($this->exactly(2))->method('save');

        //phpcs:ignore
        @$this->manualCapture->afterSave();
    }

    /**
     * Test if the writer is called three times when the manual capture is enabled and Vault is enabled
     *
     * @return void
     */
    public function testAfterSaveWithManualCaptureEnabledAndVaultEnabled()
    {
        $this->manualCapture->addData(['fieldset_data' => [Vault::FIELD_VAULT_ENABLED => '1']]);
        $this->manualCapture->setGroupId('multisafepay_creditcard');
        $this->manualCapture->setValue('1');

        $this->writer->expects($this->exactly(3))->method('save');

        //phpcs:ignore
        @$this->manualCapture->afterSave();
    }

    /**
     * Test if the writer is called three times when the manual capture is disabled and Vault is enabled
     *
     * @return void
     */
    public function testAfterSaveWithManualCaptureDisabledAndVaultEnabled()
    {
        $this->manualCapture->addData(['fieldset_data' => [Vault::FIELD_VAULT_ENABLED => '1']]);
        $this->manualCapture->setGroupId('multisafepay_creditcard');
        $this->manualCapture->setValue('0');

        $this->writer->expects($this->exactly(3))->method('save');

        //phpcs:ignore
        @$this->manualCapture->afterSave();
    }

    /**
     * Test if every value is written to the scope the Manual Capture field was saved in
     *
     * @return void
     */
    public function testAfterSaveWritesAtTheScopeOfTheField()
    {
        $this->manualCapture->addData(['fieldset_data' => [Vault::FIELD_VAULT_ENABLED => '1']]);
        $this->manualCapture->setGroupId('multisafepay_creditcard');
        $this->manualCapture->setValue('1');
        $this->manualCapture->setScope('websites');
        $this->manualCapture->setScopeId(2);

        $this->writer->expects($this->exactly(3))
            ->method('save')
            ->with(
                $this->isString(),
                $this->isString(),
                'websites',
                2
            );

        //phpcs:ignore
        @$this->manualCapture->afterSave();
    }

    /**
     * Test if the default scope is used when the Manual Capture field was saved in the default scope
     *
     * @return void
     */
    public function testAfterSaveWritesAtTheDefaultScope()
    {
        $this->manualCapture->setGroupId('multisafepay_creditcard');
        $this->manualCapture->setValue('0');
        $this->manualCapture->setScope('default');
        $this->manualCapture->setScopeId(0);

        $this->writer->expects($this->exactly(2))
            ->method('save')
            ->with(
                $this->isString(),
                $this->isString(),
                'default',
                0
            );

        //phpcs:ignore
        @$this->manualCapture->afterSave();
    }

    /**
     * Test if the dependent values are removed from the scope when the field is reset to the inherited value
     *
     * @return void
     */
    public function testAfterDeleteRemovesDependentValuesFromTheScope()
    {
        $this->manualCapture->setGroupId('multisafepay_creditcard');
        $this->manualCapture->setScope('websites');
        $this->manualCapture->setScopeId(2);

        $deleted = [];
        $this->writer->expects($this->exactly(3))
            ->method('delete')
            ->willReturnCallback(function ($path, $scope, $scopeId) use (&$deleted) {
                $deleted[] = [$path, $scope, $scopeId];
            });

        //phpcs:ignore
        @$this->manualCapture->afterDelete();

        $this->assertSame(
            [
                ['payment/multisafepay_creditcard/payment_action', 'websites', 2],
                ['payment/multisafepay_creditcard_recurring/manual_capture', 'websites', 2],
                ['payment/multisafepay_creditcard_vault/manual_capture', 'websites', 2],
            ],
            $deleted
        );
    }

    /**
     * Test if nothing is removed when the field is deleted in the default scope
     *
     * @return void
     */
    public function testAfterDeleteKeepsDefaultScopeValues()
    {
        $this->manualCapture->setGroupId('multisafepay_creditcard');

        $this->writer->expects($this->never())->method('delete');

        //phpcs:ignore
        @$this->manualCapture->afterDelete();
    }
}
