<?php

namespace App\Business\Gallery\Edit;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Business\Gallery\GalleryRepository;
use App\Business\Gallery\PhotoRepository;

class GalleryEditHandler implements MessageHandlerInterface
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var GalleryRepository */
    private $galleryRepo;
    /** @var PhotoRepository */
    private $photoRepo;

    public function __construct(EntityManagerInterface $em, GalleryRepository $galleryRepo, PhotoRepository $photoRepo)
    {
        $this->em = $em;

        $this->galleryRepo = $galleryRepo;
        $this->photoRepo = $photoRepo;
    }

    public function __invoke(GalleryEditCommand $command): void
    {
        $id = $command->getData()->getId();
        $gallery = $this->galleryRepo->get($id);

        $command->getData()->updateGallery($gallery, $this->photoRepo);

        $this->em->flush();
    }
}
