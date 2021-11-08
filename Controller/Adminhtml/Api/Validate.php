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

namespace MultiSafepay\ConnectAdminhtml\Controller\Adminhtml\Api;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use MultiSafepay\ConnectCore\Factory\SdkFactory;
use MultiSafepay\ConnectCore\Logger\Logger;
use MultiSafepay\ConnectCore\Util\JsonHandler;
use Psr\Http\Client\ClientExceptionInterface;

class Validate extends Action
{
    private const MODE_PARAM_KEY_NAME = 'mode';
    private const API_KEY_PARAM_KEY_NAME = 'apiKey';

    /**
     * @var JsonHandler
     */
    private $jsonHandler;

    /**
     * @var SdkFactory
     */
    private $sdkFactory;

    /**
     * Validate constructor.
     *
     * @param Context $context
     * @param JsonHandler $jsonHandler
     * @param SdkFactory $sdkFactory
     */
    public function __construct(
        Context $context,
        JsonHandler $jsonHandler,
        SdkFactory $sdkFactory
    ) {
        parent::__construct($context);
        $this->jsonHandler = $jsonHandler;
        $this->sdkFactory = $sdkFactory;
    }

    /**
     * @return ResponseInterface
     */
    public function execute(): ResponseInterface
    {
        try {
            if (($data = $this->getRequest()->getParams())
                && isset($data[self::MODE_PARAM_KEY_NAME], $data[self::API_KEY_PARAM_KEY_NAME])
            ) {
                $this->sdkFactory->createWithModeAndApiKey(
                    (bool)$data[self::MODE_PARAM_KEY_NAME],
                    (string)$data[self::API_KEY_PARAM_KEY_NAME],
                )->getAccountManager()->get()->getData();

                $result = [
                    'status' => true,
                    'content' => __('API key is valid.'),
                ];
            } else {
                $result = [
                    'status' => false,
                    'content' => __('Error. Something went wrong. Please, try again.'),
                ];
            }
        } catch (ClientExceptionInterface $clientException) {
            $result = [
                'status' => false,
                'content' => $clientException->getMessage(),
            ];
        } catch (Exception $exception) {
            $result = [
                'status' => false,
                'content' => $exception->getMessage(),
            ];
        }

        return $this->getResponse()->representJson(
            $this->jsonHandler->convertToJSON($result)
        );
    }
}
