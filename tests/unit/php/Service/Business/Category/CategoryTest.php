<?php
/**
 * This file is part of the Numeric Workshop Serval project
 *
 * (c) IncentiveOffice - 2014
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Service\Business\Category;

use Serval\Base\Test\AbstractServiceTableTest;

include_once(__DIR__ . '/../../../bootstrap.php');

/**
 * Class CategoryTest
 */
class CategoryTest extends AbstractServiceTableTest
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
    protected $tablename = 'category';

    /**
     * For autocompletion
     * @return Category
     */
    public function s()
    {
        return parent::s();
    }
}
