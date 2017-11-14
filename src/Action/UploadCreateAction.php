<?php
declare(strict_types=1);
namespace VC4A\Action;

use VC4A\Model\UploadModel;
use VC4A\Model\DocumentsModel;

class UploadCreateAction
{
    /**
     * @var UploadModel
     */
    private $uploadModel;

    /**
     * @var DocumentsModel
     */
    private $documentsModel;

    /**

     * @param UploadModel $uploadModel
     * @param DocumentsModel $documentsModel
     */
    public function __construct(UploadModel $uploadModel, DocumentsModel $documentsModel)
    {
        $this->uploadModel = $uploadModel;
        $this->documentsModel = $documentsModel;
    }

    /**
     * @param array $files
     * @return string
     */
    public function __invoke(array $files): string
    {
        try {
            return json_encode($this->documentsModel->create(
                $this->uploadModel->create($files)
            ));
        } catch (Exception $exception) {
            return json_encode([
                'error' => $exception->getMessage()
            ]);
        }
    }
}
