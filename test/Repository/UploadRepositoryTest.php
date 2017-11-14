<?php
declare(strict_types=1);
namespace VC4A\Test\Repository;

use VC4A\Repository\UploadRepository;
use PHPUnit\Framework\TestCase;
use VC4A\Test\UploadRepositoryMethodMock;

/**
 * Test cases for the UploadRepository
 * handling atleast 1 success case and 1 failure case for each class method.
 */
class UploadRepositoryTest extends TestCase
{

    /**
     * @var uploadRepository
     */
    private $uploadRepository;

    /**
     * @var UploadRepositoryMethodMock
     */
    private $uploadRepositoryMethodMock;

    public function setUp()
    {

        $this->uploadRepository = new UploadRepository;
        $this->uploadRepositoryMethodMock = new UploadRepositoryMethodMock;

        parent::setUp();
    }

    /**
     * @dataProvider fileProvider
     * @return void
     */
    public function testCreateSucceeds(array $expected)
    {

        $actual = $this->uploadRepositoryMethodMock->create($expected);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider fileProvider
     * @expectedException Exception
     * @expectedExceptionMessage Can not upload file, context: ["tmpFileName.png","fileName.png"]
     * @return void
     */
    public function testCreateFailsException(array $expected)
    {
        $actual = $this->uploadRepository->create($expected);
    }


    /**
     * @return array
     */
    public function fileProvider(): array
    {
        return [
            [
                [
                    'tmpFileName.png',
                    'fileName.png'
                ]
            ]
        ];
    }
}
