<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/4/5
 * Time: 下午9:52
 */

namespace backend\controllers;

use backend\models\AdminRoles;
use backend\models\AdminRoleUser;
use backend\models\AgentInfo;
use backend\models\Customer;
use backend\models\CustomSearch;
use backend\models\DevRegist;
use backend\models\User;
use backend\models\UserInfo;
use yii;
use yii\data\Pagination;
use backend\models\Address;

class CustomerController extends BaseController
{
    //入网属性
        public $UserType=[
                            ''=>'',
                            0=>'',
                            1=>'自购',
                            2=>'押金',
                            3=>'买水送机',
                            4=>'买机送水',
                            5=>'免费',
                            99=>'其他',
                            ];
    //客户类型
        public $CustomerType=[
                                ''=>'',
                                0=>'',
                                1=>'家庭',
                                2=>'公司',
                                3=>'集团',
                                99=>'其他',
                                ];

    public function actionList()
    {



//        $username=$this->getParam("username");
//        $mobile=$this->getParam("mobile");
        $content=$this->getParam("content");
        $usetype=$this->getParam("usetype");
        $customertype=$this->getParam("customertype");
        $province=$this->getParam("province");
        $city=$this->getParam("city");
        $area=$this->getParam("area");
        $address=(new Address())->allQuery()->asArray()->all();
        $datas = CustomSearch::pageQuery($content,$usetype,$customertype,$province,$city,$area);
//        var_dump($datas);exit;
        $pages = new Pagination(['totalCount' => $datas->count(), 'defaultPageSize' => 10]);
//        var_dump($pages->offset,$pages->limit);exit;
        $model = $datas->offset($pages->offset)->limit($pages->limit)->asArray()->all();
//        var_dump($model);exit;
        //根据登陆者的信息，获取登陆者的角色
        $login_id=Yii::$app->user->id;
        //获取角色id
        $role_id=AdminRoleUser::findOne(['uid'=>$login_id])->role_id;


        return $this->render('list', [
            'usetype' => $usetype,
            'role_id' => $role_id,
            'customertype' => $customertype,
            'UserType' => $this->UserType,
            'CustomerType' => $this->CustomerType,
            'model' => $model,
            'pages' => $pages,
            'address'=>$address,
            'content'=>empty($content)?"":$content,
//            'username'=>empty($username)?"":$username,
//            'mobile'=>empty($mobile)?"":$mobile,
            'province'=>empty($province)?"":$province,
            'city'=>empty($city)?"":$city,
            'area'=>empty($area)?"":$area,
        ]);
    }

    //操作详情
    public function actionDetail(){
        $id=$this->getParam("id");
        $DevNo=$this->getParam("DevNo");
        $sql="select user_info.Tel, dev_regist.DevBindMobile,dev_regist.Province,dev_regist.City,dev_regist.Area, dev_action_log.*,dev_location.`Address`,dev_location.`Lat`,dev_location.`Lng` from dev_action_log
                    left join dev_location on dev_action_log.`DevNo`=dev_location.`DevNo`
                    left join dev_regist on dev_regist.DevNo=dev_action_log.`DevNo`
                    left join user_info on dev_regist.UserId=user_info.`Id`
                    where dev_action_log.UserId='{$id}' and dev_action_log.DevNO={$DevNo}";

        $datas=yii\db\ActiveRecord::findBySql($sql);
        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => 10]);
        $model=$datas->offset($pages->offset)->limit($pages->limit)->asArray()->all();

        return $this->render('detail',['model'=>$model,'pages'=>$pages]);

//        var_dump($model);
    }

    //修改用户
    public function actionUpdate($id){

        $devno=Yii::$app->request->get('devno');

        if(!$id||!$devno) return $this->render('/error/error', [
            'code' => '403',
            'name' => 'Params required',
            'message' => yii::t('app', "Id doesn't exit"),
        ]);
        //获取该用户信息
        $model=Customer::findone(['Id'=>$id]);
        //获取该用户id和设备编号对应的用户数据   客户类型、入网属性
        $data2=DevRegist::find()->where(['UserId'=>$id])->andWhere(['DevNo'=>$devno])->one();
        //获取地址数据
        $data=(new Address())->allQuery()->asArray()->all();

        if(!$model) return $this->render('/error/error', [
            'code' => '403',
            'name' => 'Params required',
            'message' => yii::t('app', "Id doesn't exit"),
        ]);

        if ( Yii::$app->request->isPost ) {

                //接收
                $model->load(Yii::$app->getRequest()->post());//userinfo表
                $data2->load(Yii::$app->getRequest()->post());//dev_regist表
                if($model->validate()&&$data2->validate()){
                    //创建事务
                    $transaction = Yii::$app->db->beginTransaction();
                    try{

                        if(!$model->save()){
                            throw new \Exception('保存失败！');
                        }
//                        $data2->Province=$model->Province;
//                        $data2->City=$model->City;
//                        $data2->Area=$model->Area;
//                        $data2->Address=$model->Address;
                        if(!$data2->save()){
                            throw new \Exception('保存失败！');
                        }

                        $transaction->commit();

                        Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
                        return $this->redirect(['list']);

                    }catch (yii\db\Exception $e) {
                        //回滚
                        $transaction->rollBack();
                        var_dump($e->getMessage());  //打印抛出的错误

                    }

                }else{
                    $errors = $model->getErrors();
                    $err = '';
                    foreach($errors as $v){
                        $err .= $v[0].'<br>';
                    }
                    Yii::$app->getSession()->setFlash('error', $err);
                }


        }

        return $this->render('update', [
            'model' => ["model"=>$model,"data"=>json_encode($data),'data2'=>$data2,],
        ]);
    }

    //删除用户
    public function actionDelete($id){

        if(!$id){
            Yii::$app->getSession()->setFlash('error', yii::t('app', 'Error'));
            return $this->redirect(['list']);

        }

        if(yii::$app->getRequest()->getIsAjax()){

            $model=CustomSearch::findOne(['id'=>$id]);
            if(!$model){
                Yii::$app->getSession()->setFlash('error', '该用户不存在');
                return $this->redirect(['list']);
            }
            //删除该用户(逻辑删除，将状态改为-1)
            $model->State=-1;
            if($model->save()){
                Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
                return $this->redirect(['list']);
            }else{
                Yii::$app->getSession()->setFlash('error', '删除失败');
                return $this->redirect(['list']);
            }

//            var_dump($model);exit;

        }else {
            Yii::$app->getSession()->setFlash('error', yii::t('app', 'Error'));
            return $this->redirect(['list']);
        }
    }



}