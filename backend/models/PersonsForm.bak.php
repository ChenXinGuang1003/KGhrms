<?php
namespace frontend\models;

use common\models\Persons;
use common\models\WorkExperience;
use yii\base\Model;
use common\models\User;

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
    public $post;
    public $depart;
    public $hiredate;
    public $edu;
    public $nation;
    public $img;
    public $status;
    public $company;
    public $date_begin;
    public $date_end;
    public $desc;
    public $post_name;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['card_no','number', 'name', 'post', 'depart', 'status'], 'required'],
            ['card_no','match','pattern'=>'/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/'],
            ['card_no', 'unique','targetClass'=>'\common\models\Persons','message'=>'此身份证号已经存在'],
            ['number', 'unique','targetClass'=>'\common\models\Persons','message'=>'此员工编号已经存在'],

            [['birth','hiredate','date_begin', 'date_end'], 'match','pattern'=>'/^((\d{4}(\-|\/|\.)\d{1,2}\1\d{1,2}$)|(\d{4}(\-|\/|\.)\d{1,2}))/'],

            [['number'], 'string', 'max' => 12],
            [['name', 'edu'], 'string', 'max' => 5],
            [['post', 'depart'], 'string', 'max' => 6],
            [['sex', 'status'], 'string', 'max' => 1],
            [['nation'], 'string', 'max' => 6],
            ['img','file','extensions'=>['png','jpg'], 'mimeTypes' => 'image/jpeg, image/png','maxSize'=>1*1024*1024],

            [['desc','company','post_name','date_begin', 'date_end'], 'required'],
            ['desc', 'string','min'=>10],
        ];
    }
    public function attributeLabels()
    {
        return [
            'card_no' => '身份证号',
            'number' => '员工编号',
            'name' => '员工姓名',
            'post' => '所在岗位',
            'depart' => '所属公司',
            'hiredate' => '入职日期',
            'sex' => '性别',
            'birth' => '出生日期',
            'edu' => '最高学历',
            'nation' => '民族',
            'status' => '在职状态',
        ];
    }


}
