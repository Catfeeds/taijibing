<?php
namespace app\controllers;
use yii\db\ActiveRecord;
use yii\web\Controller;

class TestController extends Controller{
//    public function actionIndex(){
//        $datas=ActiveRecord::findBySql("select * from send_water_log")->asArray()->all();
//        var_dump($datas);exit;
//    }
//
//    public function actionAdd(){
//        $sql="insert into send_water_log (DevNo,WaterBrandNo,WaterGoodsId,Volume,Amount,UseMoney,RestMoney,SendTime,Price,State)
// Values('2083111273','846fa28b6a8ca935bb8f31635d857cbc',24,7.5,2,30,100,'2018-02-05',15,1)";
//
//        $re=\Yii::$app->db->createCommand($sql)->execute();
//        var_dump($re);
//    }
//
//    public function actionDel(){
//        $re=\Yii::$app->db->createCommand("delete from send_water_log where Id=41")->execute();
//        var_dump($re);
//    }

    public function actionSaoMa(){

        return $this->renderPartial('test');
    }
}
