<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/8/29
 * Time: 17:26
 */

namespace backend\assets;

use yii\web\AssetBundle;
class HackAsset extends AssetBundle
{
    public $baseUrl = '@web';
    public $css = [
        'static/css/ie.css',
    ];
    public $js = [
        'static/js/html5shiv.min.js',
    ];
    public $cssOptions = ['condition' => 'lte IE9','position' => \yii\web\View::POS_HEAD];
    public $jsOptions = ['condition' => 'lte IE9','position' => \yii\web\View::POS_HEAD];
}