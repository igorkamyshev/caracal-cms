<?php

namespace App\Http\Controller\Rest;

use App\Gallery\Managing\Photo\PhotoCreateCommand;
use App\Gallery\Managing\Photo\PhotoDeleteCommand;
use App\Gallery\Managing\Photo\PhotoEditCommand;
use App\Gallery\PhotoRepository;
use App\Http\Response\EmptySuccessResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Gallery\Photo;
use App\Http\Pagination\Page;
use App\Http\Pagination\Pagination;
use App\Http\Pagination\Paginator;
use App\Http\Response\PhotoResponse;

/** @Route("/rest/photo") */
class PhotoController
{
    /** @Route("/", methods={"GET"}) */
    public function getList(Pagination $pagination, Paginator $paginator): Page
    {
        $photos = array_map(
            function (Photo $photo): PhotoResponse {
                return PhotoResponse::fromEntity($photo);
            },
            $paginator->find(Photo::class, $pagination)
        );

        $totalPhotos = $paginator->getCount(Photo::class);

        return new Page($photos, $pagination, $totalPhotos);
    }

    /** @Route("/{id}", methods={"GET"}) */
    public function get(Photo $photo): PhotoResponse
    {
        return PhotoResponse::fromEntity($photo);
    }

    /** @Route("/{id}", methods={"POST"}) */
    public function post(PhotoEditCommand $command, MessageBusInterface $bus, PhotoRepository $repo): PhotoResponse
    {
        $bus->dispatch($command);

        $id = $command->getData()->getId();

        return PhotoResponse::fromEntity(
            $repo->get($id)
        );
    }

    /** @Route("/", methods={"PUT"}) */
    public function put(PhotoCreateCommand $command, MessageBusInterface $bus, PhotoRepository $repo): PhotoResponse
    {
        $bus->dispatch($command);

        $id = $command->getData()->getId();

        return PhotoResponse::fromEntity(
            $repo->get($id)
        );
    }

    /** @Route("/{id}", methods={"DELETE"}) */
    public function delete(PhotoDeleteCommand $command, MessageBusInterface $bus): EmptySuccessResponse
    {
        $bus->dispatch($command);

        return new EmptySuccessResponse();
    }
}
