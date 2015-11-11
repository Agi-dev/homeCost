<?php
////////////////////////////////////////////////////////////////////////////////
//Unit tests command line (run it from project root):
//phpunit --colors --bootstrap ./protected/tests/bootstrap.php --configuration ./protected/tests/phpunit.xml --testsuite businessLayer
////////////////////////////////////////////////////////////////////////////////

use Serval\Technical\Container\Container;
use Serval\ServalFactory;

// composer autoload
require_once(__DIR__ . '/../vendor/autoload.php');

// initialisation Serval
Container::singleton()->loadFile(__DIR__ . '/../config/container/services.php');
ServalFactory::singleton()->setContainer(Container::singleton());
include_once(__DIR__ . '/../vendor/NumericWorkshop/Serval/src/Serval/functions.php');