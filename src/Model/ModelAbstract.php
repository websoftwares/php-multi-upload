<?php
declare(strict_types=1);
namespace VC4A\Model;

use VC4A\Repository\RepositoryInterface;

abstract class ModelAbstract implements ModelInterface
{
    /**
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * @param RepositoryInterface $repository
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $data
     * @return array
     */
    public function create(array $data): array
    {
        return $this->repository->create(
            $this->validate($data)
        );
    }

    /**
     * @param array $data
     * @return array
     */
    public function all(): array
    {
        return $this->repository->all();
    }
}
