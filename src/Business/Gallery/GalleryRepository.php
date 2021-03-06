<?php

namespace App\Business\Gallery;

use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;

class GalleryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Gallery::class);
    }

    public function get(string $id): Gallery
    {
        /** @var Gallery|null $gallery */
        $gallery = $this->find($id);

        if (!$gallery) {
            throw new EntityNotFoundException(sprintf('Gallery with id "%s" not found', $id));
        }

        return $gallery;
    }
}
