<?php

namespace backend\controllers;

use backend\models\KgworkForm;
use common\models\Admin;
use common\models\BadInfo;
use common\models\KgWorks;
use common\models\PostKey;
use common\models\Reserve;
use Yii;
use common\models\Persons;
use common\models\WorkExperience;
use yii\db\Exception;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\models\PersonsForm;
use backend\models\WorkForm;
use backend\models\BadInfoForm;
use common\func\LoadFunc;
use yii\data\Pagination;
use yii\helpers\Json;

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

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Lists all Persons models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Persons();

        $curPage = Yii::$app->request->get('page',1);
        $pageSize = Yii::$app->params['pageSize'];

        $type = Yii::$app->request->get('type');
        $value = Yii::$app->request->get('value');
        $search = ($type&&$value)?['like',$type,$value]:'';
        $role = Yii::$app->user->identity->role;
        if($role == '0006'){
            $number = Yii::$app->user->identity->person_number;
            $person = Persons::find()->select(['post_1','post_2','post_3',])->where('number=:number',[':number'=>$number])->one();
            $query = Persons::find()->where('post_1 = :post_1 or post_2 = :post_2 or post_3 = :post_3',[':post_1'=>$person->post_1,':post_2'=>$person->post_2,':post_3'=>$person->post_3,])->orderBy('post_1,post_2,post_3,post_4 ASC');
        }else{
            $query = Persons::find()->orderBy('post_1,post_2,post_3,post_4 ASC');
        }

        $data = $model->getPages($query,$curPage,$pageSize,$search);
        $pages = new Pagination(['totalCount'=>$data['count'],'pageSize' => $pageSize]);
        return $this->render('index',['data'=>$data,'pages'=>$pages]);
    }


    //转换request传递的post数组
    public function transPostArr($postArr,$len,$modleName,$mAttr){
        $arr = array();
        if($len>0){
            for($i=0;$i<$len;$i++){
                if($modleName == 'WorkForm'){
                    $model = new WorkForm();
                }else if($modleName == 'BadInfoForm'){
                    $model = new BadInfoForm();
                }
                foreach($mAttr as $k=>$v){
                    $model->$k = $v;
                }
                foreach($postArr as $key => $val){
                    $model->$key = $val[$i];
                }
                if($model->validate()){
                    $arr[] =  $model;
                }
            }
        }
        return $arr;
    }

    public function actionCreate(){
        $personForm = new PersonsForm();
        $work = new WorkForm();
        $badInfo= new BadInfoForm();

        if ($personForm->load(Yii::$app->request->post())) {
            //整理工作经历信息
            $len = count($_POST['work']['company']);
            $mAttr = array('card_no' => $personForm->card_no);
            $works = $this->transPostArr($_POST['work'],$len,'WorkForm',$mAttr);

            //整理违规信息
            $len_bad = count($_POST['bad']['bad_info']);
            $mAttr = array('card_no' => $personForm->card_no);
            $badInfos = $this->transPostArr($_POST['bad'],$len_bad,'BadInfoForm',$mAttr);

            //集团工作经历
            $kgworks = KgWorks::find()->where('card_no = :card_no',[':card_no'=> $personForm->card_no])->all();

            $transaction = Yii::$app->db->beginTransaction();
            try{
                //保存基本信息
                $person = $personForm->addItem();
                //保存集团内部工作经历
                $kgwork = new KgWorks();
                $kgwork->addItem($person);

                foreach($works as $item){
                    $item->addItem();
                }
                foreach($badInfos as $bad){
                    $bad->addItem();
                }
                $person->img_url = LoadFunc::UpLoadImg($personForm);
                $person->save();
                $transaction->commit();
                return $this->redirect(['persons/index']);
            }
            catch(Exception $e){
                $transaction->rollBack();
                return $this->render('create', [
                    'person' => $personForm,
                    'works' => $works,
                    'badInfos' => $badInfos,
                    'kgworks' => $kgworks,
                ]);
            }

        }else {
            $works[] = $work;
            $badInfos[] = $badInfo;
            $kgworks= array();
            return $this->render('create', [
                'person' => $personForm,
                'works' => $works,
                'badInfos' => $badInfos,
                'kgworks' => $kgworks,
            ]);
        }

    }


    public function actionUpdate($id)
    {
        $personForm = new PersonsForm();
        //查询基本信息
        $person = $personForm-> getItem($id);
        $card_no = $person->card_no;

        //查询工作经历
        $works = WorkExperience::find()->where(['card_no'=>$card_no])->all();
        if(count($works)==0){
            $works[] = new WorkForm();
        }
        //查询违规信息
        $badInfos = BadInfo::find()->where(['card_no'=>$card_no])->all();
        if(count($badInfos)==0){
            $badInfos[] = new BadInfoForm();
        }
        //集团工作经历
        $kgworks = KgWorks::find()->where('card_no = :card_no',[':card_no'=> $card_no])->all();


        if ($personForm->load(Yii:: $app-> request->post())) {
            //拼接工作经历信息
            $len = count($_POST['work']['company']);
            $mAttr = array('card_no' => $personForm->card_no);
            $works = $this->transPostArr($_POST['work'],$len,'WorkForm',$mAttr);

            //拼接违规信息
            $len = count($_POST['bad']['bad_info']);
            $mAttr = array('card_no' => $personForm->card_no);
            $badInfos = $this->transPostArr($_POST['bad'],$len,'BadInfoForm',$mAttr);



            $transaction = Yii::$app->db->beginTransaction();
            try{
                //更新基本信息
                $person = $personForm->updateItem($id);
                //保存集团内部工作经历
                $kgwork = new KgWorks();
                $kgwork->card_no = $person->card_no;
                $kgwork->level = $person->level;
                $kgwork->post_1 = $person->post_1;
                $kgwork->post_2 = $person->post_2;
                $kgwork->post_3 = $person->post_3;
                $kgwork->post_4 = $person->post_4;
                $kgwork->begin_time = $person->hiredate;
                $kgwork->save();
                //更新工作经历
                foreach($works as $work){
                    $id = $work->id;
                    $work->updateItem($id);
                }
                //更新不良记录
                foreach($badInfos as $bad){
                    $id = $bad->id;
                    $bad->updateItem($id);
                }
                if(!$personForm->img_url){
                    $person->img_url = LoadFunc::UpLoadImg($personForm);
                    $person->save();
                }
                $transaction->commit();
                return $this->redirect(['persons/index']);
            }catch(\yii\base\Exception $e){
                $transaction->rollBack();
                return $this->render( 'update', [
                    'person' => $person,
                    'works' => $works,
                    'badInfos' => $badInfos,
                    'kgworks' => $kgworks,
                ]);
            }
        }

        return $this->render( 'update', [
            'person' => $person,
            'works' => $works,
            'badInfos' => $badInfos,
            'kgworks' => $kgworks,
        ]);
    }

    public function actionDelete()
    {
        $card_no = Yii:: $app-> request->post( 'id');
        $number = Persons::find()->select(['number'])->where('card_no=:card_no',[':card_no'=>$card_no])->one()->number;
        $transaction = Yii::$app->db->beginTransaction();
        try{
            WorkExperience::deleteAll(['card_no'=>$card_no]);
            BadInfo::deleteAll('card_no=:card_no',[':card_no'=>$card_no]);
            Persons::deleteAll('card_no=:card_no',[':card_no'=>$card_no]);
            KgWorks::deleteAll('card_no=:card_no',[':card_no'=>$card_no]);
            PostKey::deleteAll('key_no=:card_no',[':card_no'=>$card_no]);
            Reserve::deleteAll('reserve_no=:card_no',[':card_no'=>$card_no]);
            Admin::deleteAll('person_number=:number',[':number'=>$number]);
            $transaction->commit();
            return Json::encode(['status' =>true]);
        }catch(\yii\base\Exception $e){
            $transaction->rollBack();
            return Json:: encode(['status'=>false,'msg'=>'删除失败！原因：'.$e->getMessage()]);
        }
    }

    protected function findModel($id)
    {
        if (($model = Persons::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
