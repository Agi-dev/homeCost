<?php
namespace app\controllers;

use app\components\MyController;
use Service\Business\Cost\CostInterface;
use Service\Business\Category\CategoryInterface;

/**
 * Class DashboardController
 * @package app\controllers
 */
class DashboardController extends MyController
{
    public function actionIndex($year = null)
    {
        /** @var CostInterface $costService */
        $costService = $this->getService('cost');

        $year = ($year ? $year : date('Y'));
        $listM = ['F', 'JAN.', 'FEV.', 'MAR.', 'AVR.', 'MAI', 'JUIN', 'JUIL.', 'AOUT', 'SEPT.', 'OCT.', 'NOV.', 'DEC.'];
        $data = $costService->getStat($year);
        foreach($data['total']['month'] as $i => $month){
            $data['header'][$i] = $listM[$i];
        }
        $data['year'] = $year;

        return $this->renderAction($data);
    }

    public function actionDetail()
    {
        $params = $this->getRequest()->getQueryParams();

        /** @var CostInterface $costService */
        $costService = $this->getService('cost');
        /** @var CategoryInterface $categService */
        $categService = $this->getService('category');
        $dateService = $this->getService('date');

        $listCosts = $costService->listByFilters($params);
        $categ = [];
        if (true === isset($params['category'])) {
            $categ = $categService->getById($params['category']);
        }

        return $this->renderAction(compact('listCosts', 'params', 'categ', 'dateService'));
    }

}