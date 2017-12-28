<?php
$tablename = 'category';
$listAttr = array('code', 'label', 'tag', 'show');
foreach ($listAttr as &$attr) {
    $attr = $tablename . '.' . $attr;
}
$attrSql = implode(', ', $listAttr);
$leftJoinSubCat= ' LEFT JOIN subcategory sc ON sc.category_code = category.code';
$attrSubCat = ', sc.code as mainCateg';

return array(
    'getById' => 'SELECT ' . $attrSql . ' FROM ' . $tablename . ' WHERE code = :id',
    'getByCode' => 'SELECT ' . $attrSql . ' FROM ' . $tablename . ' WHERE code = :code',
    'listAll'  => 'SELECT ' . $attrSql . $attrSubCat . ' FROM ' . $tablename . $leftJoinSubCat . ' ORDER BY label',
    'listAllOrderByTag'  => 'SELECT ' . $attrSql . $attrSubCat
        . ' FROM ' . $tablename
        . $leftJoinSubCat . ' WHERE `show` = 1 ORDER BY tag',
    'listMajor' => 'SELECT ' . $attrSql
        . ' FROM ' . $tablename
        . ' WHERE code NOT IN (SELECT code FROM subcategory)'
        . ' ORDER BY label',
);
