<?php
// composer autoload
use Serval\ServalFactory;
use Serval\Technical\Container\Container;

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', getenv('YII_ENV'));
defined('YII_ENV') or define('YII_ENV', 'prod');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

// Init Serval
Container::singleton()->loadFile(__DIR__ . '/../config/container/services.php');
ServalFactory::singleton()->setContainer(Container::singleton());
include_once(__DIR__ . '/../vendor/Serval/src/Serval/functions.php');

$config = require(__DIR__ . '/../config/web.php');

(new yii\web\Application($config))->run();
