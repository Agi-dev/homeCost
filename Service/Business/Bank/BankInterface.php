<?php
/**
* This file is part of the Numeric Workshop Serval project
*
* (c) IncentiveOffice - 2014
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
namespace Service\Business\Bank;

use Serval\Base\Table\ServiceTableInterface;

/**
* Interface BankInterface
*/
interface BankInterface extends ServiceTableInterface
{
    /**
     * STATUS
     */
    const STATUS_NEW = 0;
    const STATUS_IGNORED = 1;
    const STATUS_SORTED = 2;

    /**
     * IMPORT COLUMN
     */
    const IMPORT_COL_DATE   = 0;
    const IMPORT_COL_LABEL  = 2;
    const IMPORT_COL_AMOUNT = 3;

    /**
     * import bank statement
     *
     * @param $filename
     *
     * @return int
     */
    public function import($filename);

    /**
     * check if an operation already exist
     *
     * @param $date
     * @param $label
     *
     * @return bool
     */
    public function isOperationAlreadyExits($date, $label);

    /**
     * list new operation
     *
     * @return array
     */
    public function listNew();

    /**
     * count operation need to be sorted
     *
     * @return int
     */
    public function countNew();

    /**
     * ignore operation
     *
     * @param $id
     *
     * @return mixed
     */
    public function ignoreById($id);

    /**
     * ignore operation
     *
     * @param $id
     *
     * @return $this
     */
    public function keepById($id);

    /**
     * tag operation
     *
     * @param $id
     * @param $tagId
     *
     * @return $this
     */
    public function tagById($id, $tagId);

    /**
     * untag operation
     *
     * @param $id
     *
     * @return $this
     */
    public function untagById($id);
}
