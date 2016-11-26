<?php

namespace backend\controllers;

use common\func\FilterFunc;
use Yii;
use common\models\BadInfo;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
/**
 * BadIfnoController implements the CRUD actions for BadIfno model.
 */
class BadInfoController extends Controller
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
     * Lists all BadIfno models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new BadInfo();
        //分页
        $curPage = Yii:: $app-> request->get( 'page',1);
        $pageSize = Yii::$app->params['pageSize'];
        //搜索
        $type = Yii:: $app-> request->get( 'type', '');
        $value = Yii:: $app-> request->get( 'value', '');
        $search = ($type&&$value)?[ 'like',$type,$value]: '';
        //查询语句
        $query = $model->find()->orderBy( 'add_time ASC');
        $data = $model->getPages($query,$curPage,$pageSize,$search);
        $pages = new Pagination([ 'totalCount' =>$data[ 'count'], 'pageSize' => $pageSize]);

        return $this->render('index',['pages'=>$pages,'data'=>$data]);
    }

    /**
     * Displays a single BadIfno model.
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
     * Creates a new BadIfno model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BadInfo();

        if ($model->load(Yii::$app->request->post())) {
            $model->add_time = FilterFunc::convert(time());
            $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing BadIfno model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->add_time = time();
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing BadIfno model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
        $id = Yii:: $app-> request->post( 'id');
        $model = BadInfo::find()->where(['id'=>$id])->one();
        $res =  $model->delete();
        if(!$res)
            return Json:: encode(['status'=>false,'msg'=>'删除失败！']);

        return Json::encode(['status' =>true]);
    }

    /**
     * Finds the BadIfno model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BadInfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BadInfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
