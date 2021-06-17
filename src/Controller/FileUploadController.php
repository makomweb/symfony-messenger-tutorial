<?php

namespace App\Controller;

use App\Entity\FileUpload;
use App\Repository\FileUploadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\FileUploader;
use Psr\Log\LoggerInterface;
use Symfony\Component\Uid\Uuid;

class FileUploadController extends AbstractController
{
    /**
     * @param FileUploader $uploader
     * @param LoggerInterface $logger
     * @param FileUploadRepository $repository
     */
    public function __construct(FileUploader $uploader,
        LoggerInterface $logger,
        FileUploadRepository $repository)
    {
        $this->uploader = $uploader;
        $this->logger = $logger;
        $this->repository = $repository;
    }

    /**
     * @Route("/upload", name="upload")
     */
    public function index()
    {
        $uploads = $this->repository->findAll();

        return $this->render('file_upload/index.html.twig', [
            'uploads' => $uploads,
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
            $upload->setStatus("initial");
            $this->repository->save($upload);
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
