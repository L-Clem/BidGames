<?php

namespace App\Controller;

use App\Entity\File;
use App\Entity\Game;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PostImageController
{

    public function __construct(private EntityManagerInterface $em)
    {
    }

    function __invoke(Request $request)
    {
        $uploadedFile = $request->files->get('file');
        $item = $request->attributes;

        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }
        $item = $this->em->getRepository($item->get('_api_resource_class'))->find($item->get('id'));
        $mediaObject = new File();
        $mediaObject->file = $uploadedFile;
        $this->em->persist($mediaObject);
        $item->addPicture($mediaObject);

        return $item;
    }
}
