<?php
namespace frontend\controllers;

use Yii;

use frontend\models\LoginForm;
use frontend\models\SignupForm;
use common\models\Posts;


/**
 * Site controller
 */
class SiteController extends MyController
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $this->layout='login';
        if (!Yii::$app->user->isGuest) {

            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $this->getNavList();
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    public function getNavList(){
        $data = Posts::find()->where(['flag'=>'1','is_key'=>'1'])->asArray()->all();
        Yii::$app->session->set('navList', $data);
    }
    /*public function getNavList(){
        $data = Posts::find()->where(['flag'=>'1'])->asArray()->all();
        if(count($data)>0){
            self::setNavlist($data);
        }
    }
    public function setNavlist($data){
        $navList = array();
        foreach($data as $item){
            $pid = $item['parent_id'];
            if(!$pid){
                $id = $item['id'];
                $key = 'nav_'.$id;
                $navList[$key] = $item;
                $navList['sub']=[];
                $data = ArrayFunc::arrayRemoveItem($id,$data);
            }else{
                if($item['parent_id']==$pid){

                }
            }
        }
        return $navList;
    }*/
    /*public function getNavList()
    {
        //遍历一级目录
        $CompanyList = Company::find()->where(['flag'=>'1'])->asArray()->all();

        //遍历二级目录
        $departList = Depart::find()->where(['flag'=>'1'])->asArray()->all();

        //遍历三级目录
        $postList = Post::find()->where(['flag'=>'1'])->asArray()->all();

        $navList = array();
        if(count($CompanyList)>0){
            foreach($CompanyList as $company){
                $cid = $company['company_id'];
                $keyCompany = 'nav_' . $cid;
                $navList[$keyCompany] = $company;
                $navList[$keyCompany]['sub'] = [];
                $departList = ArrayFunc::arrayRemoveItem($cid,$departList);
                foreach ($departList as $depart) {
                    $dItem  = array();
                    $did = $depart['depart_id'];
                    $keyDepart = 'nav_' . $did;
                    if($depart['company_id'] == $cid){
                        $dItem['depart_id'] = $did;
                        $dItem['depart_name'] = $depart['depart_name'];
                        $dItem['sub'] =[];
                        $navList[$keyCompany]['sub'][$keyDepart]=$dItem;

                        foreach($postList as $post){
                            $pItem = array();
                            if($post['depart']==$did){
                                $pItem['post_name']=$post['post_name'];
                                $pItem['post_id']=$post['post_id'];
                                $navList[$keyCompany]['sub'][$keyDepart]['sub'][]=$pItem;
                            }
                        }
                    }

                }
            }

            Yii::$app->session->set('navList', $navList);
        }
    }*/
    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionRestPassword(){
        $form = new SignupForm();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $form->password = $post['SignupForm']['password'];
            $form->repassword = $post['SignupForm']['repassword'];
            $id = Yii::$app->user->identity->getId();
            if($form->restPassword($id)){
                Yii::$app->user->logout();
                return $this->goHome();
            }
        }
        return $this->render('restPassword',['model'=>$form]);
    }
}
