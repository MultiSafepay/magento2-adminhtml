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
use MultiSafepay\ConnectCore\Test\Integration\AbstractTestCase;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\ConnectAdminhtml\Model\Config\Backend\AccountData;
use MultiSafepay\ConnectCore\Factory\SdkFactory;
use MultiSafepay\ConnectCore\Logger\Logger;
use MultiSafepay\ConnectCore\Util\JsonHandler;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Data\Collection\AbstractDb;

class AccountDataTest extends AbstractTestCase
{
    /**
     * @var AccountData
     */
    private $accountData;

    /**
     * @var SdkFactory
     */
    private $sdkFactory;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var JsonHandler
     */
    private $jsonHandler;

    /**
     * @throws LocalizedException
     */
    protected function setUp(): void
    {
        $this->sdkFactory = $this->createMock(SdkFactory::class);
        $this->logger = $this->createMock(Logger::class);
        $this->jsonHandler = $this->createMock(JsonHandler::class);
        $context = $this->createMock(Context::class);
        $registry = $this->createMock(Registry::class);
        $config = $this->createMock(ScopeConfigInterface::class);
        $cacheTypeList = $this->createMock(TypeListInterface::class);
        $resource = $this->createMock(AbstractResource::class);
        $resourceCollection = $this->createMock(AbstractDb::class);

        $this->accountData = new AccountData(
            $context,
            $registry,
            $config,
            $cacheTypeList,
            $this->sdkFactory,
            $this->logger,
            $this->jsonHandler,
            $resource,
            $resourceCollection
        );
    }

    /**
     * Test if valid account data can be retrieved
     *
     * @return void
     */
    public function testBeforeSaveWithValidData()
    {
        $this->jsonHandler->method('convertToJSON')->willReturn('{"data":"test"}');
        $this->accountData->beforeSave();

        $this->assertEquals('{"data":"test"}', $this->accountData->getValue());
    }

    /**
     * Test if an ApiException is being logged whenever it is thrown
     *
     * @return void
     */
    public function testBeforeSaveWithApiException()
    {
        $this->sdkFactory->method('create')->willThrowException(new ApiException());
        $this->logger->expects($this->once())->method('logException');

        $this->accountData->beforeSave();

        $this->assertEquals('', $this->accountData->getValue());
    }
}
