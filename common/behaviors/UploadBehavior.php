<?php

namespace common\behaviors;

use Imagine\Exception\Exception;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Image\ManipulatorInterface;
use Imagine\Image\Point;
use Yii;
use yii\console\Application;
use yii\helpers\FileHelper;
use yii\imagine\Image;

/**
 * Class UploadBehavior
 * @package common\behaviors
 * Uploading file behavior. Extends vova07 UploadBehavior.
 * Usage:
 * ```
 * ...
 * 'uploadBehavior' => [
 *     'class' => UploadBehavior::className(),
 *     'attributes' => [
 *         'preview_url' => [
 *             'path' => '@app/web/path',
 *             'tempPath' => '@app/tmp/path',
 *             'url' => '/path/to/file'
 *         ],
 *         'image_url' => [
 *             'path' => '@app/web/path',
 *             'tempPath' => '@app/tmp/path',
 *             'url' => '/path/to/file'
 *         ]
 *     ]
 * ]
 * ...
 * ```
 */
class UploadBehavior extends \vova07\fileapi\behaviors\UploadBehavior
{
    /**
     * @var array|null
     * File MUST be described relative to "www" directory!
     * example
     * [
     *  'file' => 'static/images/watermark.png',
     *  'position' => [200,100]
     * ]
     * OR
     * [
     *  'file' => 'static/images/watermark.png',
     *  'position' => 'top'
     * ]
     * position can be array [x,y] coordinates or
     * string with one of available position
     * top, top-left, top-right, bottom, bottom-left, bottom-right, left, right, center, repeat
     */
    public $watermark = null;
    /**
     * @var callable $generateBaseNameCallback
     * function ($behavior): string
     */
    public $generateBaseNameCallback;
    /**
     * Imagine default options
     * @var array
     */
    protected $options = [
        'resolution-units' => ImageInterface::RESOLUTION_PIXELSPERINCH,
        'resolution-x' => 72,
        'resolution-y' => 72,
        'jpeg_quality' => 100,
        'quality' => 100,
        'png_compression_level' => 0
    ];
    /**
     * Default resize method
     * @var string
     */
    protected $defaultResize = 'adaptiveResizeFromTop';
    /**
     * Available methods
     * @var array
     */
    protected $availableResizeMethods = [
        'resize', 'adaptiveResize', 'adaptiveResizeFromTop'
    ];

    /**
     * @param string $attribute Attribute name
     * @param null $size
     * @return null|string Full attribute URL
     */
    public function urlAttribute($attribute, $size = null)
    {
        if (isset($this->attributes[$attribute]) && $this->owner->$attribute) {
            $url = str_replace('\\', '/', $this->owner->$attribute);
            if (isset($size)) {
                $urlParts = explode('/', $url);
                $urlParts[count($urlParts) - 1] = $size . '_' . $urlParts[count($urlParts) - 1];
                $url = implode('/', $urlParts);
            }

            return $this->attributes[$attribute]['url'] . $url;
        }

        return null;
    }

    /**
     * Function will be called before deleting the record.
     */
    public function beforeDelete()
    {
        if ($this->unlinkOnDelete) {
            foreach ($this->attributes as $attribute => $config) {
                if ($this->owner->$attribute && !empty($config['sizes'])) {
                    $pathinfo = pathinfo($this->owner->$attribute);

                    foreach ($config['sizes'] as $presetName => $presetConfig) {
                        $file = $this->path($attribute) . $pathinfo['dirname'] . DIRECTORY_SEPARATOR . $pathinfo['filename'] . '_' . $presetName . '.' . $pathinfo['extension'];

                        if (is_file($file)) {
                            FileHelper::unlink($file);
                        }
                    }
                }
            }
        }

        return parent::beforeDelete();
    }

    /**
     * Save model attribute file.
     * @param string $attribute Attribute name
     * @param bool $insert `true` on insert record
     */
    protected function saveFile($attribute, $insert = true)
    {
        if (empty($this->owner->$attribute)) {
            if ($insert !== true) {
                $this->deleteFile($this->oldFile($attribute));
            }
        } else {
            $tempFile = $this->tempFile($attribute);
            if (is_file($tempFile) &&
                FileHelper::createDirectory($this->path($attribute) . $this->pathPrefix($this->attributes[$attribute]['pathPrefix']))
            ) {
                $this->owner->$attribute = $tempFile;
                if ($this->processFile($attribute, $insert)) {
                    $this->triggerEventAfterUpload();
                    @unlink($tempFile);
                } else {
                    unset($this->owner->$attribute);
                }
            } else if (Yii::$app instanceof Application &&
                FileHelper::createDirectory($this->path($attribute) . $this->pathPrefix($this->attributes[$attribute]['pathPrefix']))
            ) {
                if (!$this->processFile($attribute, $insert)) {
                    unset($this->owner->$attribute);
                }
            } else if ($insert === true) {
                unset($this->owner->$attribute);
            } else {
                $this->owner->setAttribute($attribute, $this->owner->getOldAttribute($attribute));
            }
        }
    }

    /**
     * @param mixed $pathPrefix
     * @return string
     */
    protected function pathPrefix($pathPrefix)
    {
        if (is_callable($pathPrefix)) {
            return call_user_func($pathPrefix, $this);
        } else {
            return $pathPrefix;
        }
    }

    /**
     * @param $attribute
     * @param $insert
     * @return bool
     */
    protected function processFile($attribute, $insert)
    {
        if ($insert === false && $this->unlinkOnSave === true && $this->owner->getOldAttribute($attribute)) {
            $this->deleteFile($this->oldFile($attribute));
        }

        $ext = pathinfo($this->owner->$attribute, PATHINFO_EXTENSION);
        $name = pathinfo($this->owner->$attribute, PATHINFO_FILENAME);

        if (!isset($this->attributes[$attribute]['MD5Name']) || $this->attributes[$attribute]['MD5Name']) {
            $name = uniqid();
        }

        if (isset($this->attributes[$attribute]['noProcessing']) && is_file($this->owner->$attribute)) {
            //Если без обработки - то просто копируем файл из временной директории
            $tempFile = $this->owner->$attribute;
            $name = $this->pathPrefix($this->attributes[$attribute]['pathPrefix']) . $name . '.' . $ext;
            $this->owner->$attribute = $name;
            //Save file with new name
            $availableName = $this->generateName($attribute);
            $dest = $this->path($attribute) . $availableName;
            if (!is_dir($dest)) {
                FileHelper::createDirectory(dirname($dest));
            }
            copy($tempFile, $dest);
            $this->owner->$attribute = $availableName;

            return true;
        }
        if ($name) {
            $fileContent = file_get_contents($this->owner->$attribute);
            //file creation
            try {
                $image = Image::getImagine()->load($fileContent);
            } catch (Exception $e) {
                $image = null;
            }
            if ($image) {
                $name = $this->pathPrefix($this->attributes[$attribute]['pathPrefix']) . $name . '.' . $ext;
                $this->owner->$attribute = $name;
                if (isset($this->attributes[$attribute]['sizes'])) {
                    //files minimization
                    $image = $this->resize($image, $attribute);
                }
                //Save file with new name
                $availableName = $this->generateName($attribute);
                $image->save($this->path($attribute) . $availableName);
                $this->owner->$attribute = $availableName;
            } else {
                return false;
            }
        } else {
            return false;
        }

        return true;
    }

    /**
     * @param $attribute
     * @param $prefix
     * @param $postfix
     * @return string
     */
    protected function generateName($attribute, $prefix = null, $postfix = null)
    {
        $name = $this->owner->$attribute;
        $dirName = dirname($name);
        $ext = pathinfo($name, PATHINFO_EXTENSION);
        $fileName = pathinfo($name, PATHINFO_FILENAME);

        if (is_callable($this->generateBaseNameCallback)) {
            $baseName = $dirName . '/' . ltrim(call_user_func($this->generateBaseNameCallback, $this), '\\/');
            $i = 0;
            $path = $this->path($attribute) . $baseName;
            while (file_exists($path)) {
                ++$i;
                $name = $baseName . '_' . $i . '.' . $ext;
                $path = $this->path($attribute) . $name;
            }
        } else {
            $count = '';
            $name = strtr("{dirname}/{prefix}{filename}{count}{postfix}.{ext}", [
                '{dirname}' => $dirName,
                '{prefix}' => isset($prefix) ? $prefix . '_' : '',
                '{filename}' => $fileName,
                '{count}' => $count,
                '{ext}' => $ext,
                '{postfix}' => isset($postfix) ? '_' . $postfix : '',
            ]);

            while (file_exists($this->path($attribute) . $name)) {
                ++$count;
                $name = strtr("{dirname}/{prefix}{filename}{count}{postfix}.{ext}", [
                    '{dirname}' => $dirName,
                    '{prefix}' => isset($prefix) ? $prefix . '_' : '',
                    '{filename}' => $fileName,
                    '{count}' => '_' . $count,
                    '{ext}' => $ext,
                    '{postfix}' => isset($postfix) ? '_' . $postfix : '',
                ]);
            }
        }

        return $name;
    }

    /**
     * @param ImageInterface $source
     * @param $attribute
     * @return ImageInterface
     * @throws Yii\base\Exception
     */
    protected function resize(ImageInterface $source, $attribute)
    {
        foreach ($this->attributes[$attribute]['sizes'] as $sizeName => $size) {
            $width = $size[0] ?? null;
            $height = $size[1] ?? null;
            if (!$width || !$height) {
                [$width, $height] = $this->imageScale($source, $width, $height);
            }

            $method = $size['method'] ?? $this->defaultResize;
            if (!in_array($method, $this->availableResizeMethods, true)) {
                throw new yii\base\Exception('Unknown resize method: ' . $method);
            }
            $options = $size['options'] ?? $this->options;
            $watermark = $size['watermark'] ?? $this->watermark;

            if (($width || $height) && $method) {
                $newSource = $this->generateThumbnail($source->copy(), $width, $height, $method);
                if ($watermark) {
                    $newSource = Image::watermark($newSource, $watermark);
                }
                $fileName = $this->path($attribute) . $this->generateName($attribute, null, $sizeName);
                $newSource->save($fileName, $options);
            }
        }

        if ($this->watermark) {
            $source = Image::watermark($source, $this->watermark);
        }

        return $source;
    }

    /**
     * @param $source
     * @param null $width
     * @param null $height
     * @return array
     */
    protected function imageScale(ImageInterface $source, $width = null, $height = null)
    {
        $size = $source->getSize();
        $ratio = $size->getWidth() / $size->getHeight();
        if ($width && !$height) {
            $height = $width / $ratio;
        } else if (!$width && $height) {
            $width = $height * $ratio;
        }

        return [(int)$width, (int)$height];
    }

    /**
     * @param ImageInterface $source
     * @param $width
     * @param $height
     * @param $method
     * @return ImageInterface
     */
    protected function generateThumbnail(ImageInterface $source, $width, $height, $method)
    {
        switch ($method) {
            case 'resize' :
            case 'adaptiveResize' :
                $image = Image::thumbnail($source, $width, $height, $this->getResizeMethod($method));
                break;
            default :
                $fromWidth = $source->getSize()->getWidth();
                $fromHeight = $source->getSize()->getHeight();
                $toWidth = $width;
                $toHeight = $height;

                $fromPercent = $fromWidth / $fromHeight;
                $toPercent = $toWidth / $toHeight;

                if ($toPercent >= $fromPercent) {
                    $resizeWidth = $toWidth;
                    $resizeHeight = round($toWidth / $fromWidth * $fromHeight);
                    $image = $source
                        ->resize(new Box($resizeWidth, $resizeHeight))
                        ->crop(new Point(0, 0), new Box($toWidth, $toHeight));
                } else {
                    $image = Image::thumbnail($source, $width, $height, $this->getResizeMethod($method));
                }
                break;
        }

        return $image;
    }

    /**
     * Return ManipulatorInterface like resize method
     * @param $method
     * @return mixed
     */
    private function getResizeMethod($method)
    {
        $resizeMethods = [
            'resize' => ManipulatorInterface::THUMBNAIL_INSET,
            'adaptiveResize' => ManipulatorInterface::THUMBNAIL_OUTBOUND,
            'adaptiveResizeFromTop' => ManipulatorInterface::THUMBNAIL_INSET,
        ];

        return $resizeMethods[$method];
    }
}
