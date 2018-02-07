<?php

namespace app\modules\fileManager\controllers;

use app\modules\fileManager\models\Directory;
use app\modules\fileManager\SimpleFilemanagerModule;
use Yii;
use yii\data\ArrayDataProvider;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

/**
 * Class DefaultController
 * @package app\modules\fileManager\controllers
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

        try {
            $directory = Directory::createByPath($path);
            $list = $directory->list;
        } catch (\Exception $e) {
            yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(yii::$app->request->referrer);
        }

        return $this->render('index', [
            'directory' => $directory,
            'dataProvider' => new ArrayDataProvider(
                [
                    'allModels' => $list,
                    'sort' => [
                        'attributes' => ['name', 'time'],
                    ],
                ]
            )
        ]);
    }
}