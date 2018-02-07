<?php

namespace components\fileManager\controllers;

use components\fileManager\models\Directory;
use components\fileManager\SimpleFilemanagerModule;
use yii\data\ArrayDataProvider;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

/**
 * Class DefaultController
 * @package components\fileManager\controllers
 * @property SimpleFilemanagerModule $module
 */
class DefaultController extends Controller
{
    /**
     * @param null $path
     *
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionIndex($path = null)
    {
        if (strstr($path, '../')) {
            throw new BadRequestHttpException();
        }

        $directory = Directory::createByPath($path);

        return $this->render('index', [
            'directory' => $directory,
            'dataProvider' => new ArrayDataProvider(['allModels' => $directory->list])
        ]);
    }
}