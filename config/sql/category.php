<?php
$tablename = 'category';
$listAttr = array('code', 'label', 'tag', 'show');
foreach ($listAttr as &$attr) {
    $attr = $tablename . '.' . $attr;
}
$attrSql = implode(', ', $listAttr);

return array(
    'getById' => 'SELECT ' . $attrSql . ' FROM ' . $tablename . ' WHERE code = :id',
    'getByCode' => 'SELECT ' . $attrSql . ' FROM ' . $tablename . ' WHERE code = :code',
    'listAll'  => 'SELECT ' . $attrSql . ' FROM ' . $tablename . ' ORDER BY label',
    'listAllOrderByTag'  => 'SELECT ' . $attrSql
        . ', sc.code as mainCateg FROM ' . $tablename
        . ' LEFT JOIN subcategory sc ON sc.category_code = category.code WHERE `show` = 1 ORDER BY tag',
    'listMajor' => 'SELECT ' . $attrSql
        . ' FROM ' . $tablename
        . ' WHERE code NOT IN (SELECT code FROM subcategory)'
        . ' ORDER BY label',
);
