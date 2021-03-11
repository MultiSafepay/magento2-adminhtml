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

use Magento\Config\Model\Config\Backend\File;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\File\Uploader;
use MultiSafepay\ConnectCore\Model\Ui\Gateway\GenericGatewayConfigProvider;

class Logo extends File
{
    /**
     * Return path to directory for upload file
     *
     * @return string
     * @throw \Magento\Framework\Exception\LocalizedException
     */
    protected function _getUploadDir(): string
    {
        return $this->_mediaDirectory->getAbsolutePath(GenericGatewayConfigProvider::UPLOAD_DIR);
    }

    /**
     * Makes a decision about whether to add info about the scope.
     *
     * @return boolean
     */
    protected function _addWhetherScopeInfo(): bool
    {
        return false;
    }

    /**
     * Getter for allowed extensions of uploaded files.
     *
     * @return string[]
     */
    protected function _getAllowedExtensions(): array
    {
        return ['jpg', 'jpeg', 'gif', 'png', 'svg'];
    }

    /**
     * Check if image needs to be deleted before calling parent, since parent does not delete from directory
     *
     * @return $this
     * @throws FileSystemException
     * @throws LocalizedException
     */
    public function beforeSave(): Logo
    {
        $value = $this->getValue();
        $deleteFlag = is_array($value) && isset($value['delete']);

        if ($deleteFlag && $this->getOldValue()) {
            $this->deleteImageByFilename($this->getOldValue());
            $this->setValue('');
        }

        $file = $this->getFileData();
        if (!empty($file)) {
            $uploadDir = $this->_getUploadDir();
            try {
                $uploader = $this->_uploaderFactory->create(['fileId' => $file]);
                $uploader->setAllowedExtensions($this->_getAllowedExtensions());
                $uploader->setAllowRenameFiles(true);
                $uploader->addValidateCallback('size', $this, 'validateMaxSize');
                $result = $uploader->save($uploadDir, $this->getNewFilenameByGroupId($uploader));
            } catch (\Exception $e) {
                throw new LocalizedException(__('%1', $e->getMessage()));
            }

            $filename = $result['file'];
            if ($filename) {
                $this->setValue($filename);
            }
        } elseif (is_array($value) && !empty($value['value'])) {
            $this->setValue($value['value']);
        } else {
            $this->unsValue();
        }

        return $this;
    }

    /**
     * @param Uploader $uploader
     * @return string
     */
    private function getNewFilenameByGroupId(Uploader $uploader): string
    {
        $groupId = $this->getData('group_id') ?? 'generic';

        return $groupId . '_image.' . $uploader->getFileExtension();
    }

    /**
     * @param string $filename
     * @throws FileSystemException
     */
    private function deleteImageByFilename(string $filename): void
    {
        $this->_mediaDirectory->delete(GenericGatewayConfigProvider::UPLOAD_DIR . DIRECTORY_SEPARATOR . $filename);
    }
}
