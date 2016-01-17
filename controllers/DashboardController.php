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
        /** @var CategoryInterface $categService */
        $categService = $this->getService('category');

        $year = ($year ? $year : date('Y'));
        $listStatByCategory = $costService->listStatByCategory($year);
        $listCateg = $categService->listAll();

        $data = [];
        $listM = ['F', 'JAN.', 'FEV.', 'MAR.', 'AVR.', 'MAI', 'JUIN', 'JUIL.', 'AOUT', 'SEPT.', 'OCT.', 'NOV.', 'DEC.'];
        $header = [];
        $total = ['previous' => 0, 'year' => 0, 'month' => []];
        $i = 1;
        foreach($listStatByCategory['month'] as $i => $month){
            $header[$i] = $listM[$i];
            $total[$i] = 0;
        }
        $currentMonth = $i;
        $lastYearAmount = 0;
        foreach ($listCateg as $categ) {
            if (false === empty($listStatByCategory['year']['previous'])) {
                $lastYearAmount = floatval($listStatByCategory['year']['previous'][$categ['label']]) / 12;
            }

            $yearAmount = floatval($listStatByCategory['year']['current'][$categ['label']]) / $currentMonth;
            $total['previous'] += $lastYearAmount;
            $total['year'] += $yearAmount;
            $row = [
                'categId'    => $categ['id'],
                'label'      => $categ['label'],
                'previous'   => number_format($lastYearAmount, 2),
                'current'    => number_format($yearAmount, 2),
                'yearAmount' => $yearAmount,
                'month'      => []
            ];
            foreach($listStatByCategory['month'] as $i => $month){
                $row['month'][$i] = $listStatByCategory['month'][$i][$categ['label']];
                $total['month'][$i] += floatval($listStatByCategory['month'][$i][$categ['label']]);
            }

            $data[] = $row;
        }

        return $this->renderAction(compact('header', 'data', 'total', 'year'));
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