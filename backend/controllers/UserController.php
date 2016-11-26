<?php
namespace backend\controllers;
use Yii;
use yii\web\Controller;
use common\models\User;
use yii\data\Pagination;
use backend\models\UserForm;
class UserController extends Controller
{
    public function actionIndex(){
        $model = new User();

        $curPage = Yii::$app->request->get('page',1);
        $pageSize = Yii::$app->params['pageSize'];

        $type = Yii::$app->request->get('type');
        $value = Yii::$app->request->get('value');
        $search = ($type&&$value)?['like',$type,$value]:'';

        $query =  User::find()->where(['status'=>10,'role'=>['0002','0003','0004']])->orderBy('created_at DESC');
        $data = $model->getPages($query,$curPage,$pageSize,$search);
        $pages = new Pagination(['totalCount'=>$data['count'],'pageSize' => $pageSize]);
        return $this->render('index',['data'=>$data,'pages'=>$pages]);

    }
    public function actionCreate()
    {
        $model = new UserForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                return $this->redirect('index');
            }
            $model->password='';
            $model->repassword='';
        }

        return $this->render('create', [
            'model' => $model,
            'update'=>false
        ]);
    }

    public function actionUpdate($id){
        $admin = User::find()->where(['id'=>$id])->one();
        $form = new UserForm();
        $form->username = $admin->username;
        $form->role = $admin->role;
        $form->password = $admin->password_hash;
        $form->repassword = $admin->password_hash;
        if($form->load(Yii::$app->request->post())){
            $res = User::updateAll(['username'=>$form->username,'role'=>$form->role],['id'=>$id]);
            if($res>0){
                return $this->redirect(['index']);
            }
        }
        return $this->render('update',['model'=>$form,'update'=>true]);
    }
}