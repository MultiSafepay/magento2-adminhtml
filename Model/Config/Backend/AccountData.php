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

namespace MultiSafepay\ConnectAdminhtml\Model\Config\Backend;

use Exception;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Value;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use MultiSafepay\ConnectCore\Factory\SdkFactory;
use MultiSafepay\ConnectCore\Logger\Logger;
use MultiSafepay\ConnectCore\Util\JsonHandler;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Exception\InvalidApiKeyException;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class AccountData extends Value
{
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
     * AccountData constructor.
     *
     * @param Context $context
     * @param Registry $registry
     * @param ScopeConfigInterface $config
     * @param TypeListInterface $cacheTypeList
     * @param SdkFactory $sdkFactory
     * @param Logger $logger
     * @param JsonHandler $jsonHandler
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ScopeConfigInterface $config,
        TypeListInterface $cacheTypeList,
        SdkFactory $sdkFactory,
        Logger $logger,
        JsonHandler $jsonHandler,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->sdkFactory = $sdkFactory;
        $this->logger = $logger;
        $this->jsonHandler = $jsonHandler;
        parent::__construct(
            $context,
            $registry,
            $config,
            $cacheTypeList,
            $resource,
            $resourceCollection,
            $data
        );
    }

    /**
     * @return $this
     */
    public function beforeSave(): AccountData
    {
        $accountData = [];

        try {
            $accountData = $this->sdkFactory->create((int)$this->getScopeId())
                ->getAccountManager()
                ->get()
                ->getData();
        } catch (ApiException $apiException) {
            $this->logger->logException($apiException);
        } catch (InvalidApiKeyException $invalidApiKeyException) {
            $this->logger->logInvalidApiKeyException($invalidApiKeyException);
        } catch (ClientExceptionInterface $clientException) {
            $this->logger->logClientException('', $clientException);
        } catch (Exception $exception) {
            $this->logger->logException($exception);
        }

        $this->setValue($this->jsonHandler->convertToJSON($accountData));

        return $this;
    }
}
