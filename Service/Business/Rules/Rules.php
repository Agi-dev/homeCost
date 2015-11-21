<?php
/**
 * This file is part of the Numeric Workshop Serval project
 *
 * (c) IncentiveOffice - 2014
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Service\Business\Rules;

use Serval\Base\Table\AbstractServiceTable;

/**
 * Class Rules is a class to handle table rules operations.
 */
class Rules extends AbstractServiceTable implements RulesInterface
{
    /**
     * tablename in bdd
     * @var string
     */
    protected $tablename = 'rules';

    /**
     * List table fields
     *
     * @return array
     * @codeCoverageIgnore
     */
    public function listFields()
    {
        return array('id');
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
