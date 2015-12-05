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

use Serval\Base\Table\ServiceTableInterface;

/**
* Interface CostInterface
*/
interface CostInterface extends ServiceTableInterface
{
    /**
     * @param $year
     *
     * @return array
     */
    public function listStatByCategoryAndYearOrderedByMonth($year);

    /**
     * @param $year
     *
     * @return array
     */
    public function listStatByCategoryAndYear($year);

    /**
     * @return array
     */
    public function listStatByCategory();
}
