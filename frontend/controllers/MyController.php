<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/9/10
 * Time: 14:29
 */

namespace frontend\controllers;
use common\models\Posts;
use Yii;
use yii\web\Controller;

class MyController extends Controller
{
    public function init() {

    }

    public function beforeAction($action) {

        if (count(Yii::$app->session->get('navList'))==0) {
            $this->getNavList();
        }
        return true;
    }
    public function getNavList()
    {
        $data = Posts::find()->where(['flag'=>'1','is_key'=>'1'])->asArray()->all();
        Yii::$app->session->set('navList', $data);

    }
}