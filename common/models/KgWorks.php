<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "kg_works".
 *
 * @property string $id
 * @property string $card_no
 * @property string $begin_time
 * @property string $post_1
 * @property string $post_2
 * @property string $post_3
 * @property string $post_4
 * @property integer $level
 */
class KgWorks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kg_works';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['card_no', 'begin_time', 'post_1', 'post_2', 'level'], 'required'],
            [['begin_time'], 'safe'],
            [['level'], 'integer'],
            [['card_no', 'post_1', 'post_2', 'post_3', 'post_4'], 'string', 'max' => 255],
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
            'begin_time' => 'Begin Time',
            'post_1' => 'Post 1',
            'post_2' => 'Post 2',
            'post_3' => 'Post 3',
            'post_4' => 'Post 4',
            'level' => 'Level',
        ];
    }

    public function addItem($data){
        $this->card_no = $data->card_no;
        $this->begin_time = $data->hiredate;
        $this->level = $data->level;
        $this->post_1 = $data->post_1;
        $this->post_2 = $data->post_2;
        $this->post_3 = $data->post_3;
        $this->post_4 = $data->post_4;

        return $this->save() ? $this : false;
    }
}
