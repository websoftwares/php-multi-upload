<?php
declare(strict_types=1);
namespace VC4A\Model;

interface ModelInterface
{
    /**
     * @param array $data
     * @return int
     */
    public function create(array $data): array;

    /**
     * @return array
     */
    public function all(): array;

    /**
     * @return array
     */
    public function validate(array $data): array;

    /**
     * @param array $data
     * @return array
     */
    public function sanitize(array $data): array;
}
