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

class Methods implements OptionSourceInterface
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * Methods constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
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

        $methods = [];

        foreach ($methodList as $code => $method) {
            if (isset($method['is_multisafepay']) && (strpos($code, '_recurring') === false)) {
                $methods[] = [
                    'value' => $code,
                    'label' => $method['title']
                ];
            }
        }

        usort($methods, function ($method1, $method2) {
            return $method1['label'] <=> $method2['label'];
        });

        return $methods;
    }
}
