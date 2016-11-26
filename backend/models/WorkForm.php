<?php
namespace backend\models;

use common\models\WorkExperience;
use yii\base\Model;
use yii\db\Exception;

class WorkForm extends Model
{
    public $id;
    public $card_no;
    public $date_begin;
    public $date_end;
    public $company;
    public $post_name;
    public $desc;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_begin', 'date_end'], 'match','pattern'=>'/^((\d{4}(\-|\/|\.)\d{1,2}\1\d{1,2}$)|(\d{4}(\-|\/|\.)\d{1,2}))/'],
            ['desc', 'string','min'=>10],
        ];
    }
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
    public function addItem(){
        if (!$this->validate()) {
            return false;
        }
        $work = new WorkExperience();
        $work->card_no = $this->card_no;
        $work->date_begin = $this->date_begin;
        $work->date_end = $this->date_end;
        $work->company = $this->company;
        $work->post_name = $this->post_name;
        $work->desc = $this->desc;

        return $work->save() ? $work : false;
    }



    public function getItem($id) {
        $model = WorkExperience:: findOne(['id'=>$id]);
        if(!$model)
            throw new \Exception( '编辑的信息不存在！' );

        $this-> attributes = $model->attributes;
        return $this;
    }

    public function updateItem($id){
        $model = WorkExperience::findOne($id);
        if(!$model){
            $model = new WorkExperience();
        }
        $model->attributes = $this->attributes;
        if($model->validate()){
            return $model->save()? $model : false;
        }else{
            return new Exception('工作记录提交失败，请重试');
        }
    }

}
