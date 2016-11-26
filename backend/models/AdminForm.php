<?php
namespace backend\models;
use Yii;
use yii\base\Model;
use common\models\Admin;
use common\models\Persons;
class AdminForm extends Model
{
    public $username;
    public $role;
    public $password;
    public $repassword;
    public $person_number;


    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim','on'=>['reg', 'update']],
            ['username', 'required','on'=>['reg', 'update']],
            ['username', 'unique', 'targetClass' => '\common\models\Admin', 'message' => '此用户名已经被占用.','on'=>['reg', 'update']],
            ['username', 'string', 'min' => 2, 'max' => 16,'on'=>['reg','update']],
            ['username', 'match','pattern'=>'/^[(\x{4E00}-\x{9FA5})a-zA-Z]+[(\x{4E00}-\x{9FA5})a-zA-Z_\d]*$/u','message'=>'用户名由字母，汉字，数字，下划线组成，且不能以数字和下划线开头。','on'=>['reg','update']],

            ['person_number', 'unique','targetClass'=>'\common\models\Admin','message'=>'此员工编号已经存在','on'=>['reg', 'update']],
            ['person_number', 'string', 'max' => 12,'on'=>['reg', 'update']],
            ['person_number', 'isInPerson'],

            [['password','repassword'], 'required','on'=>['reg','restPassword']],
            ['password', 'string', 'min' => 6,'on'=>['reg','restPassword']],
            ['repassword','compare','compareAttribute'=>'password','message'=>'两次输入的密码不一致！','on'=>['reg','restPassword']],

            ['role', 'required','on'=>['reg','update']],
            ['role', 'string','min'=>4,'on'=>['reg','update']],


        ];
    }

    public function isInPerson(){
        if(!$this->hasErrors()){
            $person_number = $this->person_number;
            $data = Persons::find()->where('number = :number',[':number'=>$person_number])->one();
            if(is_null($data)){
                $this->addError('person_number','此员工编号不存在');
            }
        }
    }

    public function attributeLabels()
    {
        return [

            'username' => '用户名',
            'password' => '密码',
            'person_number' => '员工编号',
            'role' => '用户角色',
            'repassword' => '重复密码',
        ];
    }


    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new Admin();
        $user->username = $this->username;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->role = $this->role;
        $user->person_number = $this->person_number;
        return $user->save() ? $user : null;
    }
    public function restPassword($id){
        if (!$this->validate()) {
            return null;
        }
        $password = $this->password;
        $password_hash = Yii::$app->security->generatePasswordHash($password);
        $res = Admin::updateAll(['password_hash'=>$password_hash],['id'=>$id]);
        return $res > 0 ? true : false ;
    }
    public function update($id){
        if (!$this->validate()) {
            return null;
        }
        $res = Admin::updateAll(['username'=>$this->username,'role'=>$this->role,'person_number'=>$this->person_number],['id'=>$id]);
        return $res > 0 ? true : false ;
    }
}
