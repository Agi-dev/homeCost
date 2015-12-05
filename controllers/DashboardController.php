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
    public function actionIndex()
    {
        /** @var CostInterface $costService */
        $costService = $this->getService('cost');
        /** @var CategoryInterface $categService */
        $categService = $this->getService('category');
        $listStatByCategory = $costService->listStatByCategory();
        $listCateg = $categService->listAll();

        $data = [];
        $currentMonth = intval(date('m'));
        $listM = ['F', 'JAN.', 'FEV.', 'MAR.', 'AVR.', 'MAI', 'JUIN', 'JUIL.', 'AOUT', 'SEPT.', 'OCT.', 'NOV.', 'DEC.'];
        $header = [];
        $total = ['year' => 0];
        for ($i = 1; $i <= $currentMonth; $i++) {
            $header[] = $listM[$i];
            $total[$i] = 0;
        }

        foreach ($listCateg as $categ) {
            $yearAmount = floatval($listStatByCategory['year']['current'][$categ['label']]) / $currentMonth;
            $total['year'] += $yearAmount;
            $row = ['label' => $categ['label'], 'current' => number_format($yearAmount, 2), 'yearAmount' => $yearAmount];
            for ($i = 1; $i <= $currentMonth; $i++) {
                $row['month'][$i] = $listStatByCategory['month'][$i][$categ['label']];
                $total['month'][$i] += floatval($listStatByCategory['month'][$i][$categ['label']]);
            }

            $data[] = $row;
        }

        return $this->renderAction(compact('header', 'data', 'total'));
    }

}