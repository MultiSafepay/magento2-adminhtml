<?php

declare(strict_types=1);

namespace MultiSafepay\ConnectAdminhtml\Controller\Adminhtml\Download;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\App\ResponseInterface;

class MultiSafepayLog extends Action
{

    /**
     * @var FileFactory
     */
    private $fileFactory;

    /**
     * MultiSafepayLogs constructor.
     *
     * @param FileFactory $fileFactory
     * @param Context $context
     */
    public function __construct(
        FileFactory $fileFactory,
        Context $context
    ) {
        $this->fileFactory = $fileFactory;
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
