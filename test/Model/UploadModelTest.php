<?php
declare(strict_types=1);
namespace VC4A\Test\Model;

use VC4A\Repository\RepositoryInterface;
use PHPUnit\Framework\TestCase;
use VC4A\Model\UploadModel;
use VC4A\Model\DocumentsModel;
use InvalidArgumentException;

class UploadModelTest extends TestCase
{
    /**
     * @var UploadModel
     */
    private $uploadModel;

    /**
     * @var RepositoryInterface
     */
    private $repository;

    public function setUp()
    {
        $this->repository = $this
            ->getMockBuilder(RepositoryInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['create', 'all'])
            ->getMock();

        $this->uploadModel = new UploadModel($this->repository);

        parent::setUp();
    }

    /**
     * @dataProvider getFilesGlobalProvider
     *
     * @param array $data
     * @return void
     */
    public function testCreateSucceeds(array $data)
    {

        $params = $this->uploadModel->validate($data[UploadModel::FILES_KEY]);
        $expected = [
            [DocumentsModel::FILENAME => $params[0][1]],
            [DocumentsModel::FILENAME => $params[1][1]]
        ];
        $this->repository->expects($this->at(0))
            ->method('create')
            ->with($this->equalTo($params[0]))
            ->will($this->returnValue($params[0]));

        $this->repository->expects($this->at(1))
            ->method('create')
            ->with($this->equalTo($params[1]))
            ->will($this->returnValue($params[1]));

        $actual = $this->uploadModel->create($data);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider getCreateFailsExceptionsProvider
     * @param array $data
     */
    public function testCreateFails(array $data)
    {
        try {
            $this->uploadModel->create($data);
        } catch (InvalidArgumentException $exception) {
            $actual = $exception->getMessage();
            $expected  = $this->uploadModel->fetchUploadErrorInfo()[
                $data[UploadModel::FILES_KEY][UploadModel::FILES_ERROR_KEY][0]
            ];
            $this->assertEquals($expected, $actual);
        }
    }

    public function getCreateFailsExceptionsProvider()
    {
        return [
            [
                [
                    UploadModel::FILES_KEY => [
                        UploadModel::FILES_ERROR_KEY => [1]
                    ]
                ]
            ],
            [
                [
                    UploadModel::FILES_KEY => [
                        UploadModel::FILES_ERROR_KEY => [2]
                    ]
                ]
            ],
            [
                [
                    UploadModel::FILES_KEY => [
                        UploadModel::FILES_ERROR_KEY => [3]
                    ]
                ]
            ],
            [
                [
                    UploadModel::FILES_KEY => [
                        UploadModel::FILES_ERROR_KEY => [4]
                    ]
                ]
            ],
            [
                [
                    UploadModel::FILES_KEY => [
                        UploadModel::FILES_ERROR_KEY => [6]
                    ]
                ]
            ],
            [
                [
                    UploadModel::FILES_KEY => [
                        UploadModel::FILES_ERROR_KEY => [7]
                    ]
                ]
            ],
            [
                [
                    UploadModel::FILES_KEY => [
                        UploadModel::FILES_ERROR_KEY => [8]
                    ]
                ]
            ],
        ];
    }

    public function getFilesGlobalProvider()
    {
        return [
            [
                [
                    UploadModel::FILES_KEY => [
                        UploadModel::FILES_ERROR_KEY => [UPLOAD_ERR_OK, UPLOAD_ERR_OK],
                        UploadModel::FILES_NAME_KEY => ['1.png', '2.png'],
                        UploadModel::FILES_TEMP_NAME_KEY => ['x1.png', 'x2.png']
                    ]
                ]
            ]
        ];
    }
}
