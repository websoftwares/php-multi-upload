<?php
declare(strict_types=1);

namespace VC4A\Repository;

use PDO;
use PDOException;

abstract class RepositoryAbstract implements RepositoryInterface
{
    /**
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @throws PDOException
     * @return array
     */
    public function all(): array
    {
        $sql = "SELECT "
            . implode(', ', $this->getAllColumnNames())
            . " FROM " . $this->getTableName();

        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @throws PDOException
     * @param array $data
     * @return array
     */
    public function create(array $data): array
    {

        $tableName = $this->getTableName();
        $columnNames = $this->getCreateColumnNames();
        $dataToInsert = [];
        array_push($dataToInsert, ...array_values($data));

        $rowPlaces = '(' . implode(', ', array_fill(0, count($columnNames), '?')) . ')';
        $allPlaces = implode(', ', array_fill(0, count($data), $rowPlaces));

        $sql = "INSERT INTO $tableName (" . implode(', ', $columnNames) .
            ") VALUES " . $allPlaces;

        $this->pdo->beginTransaction();
        $statement = $this->pdo->prepare($sql);
        $statement->execute($dataToInsert);

        $this->pdo->commit();

        return $data;
    }
}
