<?php
declare(strict_types=1);
namespace VC4A\Repository;

class DocumentsRepository extends RepositoryAbstract
{
    /**
     * @return string
     */
    public function getPreparedCreateQuery(): string
    {
        return "INSERT INTO `vc4a_upload`.`documents` (`filename`) VALUES (?)";
    }

    /**
     * @return string
     */
    public function getPreparedAllQuery(): string
    {
        return "SELECT id, filename FROM documents ORDER by datestamp ASC";
    }
}
