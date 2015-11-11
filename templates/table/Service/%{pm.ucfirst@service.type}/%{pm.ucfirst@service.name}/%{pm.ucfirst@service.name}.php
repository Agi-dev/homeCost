<?php
/**
 * This file is part of the Numeric Workshop Serval project
 *
 * (c) IncentiveOffice - 2014
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Service\%{pm.ucfirst@service.type}\%{pm.ucfirst@service.name};

use Serval\Base\Table\AbstractServiceTable;

/**
 * Class %{pm.ucfirst@service.name} is a class to handle table %{pm.table.name} operations.
 */
class %{pm.ucfirst@service.name} extends AbstractServiceTable implements %{pm.ucfirst@service.name}Interface
{
    /**
     * tablename in bdd
     * @var string
     */
    protected $tablename = '%{pm.table.name}';

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
