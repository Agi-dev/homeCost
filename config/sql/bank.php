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
    'getByDateAndLabel' => 'SELECT ' . $attrSql . ' FROM ' . $tablename . ' WHERE date_operation = :date AND label = :label',
    'listNew' => 'SELECT ' . $attrSql . ' FROM ' . $tablename . ' WHERE status = ' . BankInterface::STATUS_NEW,
);
