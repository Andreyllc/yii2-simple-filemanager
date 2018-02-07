<?php

namespace components\fileManager;

use yii\base\Module;

/**
 * Class SimpleFilemanagerModule
 * @package components\fileManager
 * @property string $fullUploadPath
 */
class SimpleFilemanagerModule extends Module
{
    /** @var string  */
    public $controllerNamespace = 'components\fileManager\controllers';
    /** @var string  */
    public $uploadPath = '@webroot' . DIRECTORY_SEPARATOR . UPLOAD_DIR;
    /** @var string  */
    public $urlPath = '@web/' . UPLOAD_DIR;
    /** @var array  */
    public $icons = [];
    /** @var array  */
    public $defaultIcons = [
        'dir' => 'fa-folder-o',
        'file' => 'fa-file-o',
        'image/gif' => 'fa-file-image-o',
        'image/tiff' => 'fa-file-image-o',
        'image/png' => 'fa-file-image-o',
        'image/jpeg' => 'fa-file-image-o',
        'application/pdf' => 'fa-file-pdf-o',
        'application/zip' => 'fa-file-archive-o',
        'application/x-gzip' => 'fa-file-archive-o',
        'text/plain' => 'fa-file-text-o',
    ];

    /** @var string */
    private $_uploadPath;

    public function init()
    {
        parent::init();

        $this->_checkPath();

        $this->icons = array_merge($this->defaultIcons, $this->icons);

        if (!isset(\Yii::$app->i18n->translations['filemanager'])) {
            \Yii::$app->i18n->translations['filemanager'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'basePath' => $this->basePath . DIRECTORY_SEPARATOR . 'messages',
                'fileMap' => ['filemanager' => 'filemanager.php'],
            ];
        }
    }

    public function getFullUploadPath()
    {
        if (!isset($this->_uploadPath)) {
            $this->_uploadPath = \Yii::getAlias($this->uploadPath);
        }

        return $this->_uploadPath;
    }

    private function _checkPath()
    {
        if (!is_dir($this->fullUploadPath)) {
            mkdir($this->fullUploadPath, 0755, true);
        }
    }
}