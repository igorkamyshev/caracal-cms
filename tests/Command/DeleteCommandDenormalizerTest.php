<?php

namespace App\Tests\Command;

use App\Business\Gallery\Create\GalleryCreateCommand;
use App\Business\Gallery\Delete\GalleryDeleteCommand;
use App\Business\Gallery\Delete\PhotoDeleteCommand;
use App\Business\Gallery\Edit\PhotoEditCommand;
use App\Command\DeleteCommandDenormalizer;
use PHPUnit\Framework\TestCase;

class DeleteCommandDenormalizerTest extends TestCase
{
    public function testDenormalize()
    {
        $denormalizer = new DeleteCommandDenormalizer();

        $command = $denormalizer->denormalize(
            [], GalleryDeleteCommand::class, null,
            [
                'default_constructor_arguments' => [
                    GalleryDeleteCommand::class => [
                        'id' => '1',
                    ],
                ],
            ]
        );

        $this->assertEquals('1', $command->getId());
    }

    public function testSupportsDenormalization()
    {
        $denormalizer = new DeleteCommandDenormalizer();

        $passTypes = [
            PhotoDeleteCommand::class,
            GalleryDeleteCommand::class,
        ];

        $notPassTypes = [
            'not pass type',
            'again',
            PhotoEditCommand::class,
            GalleryCreateCommand::class,
        ];

        foreach ($passTypes as $passType) {
            $this->assertTrue($denormalizer->supportsDenormalization([], $passType));
        }

        foreach ($notPassTypes as $notPassType) {
            $this->assertFalse($denormalizer->supportsDenormalization([], $notPassType));
        }
    }
}
