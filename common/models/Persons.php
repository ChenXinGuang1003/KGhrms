<?php

namespace common\models;

use Yii;
use yii\db\Exception;
use common\models\base\BaseModel;
/**
 * This is the model class for table "persons".
 *
 * @property integer $id
 * @property string $card_no
 * @property string $number
 * @property string $name
 * @property integer $level
 * @property string $post_1
 * @property string $post_2
 * @property string $post_3
 * @property string $post_4
 * @property string $hiredate
 * @property string $sex
 * @property string $birth
 * @property string $edu
 * @property string $nation
 * @property string $img_url
 * @property string $is_key
 * @property string $status
 */
class Persons extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'persons';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['card_no', 'number', 'name', 'post_1', 'post_2','level', 'status','hiredate'], 'required'],
            [['level'], 'integer'],
            [['hiredate', 'birth'], 'safe'],
            [['card_no'], 'string', 'max' => 18],
            [['number'], 'string', 'max' => 12],
            [['card_no'], 'unique', 'message' => '此身份证号已经存在'],
            [['number'], 'unique', 'message' => '此员工编号已经存在'],
            [['name', 'edu'], 'string', 'max' => 5],
            [['post_1', 'post_2','post_3', 'post_4',], 'string', 'max' => 8],
            [['sex', 'status','is_key'], 'string', 'max' => 1],
            [['sex', 'is_key'], 'default', 'value' => '0'],
            [['nation'], 'string', 'max' => 21],
            [['img_url'], 'string', 'max' => 60],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'card_no' => 'Card No',
            'number' => 'Number',
            'name' => 'Name',
            'level' => 'Level',
            'post_1' => 'Post 1',
            'post_2' => 'Post 2',
            'post_3' => 'Post 3',
            'post_4' => 'Post 4',
            'hiredate' => 'Hiredate',
            'sex' => 'Sex',
            'birth' => 'Birth',
            'edu' => 'Edu',
            'nation' => 'Nation',
            'img_url' => 'Img Url',
            'is_key' => 'Is Key',
            'status' => 'Status',
        ];
    }
    /*public function addItem()
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
        $person->post = $this->post;
        $person->depart = $this->depart;
        $person->hiredate = $this->hiredate;
        $person->sex = $this->sex;
        $person->birth = $this->birth;
        $person->edu = $this->edu;
        $person->nation = $this->nation;
        $person->status = $this->status;

        return $person->save() ? $person : false;
    }*/
}
