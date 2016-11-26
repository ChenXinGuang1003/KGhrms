<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "level".
 *
 * @property integer $id
 * @property integer $level_id
 * @property string $level_name
 * @property string $flag
 */
class Level extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'level';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level_id', 'level_name'], 'required'],
            [['level_id'], 'integer'],
            [['level_name'], 'string', 'max' => 15],
            [['flag'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'level_id' => 'Level ID',
            'level_name' => 'Level Name',
            'flag' => 'Flag',
        ];
    }
}
