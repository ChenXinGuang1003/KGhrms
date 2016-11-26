<?php
namespace backend\controllers;
use common\models\Admin;
use yii\web\Controller;
use backend\models\AdminForm;
use Yii;
use yii\data\Pagination;
use yii\helpers\Json;
class AdminController extends Controller
{
    public function actionIndex(){
        $model = new Admin();

        $curPage = Yii::$app->request->get('page',1);
        $pageSize = Yii::$app->params['pageSize'];

        $type = Yii::$app->request->get('type');
        $value = Yii::$app->request->get('value');
        $search = ($type&&$value)?['like',$type,$value]:'';

        $query =  Admin::find()->where(['status'=>10,'role'=>['0005','0006']])->orderBy('created_at DESC');
        $data = $model->getPages($query,$curPage,$pageSize,$search);
        $pages = new Pagination(['totalCount'=>$data['count'],'pageSize' => $pageSize]);
        return $this->render('index',['data'=>$data,'pages'=>$pages]);

    }
    public function actionCreate()
    {
        $model = new AdminForm();
        if (Yii::$app->request->isPost) {
            $model->scenario='reg';
            $model->load(Yii::$app->request->post());
            if ($model->signup()) {
                return $this->redirect('index');
            }
        }
        return $this->render('create', [
            'model' => $model,
            'update'=>false
        ]);
    }

    public function actionUpdate($id){
        $admin = Admin::find()->where(['id'=>$id])->one();
        $form = new AdminForm();
        $form->username = $admin->username;
        $form->role = $admin->role;
        $form->person_number = $admin->person_number;
        $form->password = $admin->password_hash;
        $form->repassword = $admin->password_hash;
        if(Yii::$app->request->isPost){
            $form->scenario = 'update';
            $form->load(Yii::$app->request->post());
            if($form->update($id)){
                return $this->redirect(['index']);
            }
        }
        return $this->render('update',['model'=>$form,'update'=>true]);
    }

    public function actionRestPassword(){
        $form = new AdminForm();
        if(Yii::$app->request->isPost){
            $form->scenario = 'restPassword';
            $form->load(Yii::$app->request->post());
            $id = Yii::$app->user->identity->getId();
            if($form->restPassword($id)){
                Yii::$app->user->logout();
                return $this->goHome();
            }
        }
        return $this->render('restPassword',['model'=>$form]);
    }

    public function actionDelete(){
        $id = Yii:: $app-> request->post( 'id');
        $model = Admin::find()->where(['id'=>$id])->one();
        $res =  $model->delete();
        if(!$res)
            return Json:: encode(['status'=>false,'msg'=>'删除失败！']);

        return Json::encode(['status' =>true]);
    }
}