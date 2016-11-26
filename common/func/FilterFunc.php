<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/9/11
 * Time: 8:37
 */

namespace common\func;

use common\models\Edu;
use common\models\Persons;
use common\models\PostKey;
use Yii;
use common\models\Level;
use common\models\Posts;
use backend\models\Role;
class FilterFunc
{
    public static function transLevel($id){
        return Level::find()->where(['level_id'=>$id])->one()->level_name;
    }

    public static function transRole($id){
        return Role::find()->where(['role_id'=>$id])->one()->role_name;
    }

    public static function transPost($id){
        if($id){
            return Posts::find()->where(['post_id'=>$id])->one()->post_name;
        }else{
            return '';
        }

    }

    public static function transEdu($id){
        return Edu::find()->where(['edu_id'=>$id])->one()->edu_name;
    }

    public static function transIsKey($post,$card_no){
        $is_key = PostKey::find()->where(['post_id'=>$post,'key_no'=>$card_no])->one();
        return count($is_key)>0 ? '在岗': '储备';
    }

    public static function transCardNo($card_no){
        return Persons::find()->where(['card_no'=>$card_no])->one()->name;
    }


    const DATE_FORMAT = 'php:Y-m-d';
    const DATETIME_FORMAT = 'php:Y-m-d H:i:s';
    const TIME_FORMAT = 'php:H:i:s';

    public static function convert($dateStr, $type='date', $format = null) {
        if ($type === 'datetime') {
            $fmt = ($format == null) ? self::DATETIME_FORMAT : $format;
        }
        elseif ($type === 'time') {
            $fmt = ($format == null) ? self::TIME_FORMAT : $format;
        }
        else {
            $fmt = ($format == null) ? self::DATE_FORMAT : $format;
        }
        return Yii::$app->formatter->asDate($dateStr, $fmt);
    }
}