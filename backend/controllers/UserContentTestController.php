<?php
namespace backend\controllers;
//微信端我的里面功能按钮的挥度测试

use yii\base\Exception;
use yii\db\ActiveRecord;

class UserContentTestController extends BaseController{
    public function actionIndex(){
        return $this->renderPartial('index');
    }
    //ajax 获取列表数据
    public function actionGetIndexData(){
        $data=ActiveRecord::findBySql("
        select `id`,`version_number`,`content_address`,`describe`,`state`,`update_time`
        from user_content_test order by row_time desc")->asArray()->all();
        return json_encode($data);
    }
    //添加新版本的新增功能
    public function actionAddNewContent(){
        return $this->renderPartial('add-new-content');
    }
    //ajax 保存新增功能
    public function actionSaveNewContent(){
        $version_number=$this->getParam('version_number');//版本号
        $content_address=trim($this->getParam('content_address'));//功能地址
        $describe=$this->getParam('describe');//说明
        if(!$version_number||!$content_address||!$describe){
            return json_encode(['state'=>-1,'msg'=>'参数错误']);
        }
        $now=date('Y-m-d H:i:s');
        $sql="insert into user_content_test (`version_number`,`content_address`,`describe`,`state`,`row_time`,`update_time`)
        values('$version_number','$content_address','$describe',1,'$now','$now')";
        $re=\Yii::$app->db->createCommand($sql)->execute();
        if($re){
            return json_encode(['state'=>0]);
        }
        return json_encode(['state'=>-1,'msg'=>'失败']);
    }
    //修改
    public function actionEdit(){
        $id=$this->getParam('id');
        return $this->renderPartial('edit',['id'=>$id]);
    }
    //ajax 获取修改的数据
    public function actionGetEditData(){
        $id=$this->getParam('id');
        if(!$id){
            return json_encode(['state'=>-1,'msg'=>'参数错误']);
        }
        $data=ActiveRecord::findBySql("select `version_number`,`content_address`,`describe` from user_content_test where id=$id")->asArray()->one();
        return json_encode(['state'=>0,'data'=>$data]);
    }
    //ajax 保存修改
    public function actionSaveEdit(){
        $id=$this->getParam('id');
        $version_number=$this->getParam('version_number');//版本号
        $content_address=trim($this->getParam('content_address'));//功能地址
        $describe=$this->getParam('describe');//说明
        if(!$version_number||!$content_address||!$describe){
            return json_encode(['state'=>-1,'msg'=>'参数错误']);
        }
        $now=date('Y-m-d H:i:s');
        $sql="update user_content_test set `version_number`='$version_number',`content_address`='$content_address',`describe`='$describe',`update_time`='$now' where id=$id";
        $re=\Yii::$app->db->createCommand($sql)->execute();
        if($re){
            return json_encode(['state'=>0]);
        }
        return json_encode(['state'=>-1,'msg'=>'失败']);
    }
    //ajax 将新功能设置成默认功能
    public function actionEditState(){
        $id=$this->getParam('id');
        if(!$id){
            return json_encode(['state'=>-1,'msg'=>'参数错误']);
        }
        //判断是否还有其他新功能
        $data=ActiveRecord::findBySql("select id from user_content_test where state=1 and id <> $id")->asArray()->one();
        $sql='';
        if(!$data){//没有其他新功能了
           //将勾选了体验新功能的用户取消
            $sql="update user_info set IsUse=0 where IsUse=1";
        }
        $now=date('Y-m-d H:i:s');
        $transaction=\Yii::$app->db->beginTransaction();
        try{
            if($sql){
                $re=\Yii::$app->db->createCommand($sql)->execute();
                if(!$re){
                    throw new Exception('取消用户体验新功能失败');
                }
            }
            $re=\Yii::$app->db->createCommand("update user_content_test set `state`=2,`update_time`='$now' where id=$id")->execute();
            if(!$re){
                throw new Exception('设置成默认功能失败');
            }
            $transaction->commit();
            return json_encode(['state'=>0]);
        }catch (Exception $e){
            $transaction->rollBack();
            return json_encode(['state'=>-1,'msg'=>$e->getMessage()]);
        }
    }
}
