<?php

namespace api\routing;

use OpenApi\Attributes\Info;
use palax\yii2core\util\FileHelper;
use Yii;

#[Info(version: '1.0', title: 'Api Дома-скрипко')]
final class Router
{
    public function compile(): array
    {
        $filePaths = FileHelper::listAllFiles(Yii::getAlias('@api/routing/routes'));

        $output = [];
        foreach ($filePaths as $filepath) {
            require $filepath;

            $className = $this->getClassName($filepath);

            if (!$className || $className === RouteInterface::class || !is_a($className, RouteInterface::class, true)) {
                continue;
            }

            $object = new $className;
            $output += $object->getRoute();
        }

        return $output;
    }

    private function getClassName(string $filepath): ?string
    {
        $lines = explode(PHP_EOL, file_get_contents($filepath));
        foreach ($lines as $line) {
            if (str_starts_with($line, 'namespace')) {
                $namespace = trim(str_replace(['namespace', ';'], '', $line));
                $filename = pathinfo($filepath, PATHINFO_FILENAME);

                return implode('\\', [$namespace, $filename]);
            }
        }

        return null;
    }
}
