<?php

namespace common\helpers;

class FileHelper extends \yii\helpers\FileHelper
{
    /**
     * @param string $path
     * @param string $basePath
     * @return bool|string
     */
    public static function relativePath($path, $basePath)
    {
        $relativePath = $path;

        $basePath = rtrim($basePath, '\\/') . DIRECTORY_SEPARATOR;

        if (str_starts_with($path, $basePath)) {
            $relativePath = substr($path, strlen($basePath));
        }

        return $relativePath;
    }
}
