<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class SwitchAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'vendor/bootstrap-switch-master/css/bootstrap3/bootstrap-switch.min.css',
    ];
    public $js = [
        'vendor/bootstrap-switch-master/js/bootstrap-switch.min.js',
    ];
    public $depends = array(
        'app\assets\AppAsset',
    );
}
