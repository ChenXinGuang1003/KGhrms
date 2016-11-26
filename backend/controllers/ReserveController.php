<?php

namespace backend\controllers;

use Yii;
use common\models\Reserve;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\helpers\Json;
/**
 * ReserveController implements the CRUD actions for Reserve model.
 */
class ReserveController extends MyController
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
        $model = new Reserve();

        $curPage = Yii::$app->request->get('page',1);
        $pageSize = Yii::$app->params['pageSize'];

        $type = Yii::$app->request->get('type');
        $value = Yii::$app->request->get('value');
        $search = ($type&&$value)?['like',$type,$value]:'';

        $query = Reserve::find()->orderBy('post_id ASC');
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
        $model = new Reserve();

        if (Yii::$app->request->isPost) {
            $post_id = $_POST['Reserve']['post_id'];
            $cardNoArr = $_POST['Reserve']['reserve_no'];
            $models=[];
            foreach($cardNoArr as $card){
                $model=new Reserve();
                $model->post_id=$post_id;
                $model->reserve_no = $card;
                $models[] = $model;
            }
            $transaction = Yii::$app->db->beginTransaction();
            try{
                foreach($models as $item){
                    $resSave = $item->save();
                    if(!$resSave){
                        throw new Exception('储备人员信息保存失败');
                    }
                }
                $transaction->commit();
                return $this->redirect(['index',]);
            }catch(Exception $e){
                $transaction->rollBack();
                return $this->render('create',['models'=>$models]);
            }

        } else {
            $models[] = $model;
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
        $model = Reserve::find()->where(['id'=>$id])->one();
        $res =  $model->delete();
        if(!$res)
            return Json:: encode(['status'=>false,'msg'=>'删除失败！']);

        return Json::encode(['status' =>true]);
    }


    protected function findModel($id)
    {
        if (($model = Reserve::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
