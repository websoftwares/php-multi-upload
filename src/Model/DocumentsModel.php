<?php
declare(strict_types=1);
namespace VC4A\Model;

use InvalidArgumentException;

class DocumentsModel extends ModelAbstract
{
    const ID = 'id';
    const FILENAME = 'filename';

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
        $allowed = [
            self::ID, self::FILENAME
        ];

        $data = array_map(
            function ($element) use ($allowed) {
                  return array_intersect_key($element, array_flip($allowed));
            },
            $data
        );

        $data = array_map('array_filter', $data);
        $data = array_filter($data);

        return $data;
    }

    private function codeToMessage($code)
    {
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
                $message = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = "The uploaded file was only partially uploaded";
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = "No file was uploaded";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = "Missing a temporary folder";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = "Failed to write file to disk";
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = "File upload stopped by extension";
                break;

            default:
                $message = "Unknown upload error";
                break;
        }
        return $message;
    }
}
