<?php
$tablename = 'category';
$listAttr = array('code', 'label', 'tag', 'show');
foreach ($listAttr as &$attr) {
    $attr = $tablename . '.' . $attr;
}
$attrSql = implode(', ', $listAttr);

return array(
    'getByCode' => 'SELECT ' . $attrSql . ' FROM ' . $tablename . ' WHERE code = :code',
    'listAll'  => 'SELECT ' . $attrSql . ' FROM ' . $tablename . ' ORDER BY label',
    'listAllOrderByTag'  => 'SELECT ' . $attrSql . ' FROM ' . $tablename . ' WHERE `show` = 1 ORDER BY tag',
    'listMajor' => 'SELECT ' . $attrSql
        . ' FROM ' . $tablename
        . ' WHERE code NOT IN (SELECT code FROM subcategory)'
        . ' ORDER BY label',
);
