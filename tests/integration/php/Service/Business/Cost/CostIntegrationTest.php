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

use Serval\Base\Test\AbstractServiceIntegrationTest;

include_once(__DIR__ . '/../../../bootstrap.php');

/**
 * Class CostIntegrationTest
 */
class CostIntegrationTest extends AbstractServiceIntegrationTest
{
    public function initBdd()
    {
        $this->setUpDataContext('cost.sql');
    }

    /**
     * to be deleted
     */
    public function testMissing()
    {
        $this->markTestIncomplete('"' . $this->s()->getClassName() . '" integration tests are missing !!');
    }

    /**
     * For autocompletion
     * @return Cost
     */
    public function s()
    {
        return parent::s();
    }
}
