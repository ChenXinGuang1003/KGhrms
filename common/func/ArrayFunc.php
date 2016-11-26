<?php
namespace common\func;
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/8/30
 * Time: 16:53
 */
class ArrayFunc
{
    public static function arrayRemoveItem($key,$arr){
        if(is_integer($key)){
            unset($arr[$key]);
        }
        if(is_string($key)){
            $index = array_search($key,$arr);
            if($index!==false){
                array_splice($arr,$index,1);
            }
        }
        return $arr;
    }


    public static function sortArrByField(&$array, $field, $desc = false){
        $fieldArr = array();
        foreach ($array as $k => $v) {
            $fieldArr[$k] = $v[$field];
        }
        $sort = $desc == false ? SORT_ASC : SORT_DESC;
        array_multisort($fieldArr, $sort, $array);
    }
}