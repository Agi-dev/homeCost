<?php
/**
 * This file is part of the Numeric Workshop Serval project
 *
 * (c) IncentiveOffice - 2014
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Serval\Base\Test\AbstractSqlIntegrationTest;

include_once(__DIR__ . '/../bootstrap.php');

/**
 * Class CategoryIntegrationSqlTest
 */
class CategorySqlIntegrationTest extends AbstractSqlIntegrationTest
{
    public function initBdd()
    {
        $this->setUpDataContext('category.sql');
    }

    /**
     * getById
     */
    public function testGetByIdWithSuccess()
    {
        $this->initBdd();
        $actual = $this->query('category.getById', array(':id' => 1));
        $this->assertEqualsResultSet($actual);
    }

    /**
     * listAll
     */
    public function testListAllWithSuccess()
    {
        $this->initBdd();
        $actual = $this->query('category.listAll');
        $this->assertEqualsResultSet($actual);
    }
}
