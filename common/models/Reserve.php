<?php

namespace common\models;

use Yii;
use common\models\base\BaseModel;
/**
 * This is the model class for table "reserve".
 *
 * @property integer $id
 * @property string $post_id
 * @property string $reserve_no
 */
class Reserve extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reserve';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id','reserve_no'], 'required'],
            [['post_id'], 'string', 'max' => 8],
            [['reserve_no'], 'string', 'max' => 18],
            [['reserve_no'], 'unique'],
            ['reserve_no', 'isInPerson'],
            [['reserve_no'],'match','pattern'=>'/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/'],
        ];
    }

    public function isInPerson(){
        if(!$this->hasErrors()){
            $card_no = $this->reserve_no;
            $data = Persons::find()->where('card_no=:card_no',[':card_no'=>$card_no])->one();
            if(is_null($data)){
                $this->addError('reserve_no','此员工基本信息不存在');
            }
        }

    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => '岗位编号',
            'reserve_no' => '身份证号码',
        ];
    }
}
