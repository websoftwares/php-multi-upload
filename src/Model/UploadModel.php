<?php
declare(strict_types=1);
namespace VC4A\Model;

use InvalidArgumentException;
use VC4A\Model\DocumentsModel;

class UploadModel extends ModelAbstract
{
    const FILES_KEY = 'files';
    const FILES_ERROR_KEY = 'error';
    const FILES_TEMP_NAME_KEY = 'tmp_name';
    const FILES_NAME_KEY = 'name';
    const UPLOADS_DIR = __DIR__ . '/../../uploads/';

    const UPLOAD_ERR_OK_MESSAGE = 'There is no error, the file uploaded with success';
    const UPLOAD_ERR_INI_SIZE_MESSAGE = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
    const UPLOAD_ERR_FORM_SIZE_MESSAGE = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified';
    const UPLOAD_ERR_PARTIAL_MESSAGE = 'The uploaded file was only partially uploaded';
    const UPLOAD_ERR_NO_FILE_MESSAGE = 'No file was uploaded';
    const UPLOAD_ERR_NO_TMP_DIR_MESSAGE = 'Missing a temporary folder';
    const UPLOAD_ERR_CANT_WRITE_MESSSAGE =  'Failed to write file to disk';
    const UPLOAD_ERR_EXTENSION_MESSAGE = 'A PHP extension stopped the file upload';
    const UPLOAD_UNKNOWN_ERROR_MESSAGE = 'Unknown error';

    /**
     * Pass in the $_FILES global as $data argument.
     *
     * @param array $data
     * @return array
     */
    public function create(array $data): array
    {
        $files = $data[self::FILES_KEY];
        $sanitizedFiles = $this->validate($files);
        $filesCreated = [];

        foreach ($sanitizedFiles as $file) {
            $filesCreated[] = [DocumentsModel::FILENAME => $this->repository->create($file)[1]];
        }

        return $filesCreated;
    }

    /**
     * @return array
     */
    public function validate(array $data): array
    {

        $data = $this->sanitize($data);

        if (empty($data)) {
            throw new InvalidArgumentException('Empty: ' . json_encode($data));
        }

        return $data;
    }

    /**
     * @param array $data
     * @return array
     */
    public function sanitize(array $data) : array
    {
        $sanitizedData = [];

        foreach ($data[self::FILES_ERROR_KEY] as $key => $error) {
            $errorMessage = $this->fetchUploadErrorInfo();

            if ($error === UPLOAD_ERR_OK) {
                $file = [];
                $file[] = $data[self::FILES_TEMP_NAME_KEY][$key];
                $file[] = self::UPLOADS_DIR . basename($data[self::FILES_NAME_KEY][$key]);

                $sanitizedData[] = $file;

            } elseif (isset($errorMessage[$error])) {
                throw new InvalidArgumentException($errorMessage[$error]);
            } else {
                throw new InvalidArgumentException(self::UPLOAD_UNKNOWN_ERROR_MESSAGE);
            }
        }

        return $sanitizedData;
    }

    public function fetchUploadErrorInfo()
    {
        return [
            UPLOAD_ERR_OK => self::UPLOAD_ERR_OK_MESSAGE,
            UPLOAD_ERR_INI_SIZE => self::UPLOAD_ERR_INI_SIZE_MESSAGE,
            UPLOAD_ERR_FORM_SIZE => self::UPLOAD_ERR_FORM_SIZE_MESSAGE,
            UPLOAD_ERR_PARTIAL => self::UPLOAD_ERR_PARTIAL_MESSAGE ,
            UPLOAD_ERR_NO_FILE => self::UPLOAD_ERR_NO_FILE_MESSAGE,
            UPLOAD_ERR_NO_TMP_DIR => self::UPLOAD_ERR_NO_TMP_DIR_MESSAGE,
            UPLOAD_ERR_CANT_WRITE => self::UPLOAD_ERR_CANT_WRITE_MESSSAGE,
            UPLOAD_ERR_EXTENSION => self::UPLOAD_ERR_EXTENSION_MESSAGE,
        ];
    }
}
