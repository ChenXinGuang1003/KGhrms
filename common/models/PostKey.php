<?php

namespace common\models;
use common\models\base\BaseModel;
use Yii;
use yii\base\Exception;
/**
 * This is the model class for table "post_key".
 *
 * @property integer $id
 * @property string $post_id
 * @property string $key_no
 */
class PostKey extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_key';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'key_no'], 'required'],
            [['post_id'], 'string', 'max' => 8],
            [['key_no'], 'string', 'max' => 18],
            [['key_no'], 'unique'],
            [['key_no'],'match','pattern'=>'/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/'],
            ['key_no','isInPerson']
        ];
    }

    public function isInPerson(){
        if(!$this->hasErrors()){
            $card_no = $this->key_no;
            $data = Persons::find()->where('card_no = :card_no',[':card_no'=>$card_no])->one();
            if(is_null($data)){
                $this->addError('key_no','此员工基本信息不存在');
            }
        }
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => '岗位编号',
            'key_no' => '身份证号码',
        ];
    }


}
