<?php

namespace app\controllers;

use Yii;
use app\components\MyController;

class SiteController extends MyController
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionUpload()
    {
        $this->checkIsAjaxRequest();
        $this->checkIsPostRequest();
        $files = $this->getFilesData();

        $uploadDir = yii::$app->basePath . '/uploads/';
        $uploadFile = $uploadDir . basename($files['file_data']['name']);

        if (true === move_uploaded_file($files['file_data']['tmp_name'], $uploadFile)) {
            $result = array('success' => true, 'message' => "Le fichier est valide, et a été téléchargé avec succès.");
        } else {
            $result = array('success' => false, 'message' => "Attaque potentielle par téléchargement de fichiers.");
        }

        return $this->renderJson($result);
    }
}
