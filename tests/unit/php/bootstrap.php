<?php
use Serval\Base\Test\ContainerTest;

// composer autoload
require_once(__DIR__ . '/../../../vendor/autoload.php');
include_once(__DIR__ . '/../../../vendor/NumericWorkshop/Serval/src/Serval/functions.php');

// Initialisation du container
$container = ContainerTest::singleton();

// load default service container definition
$container->loadFile(__DIR__ . '/../../fixtures/dataForTests/Container/servicesForTU.php');
