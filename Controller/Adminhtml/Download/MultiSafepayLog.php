<?php

declare(strict_types=1);

namespace MultiSafepay\ConnectAdminhtml\Controller\Adminhtml\Download;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Archive\Zip;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem\Driver\File;
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
     * @var File
     */
    protected $driverFile;
    /**
     * @var Zip
     */
    protected $zip;

    /**
     * @var FileFactory
     */
    private $fileFactory;

    /**
     * MultiSafepayLog constructor.
     *
     * @param DirectoryList $directoryList
     * @param FileFactory $fileFactory
     * @param File $driverFile
     * @param Logger $logger
     * @param Zip $zip
     * @param Context $context
     */
    public function __construct(
        DirectoryList $directoryList,
        FileFactory $fileFactory,
        File $driverFile,
        Logger $logger,
        Zip $zip,
        Context $context
    ) {
        parent::__construct($context);
        $this->fileFactory = $fileFactory;
        $this->logger = $logger;
        $this->directoryList = $directoryList;
        $this->driverFile = $driverFile;
        $this->zip = $zip;
    }

    /**
     * @return ResponseInterface
     * @throws Exception
     */
    public function execute(): ResponseInterface
    {
        /*
        $fileName = 'multisafepay.log';
        return $this->fileFactory->create(
            $fileName,
            [
                'type'  => "filename", //type has to be "filename"
                'value' =>  $fileName,
            ],
            DirectoryList::LOG
        );
        */

        /*
        $directory = $this->directoryList->getPath(DirectoryList::LOG) . '/multisafepay.log';
        $this->zip->pack($directory, 'test.zip');
        */

        return $this->zipLogFiles();
    }

    /**
     * @throws FileSystemException
     * @throws Exception
     */
    public function zipLogFiles(): ResponseInterface
    {
        if (!class_exists(ZipArchive::class)) {
            $this->logger->error('\ZipArchive class not found, zip file could not be created.');
        }

        $directory = $this->directoryList->getPath(DirectoryList::LOG);

        $zipFile = new ZipArchive();
        $zipFile->open(
            'MultiSafepayLogs.zip',
            ZipArchive::CREATE | ZipArchive::OVERWRITE
        );

        $files = $this->driverFile->readDirectory($directory);

        foreach ($files as $filePath) {
            if (strpos($filePath, 'multisafepay') !== false) {
                $zipFile->addFile($filePath, basename($filePath));
            }
        }
        $zipFile->close();

        return $this->fileFactory->create(
            'MultiSafepayLogs.zip',
            [
                'type' => 'filename',
                'value' => 'MultiSafepayLogs.zip',
                'rm' => true
            ],
            DirectoryList::ROOT,
            'application/zip'
        );
    }
}
