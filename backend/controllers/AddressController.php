<?php
namespace backend\controllers;

use backend\models\Address;
use Yii;
use yii\data\ArrayDataProvider;
use backend\models\Menu;
use backend\models\MenuSearch;
use yii\data\Pagination;
use yii\db\ActiveRecord;

/**
 * Menu controller
 */
class AddressController extends BaseController
{
    public $enableCsrfValidation = false;

    public function actionCreate2(){

        if(Yii::$app->request->isPost){
            $model=new Address();
            if($model->load(Yii::$app->request->post())&&$model->add()){
                Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
                return $this->redirect(['index']);
            }else{
                Yii::$app->getSession()->setFlash('error', "操作失败");
                $this->goBack();
            }
        }
        //获取所有的地址
        $data=(new Address())->allQuery()->asArray()->all();
        return $this->render("create",["data"=>json_encode($data)]);
    }//原来的，暂时没用

    public function actionCreate(){
        $urlobj = $this->getParam("Url");//返回参数记录
        //获取所有的地址
        $data=ActiveRecord::findBySql("select * from address_tree")->asArray()->all();
        if(Yii::$app->request->isPost){

            $model=new Address();
//            var_dump(Yii::$app->request->post());exit;
            if($model->load(Yii::$app->request->post())){
//                var_dump($model->Id);exit;
                //将该地址及上级地址改为已启用状态
                $model=$model->findOne(['Id'=>$model->Id]);//区域
//                var_dump($model);exit;
                if($model->IsUse!=1){//修改选择的地址
                    $re=$model->updateAll(['IsUse'=>1],['Id'=>$model->Id]);
                        if(!$re){
                            Yii::$app->getSession()->setFlash('error', "操作失败");
                            return $this->redirect(['index']);
                        }
                    //修改选择地址的上级状态
                    $Parent1=$model->findOne(['Id'=>$model->PId]);//上级
//                    var_dump($model->PId);exit;
                    if($Parent1&&$Parent1->IsUse!=1){//修改选择地址的上级状态
                        $re=$Parent1->updateAll(['IsUse'=>1],['Id'=>$Parent1->Id]);
                        if(!$re){
                            Yii::$app->getSession()->setFlash('error', "操作失败");
                            return $this->redirect(['index']);
                        }
                        $Parent2=$model->findOne(['Id'=>$Parent1->PId]);//上级
                        if($Parent2&&$Parent2->IsUse!=1){//没启用
                            $re=$Parent2->updateAll(['IsUse'=>1],['Id'=>$Parent2->Id]);
                            if(!$re){
                                Yii::$app->getSession()->setFlash('error', "操作失败");
                                return $this->redirect(['index']);
                            }
                        }

                    }
                    Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
                    return $this->redirect(['index']);
                }
                Yii::$app->getSession()->setFlash('error', "该地址已添加");
                return $this->redirect(['index']);
//                //验证该地址是否已创建
//                $re=ActiveRecord::findBySql("select `Name` from address_tree where `Name` like '$model->Name%' and PId=$model->PId ")->asArray()->one();
//                if($re){
//                    Yii::$app->getSession()->setFlash('error', "该地址已经创建过了！");
//                    return $this->render("create",["data"=>json_encode($data)]);
//                }
//
//                //判断是否是创建的市（创建的是市，生成编号）
//                $CityNumber='';
//                $pid=ActiveRecord::findBySql("select PId from address_tree where Id=$model->PId")->asArray()->one();
//                if($pid && $pid['PId']==0){//创建的是市
//                    //生成编号
//                    $precodeRes=ActiveRecord::findBySql("select max(`CityNumber`) as CityNumber from `address_tree`")->asArray()->one();
//                    $precode=intval($precodeRes["CityNumber"])+1;
//                    $CityNumber=str_pad($precode,3,"0",STR_PAD_LEFT);//用'0'填充左边到长度为3
////                    var_dump($CityNumber);exit;
//
//                }
//                if($model->add($CityNumber)){
//                    Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
//                    return $this->redirect(['index']);
//                }
//
//                Yii::$app->getSession()->setFlash('error', "操作失败");
//                $this->goBack();
            }
        }

        return $this->render("create",["data"=>json_encode($data),'url'=>$urlobj]);
    }

    //验证上级选择的是省或市
    public function actionCheck(){
        $addresses_id=$this->getParam('addresses_id');
        $pid=ActiveRecord::findBySql("select PId from address_tree where Id=$addresses_id")->asArray()->one()['PId'];
        if($pid==0){
            return $pid;
        }else{
            $data=ActiveRecord::findBySql("select `Name`,PId from address_tree where Id=$addresses_id")->asArray()->one();
            $cname=$data['Name'];
            $Pname=ActiveRecord::findBySql("select `Name` from address_tree where Id={$data['PId']}")->asArray()->one()['Name'];
            $re=['pname'=>$Pname,'cname'=>$cname];
            return $re;
        }

    }


    public function actionIndex()
    {
        $page_size = $this->getParam("per-page");//每页显示条数
        $page = $this->getParam("page");//第几页
        $sort = $this->getParam("sort");//排序
        if(!$sort){
            $sort=0;
        }
//var_dump($page_size,$page,$sort);exit;
        if(!$page_size){
            $page_size=10;
        }
        if(!$page){
            $page=1;
        }


        $datas =Address::allQuery();
        $count=ceil($datas->count()/$page_size);
        if($count<$page){//输入的页数大于总页数
            $page=$count;
        }

        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => $page_size]);
        //排序
        $order=" order by RowTime desc ";//默认降序
        if($sort && $sort%2==1){//奇数，升序
            $order=" order by RowTime asc ";
        }

        $querys =Address::pageQuery($pages->offset,$pages->limit,$order);
        $model = $querys->asArray()->all();
        //获取上级
        foreach($model as &$v){
            if($v['PId']!=0){//不属于省份
                $data=Address::findOne(['Id'=>$v['PId']]);

                $parent1=$data['Name'];
//                var_dump($parent1);exit;
                if($data['PId']!=0){
                    $data=Address::findOne(['Id'=>$data['PId']]);
                    $parent2=$data['Name'];

                    $v['parent']=$parent1.'-'.$parent2;

                }else{
                   $v['parent']=$parent1;
                }


            }else{
                $v['parent']='';
            }
        }



        $data=(new Address())->allQuery()->asArray()->all();
        return $this->render('index', [
            'model' => $model,
            'pages' => $pages,
            "data"=>json_encode($data),
            'page_size' => $page_size,
            'page' => $page,
            'sort' => $sort,
        ]);
    }

    public function actionDelete($id)
    {
        if(empty($id)){
            $this->jsonErrorReturn("参数错误");
            return;
        }

        //修改选择删除地址的状态
        $res1=Address::updateAll(['IsUse'=>0],['Id'=>$id]);
        if($res1){
            //判断是否有下级
            $next1=Address::find()->where(['PId'=>$id])->all();
            foreach($next1 as $v1){
                if($v1&&$v1->IsUse==1){
                    //修改选择删除地址下级的状态
                    $res2=Address::updateAll(['IsUse'=>0],['Id'=>$v1->Id]);
                    if($res2){
                        //再判断是否有下级
                        $next2=Address::find()->where(['PId'=>$v1->Id])->all();
                        foreach($next2 as $v2){
                            if($v2&&$v2->IsUse==1){
                                //修改选择删除地址下级的状态
                                Address::updateAll(['IsUse'=>0],['Id'=>$v2->Id]);
                            }
                        }

                    }
                }
            }

        }else{
            $this->jsonErrorReturn("操作失败");
            return;
        }


//        $res=Address::deleteAll("id=".$id);
//        if($res==false){
//            $this->jsonErrorReturn("操作失败");
//            return;
//        }
//        $this->jsonReturn(["state"=>0]);
        Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
        return $this->redirect(['index']);
    }

    public function actionInitCityNumber(){

        $datas=ActiveRecord::findBySql("select Id,PId from address_tree")->asArray()->all();
        foreach($datas as $data) {
            //判断上级是否是省
            $pid = ActiveRecord::findBySql("select PId from address_tree where Id={$data['PId']}")->asArray()->one();
            if ($pid && $pid['PId'] == 0) {//上级是省
                //生成编号
                $precodeRes = ActiveRecord::findBySql("select max(`CityNumber`) as CityNumber from `address_tree`")->asArray()->one();
                $precode = intval($precodeRes["CityNumber"]) + 1;
                $CityNumber = str_pad($precode, 3, "0", STR_PAD_LEFT);//用'0'填充左边到长度为3
                Yii::$app->db->createCommand("update address_tree set CityNumber='$CityNumber' where Id={$data['Id']}")->execute();

            }

        }
        echo '成功';
    }

}
