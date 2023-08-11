<?php

namespace api\services;

use palax\core\result\Result;
use palax\yii2core\file\service\FileData;
use palax\yii2core\file\service\UploadServiceInterface;
use Yii;

final class UploadService implements UploadServiceInterface
{

    public function upload(FileData $fileData): Result
    {
        $ext = pathinfo($fileData->getName(), PATHINFO_EXTENSION);
        $fileName = date('dmy-His-') . md5(rand()) . "." . $ext;
        $pathInMedia = "/temp/files";
        $url = "/media$pathInMedia/$fileName";
        $path = Yii::getAlias('@media') . $pathInMedia;
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $path .= "/$fileName";

        $success = move_uploaded_file($fileData->getPath(), $path);

        if (!$success) {
            return Result::critical("Невозможно загрузить файл");
        }

        return Result::success(['url' => $url]);
    }
}