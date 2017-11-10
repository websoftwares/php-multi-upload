<?php
declare(strict_types=1);
namespace VC4A\Repository;

interface RepositoryInterface
{

    /**
     * @return array
     */
    public function all(): array;

    /**
     * @param array $data
     * @return int
     */
    public function create(array $data): array;

    /**
     * @return string
     */
    public function getTableName(): string;

    /**
     * @return array
     */
    public function getCreateColumnNames(): array;

    /**
     * @return array
     */
    public function getAllColumnNames(): array;
}
