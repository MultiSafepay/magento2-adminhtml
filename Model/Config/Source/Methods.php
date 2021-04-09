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

namespace MultiSafepay\ConnectAdminhtml\Model\Config\Source;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Data\OptionSourceInterface;
use MultiSafepay\ConnectCore\Model\Ui\Gateway\GenericGatewayConfigProvider;

class Methods implements OptionSourceInterface
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var GenericGatewayConfigProvider
     */
    private $genericGatewayConfigProvider;

    /**
     * Methods constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param GenericGatewayConfigProvider $genericGatewayConfigProvider
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        GenericGatewayConfigProvider $genericGatewayConfigProvider
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->genericGatewayConfigProvider = $genericGatewayConfigProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function toOptionArray(): array
    {
        return $this->getAllMethods();
    }

    /**
     * @return array
     */
    public function getAllMethods(): array
    {
        $methodList = $this->scopeConfig->getValue('payment');

        if (isset($methodList[GenericGatewayConfigProvider::CODE])) {
            unset($methodList[GenericGatewayConfigProvider::CODE]);
        }

        $methods = [];
        $methods[] = [
            'value' => '',
            'label' => '-- No Default --',
        ];

        foreach ($methodList as $code => $method) {
            if ($this->isMethodPreselectAllowed($method, $code)) {
                $methods[] = [
                    'value' => $code,
                    'label' => $method['title'],
                ];
            }
        }

        usort($methods, function ($method1, $method2) {
            return $method1['label'] <=> $method2['label'];
        });

        return $methods;
    }

    /**
     * @param array $methodData
     * @param string $methodCode
     * @return bool
     */
    private function isMethodPreselectAllowed(array $methodData, string $methodCode): bool
    {
        if (!isset($methodData['title'])) {
            return false;
        }

        if ($this->genericGatewayConfigProvider->isMultisafepayGenericMethod($methodCode)) {
            return true;
        }

        if (isset($methodData['is_multisafepay']) && (strpos($methodCode, '_recurring') === false)) {
            return true;
        }

        return false;
    }
}
