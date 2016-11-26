<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "work_experience".
 *
 * @property integer $id
 * @property string $card_no
 * @property string $date_begin
 * @property string $date_end
 * @property string $company
 * @property string $post_name
 * @property string $desc
 */
class WorkExperience extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'work_experience';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['card_no'], 'required'],
            [['date_begin', 'date_end'], 'match','pattern'=>'/^((\d{4}(\-|\/|\.)\d{1,2}\1\d{1,2}$)|(\d{4}(\-|\/|\.)\d{1,2}))/'],
            [['desc','company','post_name','date_begin', 'date_end'], 'required'],
            ['desc', 'string','min'=>10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'card_no' => '身份证号码',
            'date_begin' => '开始日期',
            'date_end' => '结束日期',
            'company' => '工作单位',
            'post_name' => '工作岗位',
            'desc' => '工作描述',
        ];
    }



}
