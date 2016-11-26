<?php

namespace common\models;

use common\models\base\BaseModel;
use Yii;

/**
 * This is the model class for table "posts".
 *
 * @property integer $id
 * @property string $post_id
 * @property string $post_name
 * @property string $parent_id
 * @property integer $order_id
 * @property string $flag
 */
class Posts extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id','post_name'], 'required'],
            [['order_id'], 'integer'],
            [['post_id'], 'string', 'max' => 12],
            [['post_name'], 'string', 'max' => 15],
            [['parent_id'], 'string', 'max' => 8],
            [['is_key','flag'], 'string', 'max' => 1],
            [['post_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => '部门（岗位）编号',
            'post_name' => '部门（岗位）名称',
            'parent_id' => '父级部门（岗位）ID',
            'order_id' => '顺序ID',
            'is_key' => '是否关键岗',
            'flag' => '启用状态',
        ];
    }
}
