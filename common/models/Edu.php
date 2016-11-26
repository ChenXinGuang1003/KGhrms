<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "edu".
 *
 * @property integer $id
 * @property string $edu_id
 * @property string $edu_name
 * @property string $flag
 */
class Edu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'edu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['edu_id', 'edu_name'], 'required'],
            [['edu_id'], 'string', 'max' => 2],
            [['edu_name'], 'string', 'max' => 6],
            [['flag'], 'string', 'max' => 1],
            [['edu_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'edu_id' => 'Edu ID',
            'edu_name' => 'Edu Name',
            'flag' => 'Flag',
        ];
    }
}
