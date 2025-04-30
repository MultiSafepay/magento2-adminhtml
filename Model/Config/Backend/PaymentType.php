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
use MultiSafepay\ConnectAdminhtml\Model\Config\Source\PaymentTypes;

class PaymentType extends Value
{
    private const PAYMENT = 'payment';
    private const PAYMENT_TYPE = 'payment_type';

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
     * @return PaymentType
     */
    public function afterSave(): PaymentType
    {
        if ($this->getValue() === 'payment_component') {
            $this->writer->save(
                self::PAYMENT . DIRECTORY_SEPARATOR . $this->getGroupId() . DIRECTORY_SEPARATOR . self::PAYMENT_TYPE,
                PaymentTypes::PAYMENT_COMPONENT_PAYMENT_TYPE
            );

            return parent::afterSave();
        }

        $this->writer->save(
            self::PAYMENT . DIRECTORY_SEPARATOR . $this->getGroupId() . DIRECTORY_SEPARATOR . self::PAYMENT_TYPE,
            PaymentTypes::REDIRECT_PAYMENT_TYPE
        );

        return parent::afterSave();
    }
}
