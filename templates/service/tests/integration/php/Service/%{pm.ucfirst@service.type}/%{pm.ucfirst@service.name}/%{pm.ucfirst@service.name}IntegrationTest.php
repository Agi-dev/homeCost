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

use Serval\Base\Test\AbstractServiceIntegrationTest;

include_once(__DIR__ . '/../../../bootstrap.php');

/**
 * Class %{pm.ucfirst@service.name}Test
 */
class %{pm.ucfirst@service.name}IntegrationTest extends AbstractServiceIntegrationTest
{
    /**
     * to be deleted
     */
    public function testMissing()
    {
        $this->markTestIncomplete('"' . $this->s()->getClassName() . '" integration tests are missing !!');
    }

    /**
     * For autocompletion
     * @return %{pm.ucfirst@service.name}
     */
    public function s()
    {
        return parent::s();
    }
}
