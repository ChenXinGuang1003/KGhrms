<?php
namespace backend\models;

use common\models\BadInfo;
use yii\base\Exception;
use yii\base\Model;
/**
 * Signup form
 */
class BadInfoForm extends Model
{
    public $id;
    public $bad_time;
    public $bad_info;
    public $card_no;
    public $add_time;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['bad_info', 'string','min'=>10],
            [['bad_time'], 'match','pattern'=>'/^((\d{4}(\-)\d{1,2}(\-)d{1,2}$)|(\d{4}(\-)\d{1,2}))/'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'bad_time' => '日期',
            'bad_info' => '描述',
        ];
    }
    public function addItem(){
        if (!$this->validate()) {
            return false;
        }
        $model = new BadInfo();
        $model->card_no = $this->card_no;
        $model->add_time = $this->add_time;
        $model->bad_time = $this->bad_time;
        $model->bad_info = $this->bad_info;

        return $model->save() ? $model : false;
    }



    public function getItem($id) {
        $model = BadInfo:: findOne(['id'=>$id]);
        if(!$model)
            throw new \Exception( '编辑的信息不存在！' );

        $this-> attributes = $model->attributes;
        return $this;
    }

    public function updateItem($id){
        $model = BadInfo::findOne($id);
        if(!$model){
            $model = new BadInfo();
        }
        $model->attributes = $this->attributes;
        $model->add_time = date("Y-m-d");
        if($model->validate()){
            return $model->save()? $model : false;
        }else{
            return new Exception('违规记录提交失败，请重试');
        }
    }
}
