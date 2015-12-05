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

/**
 * Class Cost is a class to handle table cost operations.
 */
class Cost extends AbstractServiceTable implements CostInterface
{
    /**
     * tablename in bdd
     * @var string
     */
    protected $tablename = 'cost';

    /**
     * @return array
     */
    public function listStatByCategory()
    {
        $currentYear = date('Y');
        $prevYear = date("Y",strtotime("-1 year"));

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
     * List table fields
     *
     * @return array
     * @codeCoverageIgnore
     */
    public function listFields()
    {
        return array('id', 'amount', 'date', 'guessed', 'category_id', 'bank_id');
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
