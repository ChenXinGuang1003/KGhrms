<?php
namespace backend\models;

use common\models\KgWorks;
use yii\base\Model;
use yii\db\Exception;

class KgworkForm extends Model
{
    public $id;
    public $card_no;
    public $begin_time;
    public $post_1;
    public $post_2;
    public $post_3;
    public $post_4;
    public $level;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_1', 'post_2','level'],'require'],
            [['post_1', 'post_2','post_3', 'post_4'], 'string', 'max' => 8],
            [['begin_time'], 'match','pattern'=>'/^((\d{4}(\-|\/|\.)\d{1,2}\1\d{1,2}$)|(\d{4}(\-|\/|\.)\d{1,2}))/'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'card_no' => '身份证号码',
            'begin_time' => '开始日期',
            'post_1' => '一级节点',
            'post_2' => '二级节点',
            'post_3' => '三级节点',
            'post_4' => '四级节点',
            'level' => '职务级别',
        ];
    }
    public function addItem(){
        if (!$this->validate()) {
            return false;
        }
        $work = new KgWorks();
        $work->card_no = $this->card_no;
        $work->begin_time = $this->begin_time;
        $work->level = $this->level;
        $work->post_1 = $this->post_1;
        $work->post_2 = $this->post_2;
        $work->post_3 = $this->post_3;
        $work->post_4 = $this->post_4;

        return $work->save() ? $work : false;
    }



    public function getItem($id) {
        $model = KgWorks:: findOne(['id'=>$id]);
        if(!$model)
            throw new \Exception( '编辑的信息不存在！' );
        $this-> attributes = $model->attributes;
        return $this;
    }

    public function updateItem($id){
        $model = KgWorks::findOne($id);
        if(!$model){
            $model = new KgWorks();
        }
        $model->attributes = $this->attributes;
        if($model->validate()){
            return $model->save()? $model : false;
        }else{
            return new Exception('工作记录提交失败，请重试');
        }
    }

}
