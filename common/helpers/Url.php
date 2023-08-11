<?php

namespace common\helpers;

use Yii;

class Url extends \yii\helpers\Url
{
    /**
     * @param string $path
     * @param null|string $preset
     * @param bool|string $scheme
     * @return string
     */
    public static function toImage($path, $preset = null, $scheme = false)
    {
        if (empty($path)) {
            return null;
        }

        $url = '/media/';

        if (!empty($preset)) {
            $pathinfo = pathinfo($path);

            $path = '';

            if (!empty($pathinfo['dirname'])) {
                $path .= $pathinfo['dirname'] . '/';
            }

            $path .= $preset . '_' . $pathinfo['basename'];
        }

        $url .= ltrim($path, '/\\');

        return static::to($url, $scheme);
    }

    public static function getFullUrlFromMediaFile(string $url): string
    {
        $config = require Yii::getAlias('@common/config/params.php');

        return $config['http']['scheme'] . "://" . $config['http']['domain'] . ((isset($config['http']['port'])) ? ':' . $config['http']['port'] : '') . $url;
    }

    public static function getFileNameFromUri(string $uri): string
    {
        return basename($uri);
    }
}