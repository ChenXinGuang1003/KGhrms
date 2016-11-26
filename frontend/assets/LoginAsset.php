<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/8/11
 * Time: 16:31
 */

namespace frontend\assets;
use yii\web\AssetBundle;
class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'static/css/bootstrap.min.css',
        'static/css/bootstrap-responsive.min.css',
        'static/css/matrix-login.css',
        'static/css/font-awesome.min.css',
    ];
    public $js = [
//        'static/js/jquery-1.10.2.min.js',
//        'static/js/matrix.login.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}