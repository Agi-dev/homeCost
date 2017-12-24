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

use Serval\Base\Table\AbstractServiceTable;
use Service\Business\Rules\RulesInterface;

/**
 * Class Category is a class to handle table category operations.
 *
 * @method RulesInterface getRulesService()
 */
class Category extends AbstractServiceTable implements CategoryInterface
{
    protected $_listRules;
    /**
     * tablename in bdd
     * @var string
     */
    protected $tablename = 'category';

    /**
     * guess category from a label
     *
     * @param $label
     *
     * @return int|null
     */
    public function guess($label)
    {
        if (null === $this->_listRules) {
            $this->_listRules = $this->getRulesService()->listAll();
        }

        foreach ($this->_listRules as $rule) {
            if (1 === preg_match('#' . $rule['rule'] . '#i', $label)) {
                return $rule['category_code'];
            }
        }
        return 'AUTRE';
    }

    /**
     * @param string $order
     *
     * @return array
     */
    public function listOrderBy($order = 'label')
    {
        if ('tag' === $order) {
            $result = $this->fetchAll('listAllOrderByTag');
            $data = [];
            foreach ($result as $i => $row) {
                $data[$row['code']] = $row;
            }
            return $data;
        }
        return $this->listAll();
    }

    /**
     * @return array
     */
    public function listMajor()
    {
        return $this->fetchAll('listMajor');
    }

    /**
     * List table fields
     *
     * @return array
     * @codeCoverageIgnore
     */
    public function listFields()
    {
        return array('code');
    }

    /**
     * List row identifier(s) / unique fields
     *
     * @return array
     * @codeCoverageIgnore
     */
    public function listIdFields()
    {
        return array('code');
    }

}
