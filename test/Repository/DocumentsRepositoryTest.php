<?php
declare(strict_types=1);
namespace VC4A\Test\Repository;

use VC4A\Repository\DocumentsRepository;
use PHPUnit\Framework\TestCase;
use VC4A\Test\MockPdo;
use PDOStatement;
use PDO;
use PDOException;

/**
 * Test cases for the DocumentsRepository
 * handling atleast 1 success case and 1 failure case for each class method.
 */
class DocumentsRepositoryTest extends TestCase
{
    const FILE_NAME_KEY = 'filename';
    const ID_KEY = 'id';

    /**
     * @var DocumentsRepository
     */
    private $documentsRepository;

    /**
     * @var MockPdo
     */
    private $pdo;

    public function setUp()
    {

        $this->pdo = $this->getMockBuilder(MockPdo::class)
            ->disableOriginalConstructor()
            ->setMethods(['prepare','lastInsertId', 'beginTransaction', 'commit'])
            ->getMock();
        $this->documentsRepository = new DocumentsRepository($this->pdo);

        parent::setUp();
    }

    /**
     * @dataProvider documentsProvider
     * @param array $expected
     * @return void
     */
    public function testAllSucceeds(array $expected)
    {
        $sql = 'SELECT id, filename FROM documents';

        $statementMock = $this
            ->getMockBuilder(PDOStatement::class)
            ->disableOriginalConstructor()
            ->setMethods(['execute', 'fetchAll'])
            ->getMock();

        $statementMock->expects($this->once())->method('execute')
            ->will($this->returnValue(true));

        $statementMock->expects($this->once())->method('fetchAll')
            ->with($this->equalTo(PDO::FETCH_ASSOC))
            ->will($this->returnValue($expected));

        $this->pdo->expects($this->once())->method('prepare')
            ->with($this->equalTo($sql))
            ->will($this->returnValue($statementMock));

        $actual = $this->documentsRepository->all();
        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException PDOException
     * @expectedExceptionMessage error
     */
    public function testAllFailsException()
    {
        $sql = 'SELECT id, filename FROM documents';

        $statementMock = $this
            ->getMockBuilder(PDOStatement::class)
            ->disableOriginalConstructor()
            ->setMethods(['execute', 'fetchAll'])
            ->getMock();

        $this->pdo->expects($this->once())->method('prepare')
            ->with($this->equalTo($sql))
            ->will($this->throwException(new PDOException('error')));

        $this->documentsRepository->all();
    }

    /**
     * @return void
     */
    public function testCreateSucceeds()
    {
        $sql = 'INSERT INTO documents (filename) VALUES (?), (?)';
        $expected = $this->getFixture();

        $statementMock = $this
            ->getMockBuilder(PDOStatement::class)
            ->disableOriginalConstructor()
            ->setMethods(['execute'])
            ->getMock();

        $statementMock->expects($this->once())->method('execute')
            ->with($this->equalTo($expected))
            ->will($this->returnValue(true));

        $this->pdo->expects($this->once())->method('prepare')
            ->with($this->equalTo($sql))
            ->will($this->returnValue($statementMock));

        $actual = $this->documentsRepository->create($expected);
        $this->assertEquals($expected, $actual);
    }

        /**
     * @expectedException PDOException
     * @expectedExceptionMessage error
     */
    public function testCreateFailsException()
    {
        $sql = 'INSERT INTO documents (filename) VALUES (?), (?)';
        $params = $this->getFixture();

        $statementMock = $this
            ->getMockBuilder(PDOStatement::class)
            ->disableOriginalConstructor()
            ->setMethods(['execute'])
            ->getMock();

        $this->pdo->expects($this->once())->method('prepare')
            ->with($this->equalTo($sql))
            ->will($this->throwException(new PDOException('error')));

        $this->documentsRepository->create($params);
    }

    /**
     * @return array
     */
    public function documentsProvider(): array
    {
        $fixture = $this->getFixture();
        return [$fixture];
    }

    private function getFixture(): array
    {
        return include __DIR__  . '../../fixtures/documents.php';
    }
}
