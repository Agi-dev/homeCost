<?php
$tablename = 'cost';
$listAttr = array('id', 'amount', 'date', 'guessed', 'category_id', 'bank_id');

foreach ($listAttr as &$attr) {
    $attr = $tablename . '.' . $attr;
}
$attrSql = implode(', ', $listAttr);

return array(
    'getById' => 'SELECT ' . $attrSql . ' FROM ' . $tablename . ' WHERE id = :id',
    'listAll'  => 'SELECT ' . $attrSql . ' FROM ' . $tablename,
    'listAllStat' => 'SELECT
                          c1.label, sum(amount) AS total
                        FROM category c1
                        LEFT JOIN subcategory s ON s.id = c1.id
                        INNER JOIN cost c ON c.category_id = IFNULL(s.category_id, c1.id )
                        GROUP BY c.category_id
                        ORDER BY c1.label',
//    'listCategoryStatByYear' => 'SELECT
//                          c1.label as category, sum(amount) AS total
//                        FROM category c1
//                        LEFT JOIN subcategory s ON s.id = c1.id
//                        INNER JOIN cost c ON c.category_id = IFNULL(s.category_id, c1.id )
//                        WHERE YEAR(c.date) = :year
//                        GROUP BY c.category_id
//                        ORDER BY c1.label',
//    'listMonthCategoryStatByYear' => 'SELECT
//                              MONTH(c.date) as month, c1.label as category, sum(amount) as total
//                            FROM category c1
//                            LEFT JOIN subcategory s on s.id = c1.id
//                            INNER JOIN cost c
//                            ON c.category_id = IFNULL(s.category_id, c1.id )
//                            WHERE YEAR(c.date) = :year
//                            GROUP BY MONTH(c.date), c.category_id
//                            ORDER BY MONTH(c.date), c1.label',

    'listCategoryStatByYear' => 'SELECT
                          c1.label as category, sum(amount) AS total
                        FROM category c1
                        INNER JOIN cost c ON c.category_id = c1.id
                        WHERE YEAR(c.date) = :year
                        GROUP BY c.category_id
                        ORDER BY c1.label',
    'listMonthCategoryStatByYear' => 'SELECT
                              MONTH(c.date) as month, c1.label as category, sum(amount) as total
                            FROM category c1
                            INNER JOIN cost c ON c.category_id = c1.id
                            WHERE YEAR(c.date) = :year
                            GROUP BY MONTH(c.date), c.category_id
                            ORDER BY MONTH(c.date), c1.label',
);
