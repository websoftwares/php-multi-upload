<?php
declare(strict_types=1);
namespace VC4A\Repository;

use VC4A\Model\DocumentsModel;

class DocumentsRepository extends MySQLRepositoryAbstract
{
    const TABLE_NAME = 'documents';

    public function getTableName(): string
    {
        return self::TABLE_NAME;
    }

    public function getCreateColumnNames(): array
    {
        return [
            DocumentsModel::FILENAME
        ];
    }

    public function getAllColumnNames(): array
    {
        return [
            DocumentsModel::ID,
            DocumentsModel::FILENAME
        ];
    }
}
