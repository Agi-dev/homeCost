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
     * List table fields
     *
     * @return array
     * @codeCoverageIgnore
     */
    public function listFields()
    {
        return array('id', 'amount', 'guessed', 'category_id', 'bank_id');
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
