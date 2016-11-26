<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/9/5
 * Time: 9:53
 */

namespace common\func;
use common\models\Posts;
use yii\web\UploadedFile;
use yii\helpers\Url;
class LoadFunc
{
    public static function UpLoadImg($model){
        $image = UploadedFile::getInstance($model,'img');
        if($image){
            if($image instanceof UploadedFile || $image->error == UPLOAD_ERR_NO_FILE){
                $parentPath = $model->post_2;
                $imgSavePath = Url::to('@frontend/web/uploads/').$parentPath.'/';
                $imgPath = Url::to('uploads/').$parentPath.'/';
                if(!is_dir($imgSavePath)){
                    mkdir($imgSavePath,true);
                    chmod($imgSavePath,0777);

                }
                $imgName = time().'.'.$image->extension;
                $image->saveAs($imgSavePath .$imgName);
                return  '/'.$imgPath . $imgName;
            }else{
                return false;
            }
        }else{
            return null;
        }
    }

    public static function remove($path){
        unlink($path);
    }
}