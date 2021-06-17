<?php

namespace App\MessageHandler;


use App\Message\FileUploadMessage;
use App\Repository\FileUploadRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class FileUploadMessageHandler implements MessageHandlerInterface
{
    /**
     * @var FileUploadRepository
     */
    private $repository;

    public function __construct(FileUploadRepository $repository)
    {
        $this->repository = $repository;    
    }
    
    public function __invoke(FileUploadMessage $message)
    {
        echo 'File upload received: ' . $message->getId();

        // Fake being busy.
        sleep(1);

        // fetch entity
        $entity = $this->repository->find($message->getId());

        if ($entity)
        {
            // update status
            $entity->setStatus("handled");
            $this->repository->save($entity);
        }

        // TODO Handle errors which might occur during handling the message!
    }
}