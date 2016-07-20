<?php
$services = include __DIR__ . '/../../vendor/NumericWorkshop/Serval/src/Serval/resources/container/services.php';

/**
 * PARAMETERS
 */

// i18n
$locale = 'fr_FR';
$services['parameters']['i18n']['locale'] = $locale;
$services['parameters']['i18n']['defaultLocale'] = 'fr_FR';
$services['parameters']['i18nRepository']['repositories'][] = __DIR__ . '/../i18n';

// utile pour les tests mais doit être revue pour ne pas avoir besoin de le faire
$services['parameters']['i18nForAbstractService']['locale'] = $locale;
$services['parameters']['i18nForAbstractService']['defaultLocale'] = 'fr_FR';

// NumberFormat
$services['parameters']['numberFormat']['locale'] = $locale;

// BDD
$services['parameters']['database'] = array_merge(
    $services['parameters']['database'],
    [
        'dsn'      => 'mysql:host=localhost;dbname=homecost',
        'username' => 'root',
        'password' => '',
    ]
);
$services['parameters']['database']['queriesPath'] = array_merge(
    [__DIR__ . '/../sql'],
    $services['parameters']['database']['queriesPath']
);

// Phone
$services['parameters']['phone'] = [
    'defaultCountry' => 'FR',
];

/**
 * ENVIRONNEMENT
 */
$mode = getenv('APPLICATION_ENV');
if (empty($mode)) {
    $mode = 'prod';
}

if ('dev' === $mode) {
    $services['parameters']['database']['password'] = 'root';
}
/**
 * SERVICE
 */
// Business
$localBusinessServices = [
    'Bank',
    'Category',
    'Cost',
    'Rules',
];
foreach ($localBusinessServices as $service) {
    $services['services'][lcfirst($service)] = 'Service\\Business\\' . $service . '\\' . $service;
}

// Technical
$technicalServices = [
];
foreach ($technicalServices as $service) {
    $services['services'][lcfirst($service)] = 'Service\\Technical\\' . $service . '\\' . $service;
}

return $services;
