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
}
