<?php

declare(strict_types=1);

namespace MultiSafepay\ConnectAdminhtml\Controller\Adminhtml\Download;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Exception\FileSystemException;
use MultiSafepay\ConnectCore\Logger\Logger;
use ZipArchive;

class MultiSafepayLog extends Action
{
    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var DirectoryList
     */
    protected $directoryList;

    /**
     * @var FileFactory
     */
    private $fileFactory;

    /**
     * MultiSafepayLog constructor.
     *
     * @param DirectoryList $directoryList
     * @param FileFactory $fileFactory
     * @param Logger $logger
     * @param Context $context
     */
    public function __construct(
        DirectoryList $directoryList,
        FileFactory $fileFactory,
        Logger $logger,
        Context $context
    ) {
        parent::__construct($context);
        $this->fileFactory = $fileFactory;
        $this->logger = $logger;
        $this->directoryList = $directoryList;
    }

    /**
     * @return ResponseInterface
     * @throws Exception
     */
    public function execute()
    {
        //do your custom stuff here
        $fileName = 'multisafepay.log';
        return $this->fileFactory->create(
            $fileName,
            [
                'type'  => "filename", //type has to be "filename"
                'value' =>  $fileName,
            ],
            DirectoryList::LOG
        );
    }

    public function zipLogFiles()
    {
        if (!class_exists(ZipArchive::class)) {
            $this->logger->error('\ZipArchive class not found, zip file could not be created.');
        }
        try {
            $directory = $this->directoryList->getPath(DirectoryList::LOG);

            $zipFile = new ZipArchive();
            $zipFile->open('MultiSafepayLogs.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($directory),
                \RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $name => $file) {
                // Skip directories (they would be added automatically)
                if (!$file->isDir()) {
                    // Get real and relative path for current file
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($directory) + 1);

                    // Add current file to archive
                    $zipFile->addFile($filePath, $relativePath);
                }
            }
            $zipFile->close();

            return $zipFile;
        } catch (FileSystemException $e) {
            $this->logger->logFileSystemException($e);
        }
    }
}
