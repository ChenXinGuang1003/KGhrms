<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/9/10
 * Time: 14:29
 */

namespace backend\controllers;
use common\func\ArrayFunc;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;

class MyController extends Controller{
    public function init() {

    }

    public function beforeAction($action) {
        if(!Yii::$app->user->isGuest){
            if (count(Yii::$app->session->get('navList'))==0) {
                $role = Yii::$app->user->identity->role;
                $this->getNavList($role);
            }
        }
        return true;
    }

    public function getNavList($role)
    {
        $sqlNav = 'select a.* from nav_list as a,role_nav as b where b.role_id="' . $role . '" and a.nav_id = b.nav_id and a.flag ="1" order by a.nav_id';
        $conn = Yii::$app->db;
        $conn->open();
        $comm = $conn->createCommand($sqlNav);
        $res = $comm->queryAll();
        $navList = array();
        if(count($res)>0){
            foreach ($res as $key => $val) {
                $pid = $val['parent_id'];
                if (empty($pid)) {
                    $key_1 = 'nav_' . $val['nav_id'];
                    if(!array_key_exists($key_1,$navList)){
                        $navList[$key_1] = $val;
                        $navList[$key_1]['sub'] = [];
                    }
                } else {
                    $pkey = 'nav_' . $pid;
                    if (array_key_exists($pkey,$navList)) {
                        if (array_key_exists( 'sub',$navList[$pkey])) {
                            array_push($navList[$pkey]['sub'], $val);
                        } else {
                            $navList[$pkey]['sub'] = [];
                            array_push($navList[$pkey]['sub'], $val);
                        }
                    }
                }
            }
            ArrayFunc::sortArrByField($navList,'sort_id');
            Yii::$app->session->set('navList', $navList);
        }
    }
}