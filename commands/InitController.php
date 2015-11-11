<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\components\console\MyController;
use Serval\Technical\Database\DatabaseInterface;
use yii;
use yii\console\controllers\MigrateController;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class InitController extends MyController
{
    /**
     * init projet
     */
    public function actionIndex()
    {
        /** @var DatabaseInterface $databaseService */
        $databaseService = $this->getService('database');
        $databaseService->truncate('migration');

        $migration = new MigrateController('migrate', Yii::$app);
        $migration->runAction('up', ['interactive' => false]);
    }
}
