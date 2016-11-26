<?php
namespace backend\models;

use common\models\Persons;
use yii\base\Model;
use yii\db\Exception;
/**
 * Signup form
 */
class PersonsForm extends Model
{
    public $card_no;
    public $name;
    public $number;
    public $birth;
    public $sex;
    public $post_1;
    public $post_2;
    public $post_3;
    public $post_4;
    public $hiredate;
    public $level;
    public $edu;
    public $nation;
    public $img;
    public $img_url;
    public $status;
    public $is_key;



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['card_no', 'number', 'name', 'post_1', 'post_2','level', 'status','hiredate'], 'required'],
            ['card_no','match','pattern'=>'/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/'],
            ['card_no', 'unique','targetClass'=>'\common\models\Persons','message'=>'此身份证号已经存在'],

            ['number', 'unique','targetClass'=>'\common\models\Persons','message'=>'此员工编号已经存在'],
            [['number'], 'string', 'max' => 12],

            [['birth','hiredate'], 'match','pattern'=>'/^((\d{4}(\-)\d{1,2}(\-)d{1,2}$)|(\d{4}(\-)\d{1,2}))/'],
            [['level'], 'integer'],
            [['name', 'edu'], 'string', 'max' => 5],
            [['post_1', 'post_2','post_3', 'post_4'], 'string', 'max' => 8],
            [['sex', 'is_key','status'], 'string', 'max' => 1],
            [['nation'], 'string', 'max' => 6],
            ['img','file','extensions'=>['png','jpg'], 'mimeTypes' => 'image/jpeg, image/png','maxSize'=>1*1024*1024],
            [['img_url'], 'string', 'max' => 60],

        ];
    }
    public function attributeLabels()
    {
        return [
            'card_no' => '身份证号',
            'number' => '员工编号',
            'name' => '员工姓名',
            'post_1' => '一级节点',
            'post_2' => '二级节点',
            'post_3' => '三级节点',
            'post_4' => '四级节点',
            'level' => '职务级别',
            'hiredate' => '入职日期',
            'sex' => '性别',
            'birth' => '出生日期',
            'edu' => '最高学历',
            'nation' => '民族',
            'status' => '在职状态',
            'is_key' => '关键岗',
        ];
    }
    public function addItem()
    {
        if (!$this->validate()) {
            foreach($this->getErrors() as $error){
                throw new Exception($error[0]);
            }
        }
        $person = new Persons();
        $person->card_no = $this->card_no;
        $person->number = $this->number;
        $person->name = $this->name;
        $person->level = $this->level;
        $person->post_1 = $this->post_1;
        $person->post_2 = $this->post_2;
        $person->post_3 = $this->post_3;
        $person->post_4 = $this->post_4;
        $person->hiredate = $this->hiredate;
        $person->sex = $this->sex;
        $person->birth = $this->birth;
        $person->edu = $this->edu;
        $person->nation = $this->nation;
        $person->is_key = $this->is_key;
        $person->status = $this->status;
        $person->img_url = $this->img_url ? $this->img_url : '';

        return $person->save() ? $person : false;

    }


    public function getItem($id) {
        $model = Persons:: findOne(['id'=>$id]);
        if(!$model)
            throw new \Exception( '编辑的员工信息不存在！' );

        $this-> attributes = $model->attributes;
        $this->img = $model->img_url;
        return $this;
    }

    public function updateItem($id){
        $model = Persons::findOne($id);
        $model->attributes = $this->attributes;
        return $model->save()? $model : false;
    }

}
