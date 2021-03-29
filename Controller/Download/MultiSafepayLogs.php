<?php

declare(strict_types=1);

namespace MultiSafepay\ConnectAdminhtml\Controller\Download;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\App\ResponseInterface;

class MultiSafepayLogs extends Action
{
    /**
     * @var DirectoryList
     */
    protected $directoryList;

    /**
     * @var FileFactory
     */
    private $fileFactory;

    /**
     * MultiSafepayLogs constructor.
     *
     * @param DirectoryList $directoryList
     * @param FileFactory $fileFactory
     * @param Context $context
     */
    public function __construct(
        DirectoryList $directoryList,
        FileFactory $fileFactory,
        Context $context
    ) {
        $this->fileFactory = $fileFactory;
        $this->directoryList = $directoryList;
        parent::__construct($context);
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
}
