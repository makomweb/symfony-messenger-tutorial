<?php

namespace App\MessageHandler;


use App\Message\FileUploadMessage;
use App\Repository\FileUploadRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Service\ImageResizer;

class FileUploadMessageHandler implements MessageHandlerInterface
{
    /**
     * @var FileUploadRepository
     * @var ImageResizer
     */
    private $repository;

    public function __construct(string $uploadDir,
        FileUploadRepository $repository,
        ImageResizer $resizer)
    {
        $this->repository = $repository;
        $this->resizer = $resizer;
        $this->uploadDir = $uploadDir;
    }
    
    public function __invoke(FileUploadMessage $message)
    {
        echo 'File upload received: ' . $message->getId();

        // fetch entity
        $entity = $this->repository->find($message->getId());

        if ($entity)
        {
            $path = $this->uploadDir . '/' . $entity->getName();

            echo "Start resizing for: " . $path;

            $this->resizer->resize($path);

            // update status
            $entity->setStatus("resized");
            $this->repository->save($entity);
        }

        // TODO Handle errors which might occur during handling the message!
    }
}