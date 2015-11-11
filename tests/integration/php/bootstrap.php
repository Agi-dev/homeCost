<?php
use Serval\ServalFactory;
$kpiInitDb = false;

include_once(__DIR__ . '/../../bootstrap.php');

// Initialisation du container
$container = ServalFactory::singleton()->getContainer();

// load default service container definition
$container->addFile(__DIR__ . '/../../fixtures/dataForTests/Container/servicesForTI.php');
