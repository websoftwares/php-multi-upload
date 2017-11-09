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
    public function create(array $data): int;

    /**
     * @return string
     */
    public function getPreparedCreateQuery(): string;

    /**
     * @return string
     */
    public function getPreparedAllQuery(): string;
}
