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

use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\App\Config\Value;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use MultiSafepay\ConnectCore\Model\Vault as VaultModel;
use MultiSafepay\ConnectCore\Util\VaultUtil;

class Vault extends Value
{
    /**
     * @var VaultUtil
     */
    protected $vaultUtil;

    /**
     * @var WriterInterface
     */
    private $writer;

    /**
     * Vault constructor.
     *
     * @param Context $context
     * @param Registry $registry
     * @param ScopeConfigInterface $config
     * @param TypeListInterface $cacheTypeList
     * @param VaultUtil $vaultUtil
     * @param WriterInterface $writer
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ScopeConfigInterface $config,
        TypeListInterface $cacheTypeList,
        VaultUtil $vaultUtil,
        WriterInterface $writer,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
        $this->writer = $writer;
        $this->vaultUtil = $vaultUtil;
    }

    /**
     * @return Vault
     */
    public function afterSave(): Vault
    {
        foreach (VaultModel::VAULT_GATEWAYS as $method => $recurringMethod) {
            $vaultPath = $this->vaultUtil->getActiveConfigPath($method);
            $recurringPath = 'payment/' . $recurringMethod . '/active';
            $this->writer->save($vaultPath, $this->getValue(), $this->getScope(), $this->getScopeId());
            $this->writer->save($recurringPath, $this->getValue(), $this->getScope(), $this->getScopeId());
        }

        return parent::afterSave();
    }
}
