<?php

namespace App\Tests\Gallery\Managing\Gallery;

use App\Business\Gallery\Create\GalleryCreateCommand;
use App\Business\Gallery\GalleryData;
use PHPUnit\Framework\TestCase;

class GalleryCreateCommandTest extends TestCase
{
    public function testGetData()
    {
        $command = GalleryCreateCommand::fromData(
            new GalleryData('1')
        );

        $this->assertEquals('1', $command->getData()->getId());
    }
}
