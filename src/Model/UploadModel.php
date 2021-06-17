<?php

namespace App\Model;

use App\Entity\FileUpload;

class UploadModel
{
    public function __construct(FileUpload $entity)
    {
        $this->entity = $entity;
        $this->path_parts = pathinfo($entity->getName());
    }

    public function getId() : int {

        return $this->entity->getId();
    }

    public function getName() : string {

        $sample = '74fdee1b-ddf7-4f81-a56a-8b1ae6fa4a79-';

        $name = substr($this->path_parts['filename'], strlen($sample));

        return $name . '.' . $this->path_parts['extension'];
    }

    public function getStatus() : string {

        return $this->entity->getStatus();
    }
    
    public function getDownload() : string {

        return $this->path_parts['filename'] . '.' . $this->path_parts['extension'];
    }

    public function getThumbnail() : string {

        return $this->path_parts['filename'] . '.thumbnail.' . $this->path_parts['extension'];
    }
}