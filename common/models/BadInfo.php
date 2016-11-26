<?php

namespace common\models;

use common\models\base\BaseModel;
use Yii;

/**
 * This is the model class for table "bad_ifno".
 *
 * @property integer $id
 * @property string $card_no
 * @property string $bad_info
 * @property string $add_time
 * @property string $up_time
 */
class BadInfo extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bad_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['card_no', 'bad_time', 'bad_info', 'add_time'], 'required'],
            [['card_no'], 'match','pattern'=>'/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/'],
            [['bad_info'], 'string'],
            [['bad_time','add_time'], 'match','pattern'=>'/^((\d{4}(\-)\d{1,2}(\-)d{1,2}$)|(\d{4}(\-)\d{1,2}))/'],
            [['card_no'], 'string', 'max' => 18],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'card_no' => '身份证编号',
            'bad_info' => '不良记录信息',
            'add_time' => '创建日期',
        ];
    }
}
