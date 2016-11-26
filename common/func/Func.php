<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/9/7
 * Time: 10:31
 */

namespace common\func;
use Yii;

class Func
{

    public static function setSn($model,$prefix){
        $list = $model::find()->asArray()->all();
        $count = count($list)+1;
        $sn = '';
        if($count<10){
            $sn = $prefix.'000'.$count;
        }elseif($count<100){
            $sn = $prefix.'00'.$count;
        }elseif($count<1000){
            $sn = $prefix.'0'.$count;
        }elseif($count<10000){
            $sn = $prefix.$count;
        }

        return $sn;
    }


    public static function encodeStr($str)
    {
        $encode = mb_detect_encoding( $str, array('ASCII','UTF-8','GB2312','GBK'));
        if ( !$encode =='UTF-8' ){
            $str = iconv('UTF-8',$encode,$str);
        }
        return $str;
    }

    /*public static function setSession($name,$value){
        $session = Yii::$app->session;
        //当session没有值 或 过期时间到 则重新付值
        if(!isset($session[$name]) || $session[$name]['expire_time'] < time()){
            $data = [
                'title' => 'data' . time(),  //数据
                'expire_time' => time() + 10, //这里设置10秒过期
            ];
            $session[$name] = $data;
        }
    }*/
}