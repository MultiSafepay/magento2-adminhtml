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

class Vault extends Value
{
    private const PAYMENT = 'payment';
    private const ACTIVE = 'active';
    private const TOKENIZATION = 'tokenization';

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
        WriterInterface $writer,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
        $this->writer = $writer;
    }

    /**
     * Turn on the recurring method for this specific Vault method and turn off Tokenization if it was turned on
     *
     * @return Vault
     */
    public function afterSave(): Vault
    {
        foreach (VaultModel::VAULT_GATEWAYS as $method => $recurringMethod) {
            if ($this->getGroupId() !== $method) {
                continue;
            }
            
            // Set the recurring method to active to make sure payments can be made with it
            $this->writer->save(
                self::PAYMENT . DIRECTORY_SEPARATOR . $recurringMethod . DIRECTORY_SEPARATOR . self::ACTIVE,
                $this->getValue(),
                $this->getScope(),
                $this->getScopeId()
            );

            $tokenizationPath = self::PAYMENT . DIRECTORY_SEPARATOR . $this->getGroupId() . DIRECTORY_SEPARATOR .
                                self::TOKENIZATION;

            // Check to disable Tokenization if it was enabled to make sure that both are not enabled at the same time
            if ($this->_config->getValue($tokenizationPath) && $this->getValue() === '1') {
                $this->writer->save($tokenizationPath, 0, $this->getScope(), $this->getScopeId());
            }
        }

        return parent::afterSave();
    }
}
