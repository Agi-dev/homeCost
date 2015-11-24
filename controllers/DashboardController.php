<?php
namespace app\controllers;
use app\components\MyController;
use Service\Business\Cost\CostInterface;

/**
 * Class DashboardController
 * @package app\controllers
 */
class DashboardController extends MyController
{
    public function actionIndex()
    {
        /** @var CostInterface $costService */
        $costService = $this->getService('cost');
        $listStatByCategory = $costService->listStatByCategory();
        $this->renderAction();
    }

}