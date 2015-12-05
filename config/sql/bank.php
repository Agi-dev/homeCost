<?php
use Service\Business\Bank\BankInterface;
$tablename = 'bank';
$listAttr = array('id','date_operation','label','amount','date_created',);
foreach ($listAttr as &$attr) {
    $attr = $tablename . '.' . $attr;
}
$attrSql = implode(', ', $listAttr);

return array(
    'getById' => 'SELECT ' . $attrSql . ' FROM ' . $tablename . ' WHERE id = :id',
    'listAll'  => 'SELECT ' . $attrSql . ' FROM ' . $tablename,
    'getByDateAndLabelAndAmount' => 'SELECT ' . $attrSql . ' FROM ' . $tablename . ' WHERE date_operation = :date AND label = :label AND amount = :amount',
    'listNew' => 'SELECT ' . $attrSql . ' FROM ' . $tablename . ' WHERE status = ' . BankInterface::STATUS_NEW . ' ORDER BY date_operation DESC, label',
    'countNew' => 'SELECT count(id) as nb FROM ' . $tablename . ' WHERE status = ' . BankInterface::STATUS_NEW . ' ORDER BY date_operation DESC, label',
);
