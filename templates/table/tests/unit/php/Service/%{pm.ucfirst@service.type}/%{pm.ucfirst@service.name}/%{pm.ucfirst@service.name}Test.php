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

use Serval\Base\Test\AbstractServiceTableTest;

include_once(__DIR__ . '/../../../bootstrap.php');

/**
 * Class %{pm.ucfirst@service.name}Test
 */
class %{pm.ucfirst@service.name}Test extends AbstractServiceTableTest
{
    /**
     * to be deleted
     */
    public function testMissing()
    {
        $this->markTestIncomplete('"' . $this->s()->getClassName() . '" unit tests are missing !!');
    }

    /**
     * nom de la table
     * @var string
     */
    protected $tablename = '%{pm.table.name}';

    /**
     * For autocompletion
     * @return %{pm.ucfirst@service.name}
     */
    public function s()
    {
        return parent::s();
    }
}
