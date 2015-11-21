<?php
$tablename = 'category';
$listAttr = array('id', 'label', 'tag');
foreach ($listAttr as &$attr) {
    $attr = $tablename . '.' . $attr;
}
$attrSql = implode(', ', $listAttr);

return array(
    'getById' => 'SELECT ' . $attrSql . ' FROM ' . $tablename . ' WHERE id = :id',
    'listAll'  => 'SELECT ' . $attrSql . ' FROM ' . $tablename . ' ORDER BY tag',
    'listMajor' => 'SELECT ' . $attrSql
                . ' FROM ' . $tablename
                . ' WHERE id NOT IN (SELECT id FROM subcategory)'
                . ' ORDER BY tag',
);
