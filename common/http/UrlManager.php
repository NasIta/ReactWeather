<?php

namespace common\http;

use Yii;
use yii\web\UrlManager as BaseUrlManager;
use yii\web\UrlNormalizer;

abstract class UrlManager extends BaseUrlManager
{
    public $enablePrettyUrl = true;
    public $enableStrictParsing = true;
    public $showScriptName = false;
    public $cache = false;
    public $normalizer = [
        'class' => UrlNormalizer::class,
        'action' => 301,
        'collapseSlashes' => false,
        'normalizeTrailingSlash' => true
    ];

    public function __construct($config = [])
    {
        parent::__construct([
                'hostInfo' => $this->constructHostInfo()
            ] + $config);
    }

    public function constructHostInfo(): string
    {
        $hostInfo = Yii::$app->params['http']['scheme'] . '://' . Yii::$app->params['http']['domain'];
        if ($port = Yii::$app->params['http']['port']) {
            $hostInfo .= ':' . $port;
        }

        return $hostInfo;
    }
}
