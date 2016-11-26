<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;
use Yii;
/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $repassword;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim','on'=>'reg'],
            ['username', 'required','on'=>'reg'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.','on'=>'reg'],
            ['username', 'string', 'min' => 2, 'max' => 255,'on'=>'reg'],

            ['email', 'trim','on'=>'reg'],
            ['email', 'required','on'=>'reg'],
            ['email', 'email','on'=>'reg'],
            ['email', 'string', 'max' => 255,'on'=>'reg'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.','on'=>'reg'],

            ['password', 'required','on'=>['reg','restPassword']],
            ['password', 'string', 'min' => 6,'on'=>['reg','restPassword']],
            ['repassword', 'compare', 'compareAttribute' => 'password','message'=>'两次密码不一致','on'=>['restPassword']],
        ];
    }


    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        $this->scenario = 'reg';
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }

    public function restPassword($id){
        $this->scenario = 'restPassword';
        if (!$this->validate()) {
            return null;
        }
        $password = $this->password;
        $password_hash = Yii::$app->security->generatePasswordHash($password);
        $res = User::updateAll(['password_hash'=>$password_hash],['id'=>$id]);
        return $res > 0 ? true : false ;
    }
}
