<?php

namespace backend\controllers;

use common\models\Persons;
use Yii;
use common\models\PostKey;
use yii\base\Exception;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
/**
 * PostKeyController implements the CRUD actions for PostKey model.
 */
class PostKeyController extends MyController
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
     * Lists all PostKey models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new PostKey();

        $curPage = Yii::$app->request->get('page',1);
        $pageSize = Yii::$app->params['pageSize'];

        $type = Yii::$app->request->get('type');
        $value = Yii::$app->request->get('value');
        $search = ($type&&$value)?['like',$type,$value]:'';

        $query = PostKey::find()->orderBy('post_id ASC');
        $data = $model->getPages($query,$curPage,$pageSize,$search);
        $pages = new Pagination(['totalCount'=>$data['count'],'pageSize' => $pageSize]);

        return $this->render('index',['data'=>$data,'pages'=>$pages]);
    }

    /**
     * Displays a single PostKey model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PostKey model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PostKey();
        if (Yii::$app->request->isPost) {
            $cardNoArr = $_POST['PostKey']['key_no'];
            $transaction = Yii::$app->db->beginTransaction();
            try{
                $models = [];
                foreach($cardNoArr as $cardNo){
                    $model = new PostKey();
                    $model->post_id = $_POST['PostKey']['post_id'];
                    $model->key_no = $cardNo;
                    $models[] = $model;
                }
                foreach($models as $item){
                    $res = Persons::updateAll(['is_key'=>'1'],['card_no'=>$item->key_no]);
                    if(!$res){
                        throw new Exception('人员基础关键岗位状态更新失败');
                    }
                    $resSave=$item->save();
                    if(!$resSave){
                        throw new Exception('关键岗位在岗人员保存失败');
                    }

                }
                $transaction->commit();
                return $this->redirect(['index']);
            }catch(Exception $e){
                $transaction->rollBack();
                return $this->render('create', [
                    'models' => $models
                ]);
            }
        } else {
            $models[]=$model;
            return $this->render('create', [
                'models' => $models,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }


    public function actionDelete()
    {
        $id = Yii:: $app-> request->post( 'id');
        $model = PostKey::find()->where(['id'=>$id])->one();
        $card_no = $model->key_no;
        $transaction = Yii::$app->db->beginTransaction();
        try{
            $resUpdate = Persons::updateAll(['is_key'=>'2'],['card_no'=>$card_no]);
            $res =  $model->delete();
            if(!$resUpdate || !$res){
                throw new Exception('删除操作失败');
            }
            $transaction->commit();
        }catch(Exception $e){
            $transaction->rollBack();
            return Json:: encode(['status'=>false,'msg'=>'删除失败！']);
        }
        return Json::encode(['status' =>true]);
    }

    /**
     * Finds the PostKey model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PostKey the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PostKey::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
