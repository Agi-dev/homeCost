<?php
$tablename = 'rules';
$listAttr = array('id', 'rule', 'category_code');
foreach ($listAttr as &$attr) {
    $attr = $tablename . '.' . $attr;
}
$attrSql = implode(', ', $listAttr);

return array(
    'getById' => 'SELECT ' . $attrSql . ' FROM ' . $tablename . ' WHERE id = :id',
    'listAll'  => 'SELECT ' . $attrSql . ' FROM ' . $tablename,
);
