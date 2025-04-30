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
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

class ManualCapture extends Value
{
    private const PAYMENT = 'payment';
    private const PAYMENT_ACTION = 'payment_action';
    private const MANUAL_CAPTURE = 'manual_capture';
    private const AUTHORIZE_PAYMENT_ACTION = 'authorize';
    private const INITIALIZE_PAYMENT_ACTION = 'initialize';

    /**
     * @var WriterInterface
     */
    private $writer;

    /**
     * ManualCapture constructor.
     *
     * @param Context $context
     * @param Registry $registry
     * @param ScopeConfigInterface $config
     * @param TypeListInterface $cacheTypeList
     * @param WriterInterface $writer
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     * @throws LocalizedException
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ScopeConfigInterface $config,
        TypeListInterface $cacheTypeList,
        WriterInterface $writer,
        ?AbstractResource $resource = null,
        ?AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
        $this->writer = $writer;
    }

    /**
     * Change the payment action to authorize or initialize based on the manual capture value
     *
     * @return ManualCapture
     */
    public function afterSave(): ManualCapture
    {
        if ($this->getValue() === '1') {
            $this->saveValue($this->getGroupId(), self::PAYMENT_ACTION, self::AUTHORIZE_PAYMENT_ACTION);
            $this->saveValue($this->getGroupId() . '_recurring', self::MANUAL_CAPTURE, '1');

            if ($this->getFieldsetDataValue(Vault::FIELD_VAULT_ENABLED) === '1') {
                $this->saveValue($this->getGroupId() . '_vault', self::MANUAL_CAPTURE, '1');
            }

            return parent::afterSave();
        }

        $this->saveValue($this->getGroupId(), self::PAYMENT_ACTION, self::INITIALIZE_PAYMENT_ACTION);
        $this->saveValue($this->getGroupId() . '_recurring', self::MANUAL_CAPTURE, '0');

        if ($this->getFieldsetDataValue(Vault::FIELD_VAULT_ENABLED) === '1') {
            $this->saveValue($this->getGroupId() . '_vault', self::MANUAL_CAPTURE, '0');
        }

        return parent::afterSave();
    }

    /**
     * Save the value in the configuration
     *
     * @param string $gateway
     * @param string $fieldKey
     * @param string $fieldValue
     * @return void
     */
    private function saveValue(string $gateway, string $fieldKey, string $fieldValue)
    {
        $this->writer->save(
            self::PAYMENT . DIRECTORY_SEPARATOR . $gateway . DIRECTORY_SEPARATOR . $fieldKey,
            $fieldValue
        );
    }
}
