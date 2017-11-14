<?php
declare(strict_types=1);
namespace VC4A\Repository;

use Exception;

class UploadRepository implements RepositoryInterface
{
    const UPLOAD_ERROR_MESSAGE = 'Can not upload file, context: %s';
    const UPLOADS_DIR = __DIR__ . '/../../uploads/';

    /**
     * @param array $data
     * @return array
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

    public function all(): array
    {
        throw new Exception('Method not implemented');
    }
}
