<?php
declare(strict_types=1);
namespace VC4A\Repository;

interface MySQLRepositoryInterface extends RepositoryInterface
{
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
