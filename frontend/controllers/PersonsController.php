<?php

namespace frontend\controllers;

use common\models\WorkExperience;
use Yii;
use common\models\Persons;
use yii\web\Controller;
use yii\filters\VerbFilter;
use frontend\models\PersonsForm;
use common\models\Reserve;
use common\models\PostKey;


/**
 * PersonsController implements the CRUD actions for Persons model.
 */
class PersonsController extends MyController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Persons models.
     * @return mixed
     */
    public function actionIndex($id)
    {

        $key_nos = PostKey::find()->select(['key_no'])->where(['post_id' => $id])->asArray()->all();
        $key_persons = array();
        foreach($key_nos as $key){
            $person = Persons::find()->select(['id','name','post_1','post_2','level'])->where(['card_no'=>$key['key_no']])->one();
            $key_persons[]=$person;
        }

        return $this->render('index', [
            'key_persons' => $key_persons,
            'post'=>$id,
        ]);

    }

    /**
     * Displays a single Persons model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id,$post)
    {
        $model = Persons::find()->where(['id'=>$id])->one();

        $card_no = $model->card_no;
        $works = WorkExperience::find()->where(['card_no'=>$card_no])->all();

        $reserves = Reserve::find()->select(['reserve_no'])->asArray()->where(['post_id'=>$post])->all();
        $reserve_persons = array();
        if(count($reserves)>0){
            $cards = array();
            foreach($reserves as $reserve){
                if($reserve['reserve_no']!=$card_no){
                    $cards[]=$reserve['reserve_no'];
                }
            }
            $reserve_persons = Persons::find()->where(['card_no'=>$cards])->all();
        }

        return $this->render('view', [
            'model' => $model,
            'works'=>$works,
            'reserve_persons'=>$reserve_persons,
            'post'=>$post,
        ]);
    }


}
