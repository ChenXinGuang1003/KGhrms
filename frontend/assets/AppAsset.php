<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'static/css/bootstrap.min.css',
        'static/css/bootstrap-responsive.min.css',
        'static/css/style.min.css',
        'static/css/style-responsive.min.css',
        'static/css/retina.css',
//        'static/css/bootstrap-datetimepicker.min.css',
    ];

    public $js = [
//        'static/js/jquery-1.10.2.min.js',
        'static/js/jquery-migrate-1.2.1.min.js',
        'static/js/jquery-ui-1.10.3.custom.min.js',
        'static/js/jquery.ui.touch-punch.js',
        'static/js/modernizr.js',
        'static/js/bootstrap.min.js',
//        'static/js/jquery.cookie.js',
//        'static/js/fullcalendar.min.js',
        'static/js/jquery.dataTables.min.js',
//        'static/js/excanvas.js',
//        'static/js/jquery.flot.js',
//        'static/js/jquery.flot.pie.js',
//        'static/js/jquery.flot.stack.js',
//        'static/js/jquery.flot.resize.min.js',
//        'static/js/jquery.flot.time.js',
        'static/js/jquery.chosen.min.js',
        'static/js/jquery.uniform.min.js',
        'static/js/jquery.cleditor.min.js',
        'static/js/jquery.noty.js',
        'static/js/jquery.elfinder.min.js',
        'static/js/jquery.raty.min.js',
        'static/js/jquery.iphone.toggle.js',
        'static/js/jquery.uploadify-3.1.min.js',
        'static/js/jquery.gritter.min.js',
        'static/js/jquery.imagesloaded.js',
        'static/js/jquery.masonry.min.js',
        'static/js/jquery.knob.modified.js',
        'static/js/jquery.sparkline.min.js',
//        'static/js/counter.min.js',
//        'static/js/raphael.2.1.0.min.js',
//        'static/js/justgage.1.0.1.min.js',
        'static/js/jquery.autosize.min.js',
        'static/js/retina.js',
        'static/js/jquery.placeholder.min.js',
        'static/js/wizard.min.js',
        'static/js/core.min.js',
//        'static/js/charts.min.js',
        'static/js/custom.min.js',
//        'static/js/bootstrap-datetimepicker.js',
//        'static/js/bootstrap-datetimepicker.zh-CN.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];


    //定义按需加载JS方法，注意加载顺序在最后
    public static function addScript($view, $jsfile) {
        $view->registerJsFile($jsfile, [AppAsset::className(), 'depends' => 'backend\assets\AppAsset']);
    }

    //定义按需加载css方法，注意加载顺序在最后
    public static function addCss($view, $cssfile) {
        $view->registerCssFile($cssfile, [AppAsset::className(), 'depends' => 'backend\assets\AppAsset']);
    }
}
