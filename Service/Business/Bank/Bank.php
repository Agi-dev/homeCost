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
use Serval\Technical\Filesystem\FilesystemInterface;
use Service\Business\Category\CategoryInterface;
use Service\Business\Cost\CostInterface;

/**
 * Class Bank is a class to handle table bank operations.
 *
 * @method ExcelInterface getExcelService()
 * @method DateInterface getDateService()
 * @method CategoryInterface getCategoryService()
 * @method CostInterface getCostService()
 * @method FilesystemInterface getFilesystemService()
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
     * @return array nb duplicate, added ['duplicate' => <nb>, 'added' => <nb>']
     */
    public function import($filename)
    {
        $ext = $this->getFilesystemService()->getFileExtension($filename);

        // import excel
        $nb = ['duplicate' => 0, 'added' => 0];
        $data = $this->getExcelService()->toArray($filename);

        $listCol = implode(';', $data[0]);

        if ($listCol === 'Date operation;Libelle;Debit;Credit') {
            $colDate = 0;
            $colLabel = 1;
            $colDebit = 2;
            $colCredit = 3;
        } elseif ($listCol === 'Date operation;Date valeur;Libelle;Debit;Credit') {
            $colDate = 0;
            $colLabel = 2;
            $colDebit = 3;
            $colCredit = 4;
        } else {
            throw $this->getThrowException('bank.import.bad.format', ['actual' => $listCol]);
        }

        array_shift($data);
        $this->beginTransaction();
        try {
            foreach ($data as $item) {
                $item[$colDate] = str_replace('-', '/', $item[$colDate]);
                $dateOp = $this->getDateService()->dateI18nToMysql($item[$colDate]);
                if (null === $dateOp) {
                    throw $this->getThrowException('bank.import.date.badformat', array('{date}' => $dateOp));
                }
                if (empty($item[$colCredit])) {
                    $amount = str_replace(',', '.', $item[$colDebit]) * -1;
                } else {
                    $amount = str_replace(',', '.', $item[$colCredit]);
                }
                $insertData = [
                    'date_operation' => $dateOp,
                    'label'          => $item[$colLabel],
                    'amount'         => $amount,
                    'date_created'   => $this->getDateService()->getCurrentMysqlDatetime(),
                    'status'         => self::STATUS_NEW,
                ];

                if (true === $this->isOperationAlreadyExits($insertData['date_operation'], $insertData['label'], $insertData['amount'])) {
                    $nb['duplicate']++;
                } else{
                    $this->insert($insertData);
                    //$this->_guess($data);
                    $nb['added']++;
                }
            }
            $this->commitTransaction();
        } catch (\Exception $e) {
            $this->rollbackTransaction();
            throw $this->getThrowException('bank.import.failed', ['{error}' => $e->getMessage()]);
        }

        return $nb;


    }

    /**
     * @param $data
     *
     * @return mixed
     */
    protected function _addOperation($data)
    {
        if (true === $this->isOperationAlreadyExits($data['date_operation'], $data['label'], $data['amount'])) {
            return null;
        }
        $data['id'] = $this->insert($data);
        //$this->_guess($data);

        return $data['id'];
    }

    /**
     * @param $data
     */
    protected function _guess($data, $saveIt = true)
    {
        // guess category
        $categCode = $this->getCategoryService()->guess($data['label']);
        if ($saveIt && null !== $categCode) {
            $insertData = [
                'amount'        => $data['amount'],
                'date'          => $data['date_operation'],
                'guessed'       => 1,
                'category_code' => $categCode,
                'bank_id'       => $data['id'],
            ];
            $this->getCostService()->insert($insertData);
            $this->update(
                ['status' => BankInterface::STATUS_SORTED],
                ['id' => $data['id']]
            );
        }

        return $categCode;
    }

    /**
     * check if an operation already exist
     *
     * @param $date
     * @param $label
     * @param $amount
     *
     * @return bool
     */
    public function isOperationAlreadyExits($date, $label, $amount)
    {
        if (preg_match('/^CARTE ([0-9]{2}\/[0-9]{2})(.*)$/', $label, $matches)) {
            $date = $matches[1];
            $label = $matches[2];
        } else {
            $date = substr($date, 0, 5);
        }
        $result = $this->fetchAll(
            'getByDateAndLabelAndAmount',
            [':date' => $date, ':label' => $label, ':amount' => $amount]
        );

        return (true === isset($result['0']['id']));
    }

    /**
     * list new operation an try to guess main category
     *
     * @return array
     */
    public function listNew()
    {
        $data = $this->fetchAll('listNew');
        foreach ($data as $i => $row) {
            $row['categ'] = $this->_guess($row, false);
            $data[$i] = $row;
        }
        uasort(
            $data,
            function ($a, $b) {
                if ($a['categ'] == $b['categ']) {
                    return 0;
                }
                if ($a['categ'] == 'AUTRE') {
                    return -1;
                }
                if ($b['categ'] == 'AUTRE') {
                    return 1;
                }
                return ($a['categ'] < $b['categ']) ? -1 : 1;
            }
        );
        return $data;
    }

    /**
     * count operation need to be sorted
     *
     * @return int
     */
    public function countNew()
    {
        $result = $this->fetchAll('countNew');
        return $result[0]['nb'];
    }

    /**
     * ignore operation
     *
     * @param $id
     *
     * @return $this
     */
    public function ignoreById($id)
    {
        $this->checkId($id);
        $this->update(['status' => BankInterface::STATUS_IGNORED], ['id' => $id]);
        $this->getCostService()->delete(['bank_id' => $id]);

        return $this;
    }

    /**
     * ignore operation
     *
     * @param $id
     *
     * @return $this
     */
    public function keepById($id)
    {
        $this->checkId($id);
        $this->update(['status' => BankInterface::STATUS_NEW], ['id' => $id]);

        return $this;
    }

    /**
     * tag operation
     *
     * @param $id
     * @param $tagCode
     *
     * @return $this
     */
    public function tagById($id, $tagCode)
    {
        $operation = $this->checkId($id);
        $this->update(['status' => BankInterface::STATUS_SORTED], ['id' => $id]);
        $this->getCostService()->insert(
            [
                'amount'        => $operation['amount'],
                'bank_id'       => $id,
                'category_code' => $tagCode,
                'date'          => $operation['date_operation']
            ]
        );

        return $this;
    }

    /**
     * untag operation
     *
     * @param $id
     *
     * @return $this
     */
    public function untagById($id)
    {
        $this->checkId($id);
        $this->update(['status' => BankInterface::STATUS_NEW], ['id' => $id]);
        $this->getCostService()->delete(['bank_id' => $id]);

        return $this;
    }

    /**
     * guess category
     */
    public function guess()
    {
        $listNew = $this->listNew();
        foreach ($listNew as $bank) {
            $this->_guess($bank);
        }
    }

    /**
     * List table fields
     *
     * @return array
     * @codeCoverageIgnore
     */
    public function listFields()
    {
        return ['id', 'date_operation', 'label', 'amount', 'date_created', 'status'];
    }

    /**
     * List row identifier(s) / unique fields
     *
     * @return array
     * @codeCoverageIgnore
     */
    public function listIdFields()
    {
        return ['id'];
    }

}
