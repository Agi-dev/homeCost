<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use Serval\Technical\Filesystem\FilesystemInterface;
use yii\web\AssetBundle;
use yii;
use Serval\ServalFactory;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ActionAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
    ];
    public $depends = [
        'app\assets\AppAsset',
    ];

    public function __construct($config = [])
    {
        parent::__construct($config);

        /** @var FilesystemInterface $fileService */
        $fileService = ServalFactory::singleton()->get('filesystem');
        $webroot = yii::getAlias($this->basePath) . '/';
        $relativeFile = 'js/' .yii::$app->controller->id
            . '/' . yii::$app->controller->action->id . '.js';

        // add specific controller action js
        $filename = $webroot . $relativeFile;
        if (true === $fileService->isFileExists($webroot . $relativeFile)) {
            $this->js[] = $relativeFile;
        }
    }


}
