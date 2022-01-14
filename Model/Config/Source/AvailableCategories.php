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
 * Copyright © 2022 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 *
 */

declare(strict_types=1);

namespace MultiSafepay\ConnectAdminhtml\Model\Config\Source;

use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\Exception\LocalizedException;
use MultiSafepay\ConnectCore\Model\Ui\Giftcard\EdenredGiftcardConfigProvider;

class AvailableCategories implements OptionSourceInterface
{
    public const SYSTEM_CATEGORY_ID = 1;
    public const ROOT_LEVEL = 1;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var array
     */
    private $categories = [];

    /**
     * AvailableCategories constructor.
     *
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @return array|array[]
     * @throws LocalizedException
     */
    public function toOptionArray(): array
    {
        if (!$this->categories) {
            $this->categories = $this->getChildren(self::SYSTEM_CATEGORY_ID, self::ROOT_LEVEL);
        }

        return $this->categories;
    }

    /**
     * @param int $parentCategoryId
     * @param int $level
     * @return array
     * @throws LocalizedException
     */
    private function getChildren(int $parentCategoryId, int $level): array
    {
        $options = [
            ['value' => EdenredGiftcardConfigProvider::CONFIG_ALL_CATEGORIES_VALUE, 'label' => __('All Categories')],
        ];
        $collection = $this->collectionFactory->create();
        $collection->addAttributeToSelect('name');
        $collection->addAttributeToFilter('level', $level);
        $collection->addAttributeToFilter('parent_id', $parentCategoryId);
        $collection->addAttributeToFilter('is_active', 1);
        $collection->setOrder('position', 'asc');

        foreach ($collection as $category) {
            if ($category->getLevel() > self::ROOT_LEVEL) {
                $options[$category->getId()] = [
                    'value' => $category->getId(),
                    'label' => str_repeat(". ", max(0, ($category->getLevel() - 1) * 3))
                               . $category->getName(),
                ];
            }

            if ($category->hasChildren()) {
                $options = array_replace(
                    $options,
                    $this->getChildren(
                        (int)$category->getId(),
                        $category->getLevel() + 1
                    )
                );
            }
        }

        return $options;
    }
}
