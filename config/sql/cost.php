<?php
$tablename = 'cost c';
$listAttr = array('id', 'amount', 'date', 'guessed', 'category_id', 'bank_id');

foreach ($listAttr as &$attr) {
    $attr = 'c.' . $attr;
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

    'listByYear' => 'SELECT ' . $attrSql . ', b.label as operation, ca.label as category'
                . ' FROM ' . $tablename
                . ' INNER JOIN category ca on c.category_id = ca.id'
                . ' INNER JOIN bank b on c.bank_id = b.id'
                . ' WHERE YEAR(c.date) = :year ORDER BY c.date',

    'listByYearAndCategoryId' => 'SELECT ' . $attrSql . ', b.label as operation, ca.label as category'
        . ' FROM ' . $tablename
        . ' INNER JOIN category ca on c.category_id = ca.id'
        . ' INNER JOIN bank b on c.bank_id = b.id'
        . ' WHERE c.category_id = :category_id AND YEAR(c.date) = :year ORDER BY c.date',

    'listByMonth' => 'SELECT ' . $attrSql . ', b.label as operation, ca.label as category'
        . ' FROM ' . $tablename
        . ' INNER JOIN category ca on c.category_id = ca.id'
        . ' INNER JOIN bank b on c.bank_id = b.id'
        . ' WHERE MONTH(c.date) = :month AND YEAR(c.date) = :year ORDER BY c.date',

    'listByMonthAndCategoryId' => 'SELECT ' . $attrSql . ', b.label as operation, ca.label as category'
        . ' FROM ' . $tablename
        . ' INNER JOIN category ca on c.category_id = ca.id'
        . ' INNER JOIN bank b on c.bank_id = b.id'
        . ' WHERE c.category_id = :category_id AND MONTH(c.date) = :month AND YEAR(c.date) = :year ORDER BY c.date',
);
