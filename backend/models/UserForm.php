<?php
namespace backend\models;

use common\models\User;
use yii\base\Model;

class UserForm extends Model
{
    public $username;
    public $role;
    public $password;
    public $repassword;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => '此用户名已经被占用.'],
            ['username', 'string', 'min' => 2, 'max' => 16],
            ['username', 'match','pattern'=>'/^[(\x{4E00}-\x{9FA5})a-zA-Z]+[(\x{4E00}-\x{9FA5})a-zA-Z_\d]*$/u','message'=>'用户名由字母，汉字，数字，下划线组成，且不能以数字和下划线开头。'],

            [['password','repassword'], 'required'],
            ['password', 'string', 'min' => 6],
            ['repassword','compare','compareAttribute'=>'password','message'=>'两次输入的密码不一致！'],

            ['role', 'required'],
            ['role', 'string','min'=>4],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

            'username' => '用户名',
            'password' => '密码',
            'role' => '用户角色',
            'repassword' => '重复密码',
        ];
    }


    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->role = $this->role;
        
        return $user->save() ? $user : null;
    }

}
