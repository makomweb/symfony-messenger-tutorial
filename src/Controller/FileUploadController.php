<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\FileUploader;
use Psr\Log\LoggerInterface;

class FileUploadController extends AbstractController
{
    /**
     * @param FileUploader $uploader
     * @param LoggerInterface $logger
     */
    public function __construct(FileUploader $uploader, LoggerInterface $logger)
    {
        $this->uploader = $uploader;
        $this->logger = $logger;
    }

    /**
     * @Route("/upload", name="upload")
     */
    public function index()
    {
        return $this->render('file_upload/index.html.twig');
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

        $filename = $file->getClientOriginalName();
        $this->uploader->upload($uploadDir, $file, $filename);

        return new Response("File uploaded",  Response::HTTP_OK,
            ['content-type' => 'text/plain']);
    }
}
