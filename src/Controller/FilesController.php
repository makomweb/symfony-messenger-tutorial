<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilesController extends AbstractController
{
    /**
     * @Route("/files", name="files")
     */
    public function index(): Response
    {
        return $this->render('files/index.html.twig', [
            'controller_name' => 'FilesController',
        ]);
    }
}
