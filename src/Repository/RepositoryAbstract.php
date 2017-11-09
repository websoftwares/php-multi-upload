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
        $statement = $this->pdo->prepare($this->getPreparedAllQuery());
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param array $data
     * @throws PDOException
     * @return int
     */
    public function create(array $data): int
    {
        $statement = $this->pdo->prepare($this->getPreparedCreateQuery());
        $statement->execute($data);
        return $this->pdo->lastInsertId();
    }
}
