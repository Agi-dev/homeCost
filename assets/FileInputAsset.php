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
class FileInputAsset extends AssetBundle
{
    public $sourcePath = '@app/vendor/kartik-v/bootstrap-fileinput';
    public $css = [
        'css/fileinput.min.css',
    ];
    public $js = [
        'js/fileinput.min.js',
        'js/fileinput_locale_fr.js'
    ];
    public $depends = array(
        'app\assets\AppAsset',
    );
}
