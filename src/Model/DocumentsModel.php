<?php
declare(strict_types=1);
namespace VC4A\Model;

class DocumentsModel extends ModelAbstract
{
    const ID = 'id';
    const FILENAME = 'filename';

    /**
     * @return bool
     */
    public function validate(): bool
    {
        return true;
    }
}
