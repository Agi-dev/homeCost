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

use Serval\Base\Table\AbstractServiceTable;
use Serval\Technical\Date\DateInterface;
use Serval\Technical\Excel\ExcelInterface;

/**
 * Class Bank is a class to handle table bank operations.
 *
 * @method ExcelInterface getExcelService()
 * @method DateInterface getDateService()
 */
class Bank extends AbstractServiceTable implements BankInterface
{
    /**
     * tablename in bdd
     * @var string
     */
    protected $tablename = 'bank';

    /**
     * import bank statement
     *
     * @param $filename
     *
     * @return int
     */
    public function import($filename)
    {
        $data = $this->getExcelService()->toArray($filename);
        array_shift($data);
        array_shift($data);
        $this->beginTransaction();
        $nb = 0;
        try{
            foreach ($data as $item) {
                $insertData = [
                    'date_operation' => $this->getDateService()->dateToMysql($item[self::IMPORT_COL_DATE]),
                    'label'          => $item[self::IMPORT_COL_LABEL],
                    'amount'         => $item[self::IMPORT_COL_AMOUNT],
                    'date_created'   => $this->getDateService()->getCurrentMysqlDatetime(),
                    'status'         => self::STATUS_NEW,
                ];

                if (true === $this->isOperationAlreadyExits($insertData['date_operation'], $insertData['label'])) {
                    continue;
                }

                $this->insert($insertData);
                $nb++;
            }
            $this->commitTransaction();
        } catch (\RuntimeException $e) {
            $this->rollbackTransaction();
            throw $this->getThrowException('bank.import.failed', array('{error}' => $e->getMessage()));
        }
        return $nb;
    }

    /**
     * check if an operation already exist
     *
     * @param $date
     * @param $label
     *
     * @return bool
     */
    public function isOperationAlreadyExits($date, $label)
    {
        $result = $this->fetchAll('getByDateAndLabel', array(':date' => $date, ':label' => $label));
        return (true === isset($result['0']['id']));
    }

    /**
     * list new operation
     *
     * @return array
     */
    public function listNew()
    {
        return $this->fetchAll('listNew');
    }

    /**
     * List table fields
     *
     * @return array
     * @codeCoverageIgnore
     */
    public function listFields()
    {
        return array('id','date_operation','label','amount','date_created',);
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
