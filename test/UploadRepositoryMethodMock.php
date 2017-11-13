<?php
declare(strict_types=1);
namespace VC4A\Test;

use VC4A\Repository\UploadRepository;

class UploadRepositoryMethodMock extends UploadRepository
{
    /**
     * @see http://php.net/manual/en/features.file-upload.post-method.php
     * Mocking php build in function move_uploaded_file
     * by wrapping it in another method that we can override here.
     *
     * @param string $from
     * @param string $to
     * @return bool
     */
    protected function moveUploadedFile(string $from, string $to): bool
    {
        return true;
    }
}
