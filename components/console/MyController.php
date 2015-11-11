<?php
/**
 * This file is part of the Numeric Workshop homeCost project
 *
 * (c) IncentiveOffice
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace app\components\console;

use Serval\ServalFactory;
use yii\console\Controller;

/**
 * Class MyController
 */
class MyController extends Controller
{
    /**
     * get service
     *
     * @param $name
     *
     * @return \Serval\Base\ServiceInterface
     */
    public function getService($name)
    {
        return ServalFactory::singleton()->get($name);
    }
}