<?php

namespace App\Controller;

use App\Entity\FileUpload;
use App\Model\UploadModel;
use App\Message\FileUploadMessage;
use App\Repository\FileUploadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Service\FileUploader;
use Psr\Log\LoggerInterface;
use Symfony\Component\Uid\Uuid;

class FileUploadController extends AbstractController
{
    /**
     * @param FileUploader $uploader
     * @param LoggerInterface $logger
     * @param FileUploadRepository $repository
     * @param MessageBusInterface $bus
     */
    public function __construct(FileUploader $uploader,
        LoggerInterface $logger,
        FileUploadRepository $repository,
        MessageBusInterface $bus)
    {
        $this->uploader = $uploader;
        $this->logger = $logger;
        $this->repository = $repository;
        $this->bus = $bus;
    }

    public function toModel(FileUpload $upload) : UploadModel
    {
        return new UploadModel($upload);
    }

    /**
     * @Route("/upload", name="upload")
     */
    public function index()
    {
        $entities = $this->repository->findAll();

        $models = array_map('self::toModel', $entities);

        return $this->render('file_upload/index.html.twig', [
            'uploads' => $models,
        ]);
    }

    /**
     * @Route("/do-upload", name="do-upload")
     * @param Request $request
     * @param string $uploadDir
     * @return Response
     */
    public function doUpload(Request $request, string $uploadDir): Response
    {
        $token = $request->get("token");

        // if (!$this->isCsrfTokenValid('upload', $token))
        // {
        //     $this->logger->info("CSRF failure");

        //     return new Response("Operation not allowed",  Response::HTTP_BAD_REQUEST,
        //         ['content-type' => 'text/plain']);
        // }

        $file = $request->files->get('myfile');

        if (empty($file))
        {
            return new Response("No file specified",
               Response::HTTP_UNPROCESSABLE_ENTITY, ['content-type' => 'text/plain']);
        }

        $filename = $this->getUniqueFileName(
            $file->getClientOriginalName()
        );

        $this->uploader->upload($uploadDir, $file, $filename);

        {
            $upload = new FileUpload();
            $upload->setName($filename);
            $upload->setStatus("uploaded");
            $id = $this->repository->save($upload);
            $this->bus->dispatch(new FileUploadMessage($id));
        }

        return $this->redirectToRoute('upload');
    }

    /**
     * @Route("/clear-uploads", name="clear-uploads")
     */
    public function clearUploads()
    {
        $uploads = $this->repository->findAll();

        $this->repository->removeUploads($uploads);

        return $this->redirectToRoute('upload');
    }

    private function getUniqueFileName(string $filename) {

        $uuid = Uuid::v4();
        
        return $uuid->toRfc4122() . '-' . $filename;        
    }
}
