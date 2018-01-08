<?php
declare(strict_types=1);
namespace VC4A\Action;

use Exception;
use VC4A\Model\DocumentsModel;

class DocumentsListAction
{
    /**
     * @var DocumentsModel
     */
    private $documentsModel;

    /**
     * @param DocumentsModel $documentsModel
     */
    public function __construct(DocumentsModel $documentsModel)
    {
        $this->documentsModel = $documentsModel;
    }

    /**
     * @return string
     */
    public function __invoke(): string
    {
        try {
            return json_encode($this->documentsModel->all());
        } catch (Exception $exception) {
            return json_encode([
                'error' => $exception->getMessage()
            ]);
        }
    }
}
