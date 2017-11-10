<?php
declare(strict_types=1);
namespace VC4A\Test\Model;

use VC4A\Repository\RepositoryInterface;
use PHPUnit\Framework\TestCase;
use VC4A\Model\DocumentsModel;
use PDOException;

class DocumentsModelTest extends TestCase
{
    /**
     * @var DocumentsModel
     */
    private $documentsModel;

    /**
     * @var RepositoryInterface
     */
    private $repository;

    public function setUp()
    {
        $this->repository = $this
            ->getMockBuilder(RepositoryInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['create', 'all', 'getPreparedCreateQuery', 'getPreparedAllQuery'])
            ->getMock();

        $this->documentsModel = new DocumentsModel($this->repository);

        parent::setUp();
    }

    public function testCreateSucceeds()
    {
        $params =  [DocumentsModel::FILENAME => 'test_file.doc'];
        $expected = 1;

        $this->repository->expects($this->once())
            ->method('create')
            ->with($this->equalTo($params))
            ->will($this->returnValue(1));

        $actual = $this->documentsModel->create($params);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException PDOException
     * @expectedExceptionMessage error
     */
    public function testCreateFailsException()
    {
        $params =  [DocumentsModel::FILENAME => 'test_file.doc'];

        $this->repository->expects($this->once())
            ->method('create')
            ->with($this->equalTo($params))
            ->will($this->throwException(new PDOException('error')));

        $this->documentsModel->create($params);
    }

    public function testAllSucceeds()
    {
        $expected = include __DIR__ . '../../fixtures/documents.php';

        $this->repository->expects($this->once())
            ->method('all')
            ->will($this->returnValue($expected));

        $actual = $this->documentsModel->all();

        $this->assertEquals($expected, $actual);
    }

        /**
     * @expectedException PDOException
     * @expectedExceptionMessage error
     */
    public function testAllFailsException()
    {
        $params =  [DocumentsModel::FILENAME => 'test_file.doc'];

        $this->repository->expects($this->once())
            ->method('create')
            ->with($this->equalTo($params))
            ->will($this->throwException(new PDOException('error')));

        $this->documentsModel->create($params);
    }
}
