<?php
/**
 * This file is part of the Numeric Workshop Serval project
 *
 * (c) IncentiveOffice - 2014
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Service\Business\Cost;

use Serval\Base\Table\AbstractServiceTable;
use Service\Business\Category\CategoryInterface;

/**
 * Class Cost is a class to handle table cost operations.
 *
 * @method CategoryInterface    getCategoryService()
 */
class Cost extends AbstractServiceTable implements CostInterface
{
    /**
     * tablename in bdd
     * @var string
     */
    protected $tablename = 'cost';

    /**
     * @param $year
     *
     * @return array
     */
    public function listStatByCategory($year)
    {
        $currentYear = $year;
        $prevYear = $year - 1;

        return array(
            'year' => array(
                'previous' => $this->listStatByCategoryAndYear($prevYear),
                'current' => $this->listStatByCategoryAndYear($currentYear),
            ),
            'month' => $this->listStatByCategoryAndYearOrderedByMonth($currentYear)
        );
    }

    /**
     * @param $year
     *
     * @return array
     */
    public function listStatByCategoryAndYear($year)
    {
        $result = $this->fetchAll('listCategoryStatByYear', array(':year' => $year));
        $stat = [];
        foreach ($result as $row) {
            $stat[$row['category']] = $row['total'];
        }

        return $stat;
    }

    /**
     * @param $year
     *
     * @return array
     */
    public function listStatByCategoryAndYearOrderedByMonth($year)
    {
        $result = $this->fetchAll('listMonthCategoryStatByYear', array(':year' => $year));
        $stat = [];
        foreach ($result as $row) {
            $stat[$row['month']][$row['category']] = $row['total'];
        }

        return $stat;
    }

    /**
     * @param $filters
     *
     * @return mixed
     */
    public function listByFilters($filters)
    {
        // by month
        if (true === isset($filters['month'])) {

            if (true === isset($filters['category'])) {
                return $this->fetchAll(
                    'listByMonthAndCategoryId',
                    [':month' => $filters['month'], 'category_code' => $filters['category'], ':year' => $filters['year']]
                );
            }
            return $this->fetchAll('listByMonth', [':month' => $filters['month'], ':year' => $filters['year']]);
        }

        // by year
        if (true === isset($filters['category'])) {
            return $this->fetchAll(
                'listByYearAndCategoryId',
                [':year' => $filters['year'], 'category_code' => $filters['category']]
            );
        }
        return $this->fetchAll('listByYear', [':year' => $filters['year']]);

    }

    /**
     * @param $year
     *
     * @return array
     */
    public function getStat($year)
    {
        $listStatByCategory = $this->listStatByCategory($year);
        $listCateg = $this->getCategoryService()->listAll();

        $data = [];
        $total = ['previous' => 0, 'year' => 0, 'month' => []];
        $totalCateg = [];
        $nbDayMonth = ['-', '31', '28', '31', '30', '31', '30', '31', '31', '30', '31', '30', '31'];
        $i = 1;
        foreach($listStatByCategory['month'] as $i => $month){
            $total['month'][$i] = 0;
        }

        $currentDay = date('d');
        $currentMonth = $i;
        $currentYear = date('Y');
        $lastYearAmount = 0;
        foreach ($listCateg as $categ) {
            if (!$categ['show']) {
                continue;
            }
            if (false === empty($listStatByCategory['year']['previous'])) {
                $lastYearAmount = floatval($listStatByCategory['year']['previous'][$categ['label']] ?? 0) / 12;
            }

            $yearAmount = 0;
            $mainCateg = $categ['mainCateg'];
            $firstMonth = array_keys($listStatByCategory['month'])[0];
            if (true === isset($listStatByCategory['year']['current'][$categ['label']])) {
                $yearAmount = floatval($listStatByCategory['year']['current'][$categ['label']]) / (($currentMonth-$firstMonth)+1);
            }
            if (!isset($totalCateg[$mainCateg])) {
                $totalCateg[$mainCateg] = ['previous' => 0, 'year' => 0, 'month' => []];
                foreach($listStatByCategory['month'] as $i => $month){
                    $totalCateg[$mainCateg]['month'][$i] = 0;
                }
            }
            $total['previous'] += $lastYearAmount;
            $totalCateg[$mainCateg]['previous'] += $lastYearAmount;
            $total['year'] += $yearAmount;
            $totalCateg[$mainCateg]['year'] += $yearAmount;
            $row = [
                'categId'    => $categ['code'],
                'label'      => $categ['label'],
                'previous'   => number_format($lastYearAmount, 2),
                'current'    => number_format($yearAmount, 2),
                'yearAmount' => $yearAmount,
                'month'      => []
            ];
            foreach($listStatByCategory['month'] as $i => $month){
                if (false === isset($listStatByCategory['month'][$i][$categ['label']])) {
                    $row['month'][$i] = 0;
                    continue;
                }
                $row['month'][$i] = $listStatByCategory['month'][$i][$categ['label']];

                if (false === isset($total['month'][$i])) {
                    $total['month'][$i] = 0;
                }
                $total['month'][$i] += floatval($listStatByCategory['month'][$i][$categ['label']]);
                $totalCateg[$mainCateg]['month'][$i] += floatval($listStatByCategory['month'][$i][$categ['label']]);
//                if ($year == $currentYear && $i == $currentMonth) {
//                    // compute projection
//                    $row['month'][$i] .= ' / ' . number_format(($row['current'] / $nbDayMonth[$i]) * $currentDay, 2);
//
//                }
            }

            $data[$mainCateg][] = $row;
        }
        return compact('data', 'total', 'totalCateg');
    }
    /**
     * List table fields
     *
     * @return array
     * @codeCoverageIgnore
     */
    public function listFields()
    {
        return array('id', 'amount', 'date', 'guessed', 'category_code', 'bank_id');
    }

    /**
     * List row identifier(s) / unique fields
     *
     * @return array
     * @codeCoverageIgnore
     */
    public function listIdFields()
    {
        return array('id');
    }

}
