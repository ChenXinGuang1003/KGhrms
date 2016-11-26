<?php

namespace backend\controllers;

use common\models\Persons;
use common\models\PostKey;
use common\models\Reserve;
use Yii;
use common\models\Posts;
use yii\base\Exception;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\helpers\Json;

class PostsController extends MyController
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

    public function actionIndex()
    {
        $model = new Posts();

        $curPage = Yii::$app->request->get('page',1);
        $pageSize = Yii::$app->params['pageSize'];

        $type = Yii::$app->request->get('type');
        $value = Yii::$app->request->get('value');
        $search = ($type&&$value)?['like',$type,$value]:'';

        $query = Posts::find()->orderBy('post_id,flag ASC');
        $data = $model->getPages($query,$curPage,$pageSize,$search);
        $pages = new Pagination(['totalCount'=>$data['count'],'pageSize' => $pageSize]);

        return $this->render('index',['data'=>$data,'pages'=>$pages]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Posts();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    //如果该岗位下存在员工信息/储备员工/关键员工/子岗位，则禁止删除
    public function actionDelete()
    {
        $post_id = Yii:: $app-> request->post( 'id');
        $transaction = Yii::$app->db->beginTransaction();
        try{
            if(empty($post_id)){
                throw new Exception('缺少参数');
            }

            $post = Posts::find()->where('parent_id = :pid',[':pid'=>$post_id])->one();
            if($post){
                throw new Exception('该部门（岗位）下存在子部门（岗位），不允许删除');
            }

            $person = Persons::find()->where(['or',['post_1'=>$post_id],['post_2'=>$post_id],['post_3'=>$post_id],['post_4'=>$post_id],])->one();
            $person_key = PostKey::find()->where(['post_id'=>$post_id])->one();
            $reserve = Reserve::find()->where(['post_id'=>$post_id])->one();
            if($person || $person_key || $reserve){
                throw new Exception('该部门（岗位）存在人员信息，不允许删除');
            }

            $qurey = Reserve::find()->select(['reserve_no'])->where(['post_id'=>$post_id])->asArray()->all();
            $cardNoArr = array();
            foreach($qurey as $item){
                $cardNoArr[] = $item['reserve_no'];
            }

            Posts::deleteAll(['post_id'=>$post_id]);
            $transaction->commit();
            return Json::encode(['status' =>true]);
        }catch(Exception $e){
            $transaction->rollBack();
            return Json:: encode(['status'=>false,'msg'=>'删除失败！'.$e->getMessage()]);
        }
    }

    protected function findModel($id)
    {
        if (($model = Posts::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
