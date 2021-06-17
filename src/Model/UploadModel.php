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

        return $this->path_parts['filename'] . '.' . $this->path_parts['extension'];
    }

    public function getStatus() : string {

        return $this->entity->getStatus();
    }
    public function getThumbnail() : string {

        return $this->path_parts['filename'] . '.thumbnail.' . $this->path_parts['extension'];
    }
}