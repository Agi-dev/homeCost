<?php
/**
 * This file is part of the Numeric Workshop homeCost project
 *
 * (c) IncentiveOffice
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace app\components;

use Serval\Technical\Database\DatabaseInterface;
use yii\db\Migration;
use Serval\ServalFactory;
/**
 * Class MyMigration
 */
class MyMigration extends Migration
{
    public function executeScriptFile($sqlFile)
    {
        /** @var DatabaseInterface $db */
        $db = ServalFactory::singleton()->get('database');
        $db->execScriptFile($sqlFile);
    }
}