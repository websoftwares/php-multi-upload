<?php
declare(strict_types=1);
namespace VC4A\Repository;

use Exception;
use RuntimeException;

class UploadRepository implements RepositoryInterface
{
    const UPLOAD_ERROR_MESSAGE = 'Can not upload file, context: %s';
    const UPLOADS_DIR = __DIR__ . '/../../uploads/';

    /**
     * @param array $data
     * @return array
     * @throws Exception
     */
    public function create(array $data): array
    {
        if (!$this->moveUploadedFile(...$data)) {
            throw new Exception(sprintf(self::UPLOAD_ERROR_MESSAGE, json_encode($data)));
        }

        return $data;
    }

    /**
     * @param string $from
     * @param string $to
     * @return bool
     */
    protected function moveUploadedFile(string $from, string $to): bool
    {
        return move_uploaded_file($from, self::UPLOADS_DIR . basename($to));
    }

    /**
     * @return array
     * @throws RuntimeException
     */
    public function all(): array
    {
        throw new RuntimeException('Method not implemented');
    }
}
