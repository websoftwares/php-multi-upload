<?php
declare(strict_types=1);
namespace VC4A\Model;

interface ModelInterface
{
    /**
     * @param array $data
     * @return int
     */
    public function create(array $data): int;

    /**
     * @return array
     */
    public function all(): array;

    /**
     * @return bool
     */
    public function validate(): bool;
}
