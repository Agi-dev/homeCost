<?php

namespace app\controllers;

use Service\Business\Category\CategoryInterface;
use Yii;
use app\components\MyController;
use Service\Business\Bank\BankInterface;
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

        if (true !== move_uploaded_file($files['file_data']['tmp_name'], $uploadFile)) {
            return $this->renderJson(
                array('success' => false, 'message' => "Attaque potentielle par téléchargement de fichiers.")
            );
        }

        /** @var BankInterface $bankService */
        $bankService = $this->getService('bank');
        try{
            $nb = $bankService->import($uploadFile);
            $result = array('success' => true, 'message' => $nb . ' nouvelles opérations insérées en base.');
        } catch (\Exception $e) {
            $result = array('success' => false, 'message' => $e->getMessage());
        }

        return $this->renderJson($result);
    }

    public function actionProcess()
    {
        /** @var BankInterface $bankService */
        $bankService = $this->getService('bank');
        $dateService = $this->getService('date');
        /** @var CategoryInterface $categoryService */
        $categoryService = $this->getService('category');
        $listCateg = $categoryService->listAll();
        $data = $bankService->listNew();
        return $this->renderAction(compact('data', 'dateService', 'listCateg'));
    }

    public function actionIgnore()
    {
        $this->checkIsAjaxRequest();
        $this->checkIsPostRequest();
        $postedData = $this->getPostedData();

        /** @var BankInterface $bankService */
        $bankService = $this->getService('bank');
        $bankService->ignoreById($postedData['id']);
        return $this->renderJson(array('success' => true));
    }

    public function actionKeep()
    {
        $this->checkIsAjaxRequest();
        $this->checkIsPostRequest();
        $postedData = $this->getPostedData();

        /** @var BankInterface $bankService */
        $bankService = $this->getService('bank');
        $bankService->keepById($postedData['id']);
        return $this->renderJson(array('success' => true));
    }

    public function actionTag()
    {
        $this->checkIsAjaxRequest();
        $this->checkIsPostRequest();
        $postedData = $this->getPostedData();

        /** @var BankInterface $bankService */
        $bankService = $this->getService('bank');
        $bankService->tagById($postedData['id'], $postedData['tagId']);
        return $this->renderJson(array('success' => true));
    }

    public function actionUntag()
    {
        $this->checkIsAjaxRequest();
        $this->checkIsPostRequest();
        $postedData = $this->getPostedData();

        /** @var BankInterface $bankService */
        $bankService = $this->getService('bank');
        $bankService->untagById($postedData['id']);
        return $this->renderJson(array('success' => true));
    }
}
