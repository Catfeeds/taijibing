<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/31
 * Time: 17:01
 */
namespace backend\controllers;

use backend\models\AgentInfo;
use backend\models\DevFactory;
use backend\models\FactoryInfo;
use yii;
use backend\models\AdminRoles;
use backend\models\User;
use yii\data\ActiveDataProvider;
use backend\models\AdminRoleUser;
use backend\models\Address;
class AdminUserController extends BaseController
{

//    public function getIndexData()
//    {
//
//        $query = User::find();
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//            'sort' => [
//                'defaultOrder' => [
//                    'created_at' => SORT_ASC,
//                ]
//            ]
//        ]);
//        return [
//            'dataProvider' => $dataProvider,
//        ];
//    }
    public function actionIndex(){
        $datas=User::find();
        $pages=new yii\data\Pagination(['totalCount' => $datas->count(), 'pageSize' => 10]);
        $model=$datas->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        return $this->render('index2',['model'=>$model,'pages'=>$pages]);
    }



    public function actionCreate()
    {
        $model = new User();//admin_user表
        $model->setScenario('create');


        //获取地址数据
        $data=(new Address())->allQuery()->asArray()->all();


        if(yii::$app->getRequest()->getIsPost()){
            $model->load(Yii::$app->getRequest()->post());
            $model->password_hash=Yii::$app->security->generatePasswordHash($model->password);
            $rolesModel = new AdminRoleUser();//admin_role_user 用户和角色关联表
            if($model->type=='管理员'){
                $model->logic_type=0;
                $rolesModel->role_id=1;
            }
            if($model->type=='水厂'){
                $model->logic_type=1;
                $rolesModel->role_id=2;
            }
            if($model->type=='设备厂家运营中心'){
                $model->logic_type=2;
                $rolesModel->role_id=3;
            }
            if($model->type=='运营中心'){
                $model->logic_type=3;
                $rolesModel->role_id=4;
            }
            if($model->type=='服务中心'){
                $model->logic_type=4;
                $rolesModel->role_id=5;
            }


//            var_dump($model->validate());exit;
            $transaction=Yii::$app->db->beginTransaction();
            try{

                if(!$model->validate()|| !$model->save()){//保存到admin_user
                    throw new yii\db\Exception('操作失败1');
//                    throw new yii\db\Exception($model->getFirstErrors());
                }


                $rolesModel->uid = $model->getPrimaryKey();
                $rolesModel->created_at = time();
                if(!$rolesModel->save()){//保存到admin_role_user表
                    throw new yii\db\Exception('操作失败2');
                }

                //根据logic_type 再保存到对应的表
                if($model->logic_type==1){
                    //水厂
                    $res=   (new FactoryInfo())->insertBaseInfo($model["id"],$model["username"],$model["name"],
                        $model["address"],$model["tel"],$model["contacts"],
                        $model["province"],$model["city"],
                        $model["area"],$model["lng"],$model["lat"],
                        $model["password"]);
                }
                if($model->logic_type==2){
                    //设备厂家
                    $res=  (new DevFactory())->insertBaseInfo($model["id"],$model["username"],
                        $model["name"],$model["address"],$model["tel"],$model["contacts"],
                        $model["province"],$model["city"],$model["area"],$model["lng"],
                        $model["lat"],$model['password']);
//                    $res=   (new DevFactory())->insertBaseInfo($model["username"],$model["password"]);
                }
                if($model->logic_type==3||$model->logic_type==4){

                    if($model->logic_type==3){
                        $ParentId=0;
                    }else{
                        $ParentId=AgentInfo::findOne(['Name'=>$model->agent])->Id;
                    }



                    //区域代理(agent_info Level 4:运营中心  5：服务中心)
                    $res=   (new AgentInfo())->insertBaseInfo($ParentId,$model["id"],$model["username"],$model['name'],
                        $model["tel"],$model["contacts"],$model["address"],
                        $model["province"],$model["password"],$model["city"],
                        $model["area"],$model["lng"],$model["lat"],$model->logic_type);
//                    var_dump($res);exit;
                }

                if(!$res){
                    throw new yii\db\Exception('操作失败3');
//                    throw new yii\db\Exception($model->getFirstErrors());
                }

                $transaction->commit();
                \Yii::$app->getSession()->setFlash('success', \Yii::t('app', 'Success'));
                return $this->redirect(['index']);

            }catch (yii\db\Exception $e){

                $transaction->rollBack();
//                var_dump($e->getMessage());exit;

                Yii::$app->getSession()->setFlash('error', $e->getMessage());

                return $this->redirect(['index']);


            }


//            var_dump($model->type);exit;

        }
//        else{
//            $errors = $model->getErrors();
//            $err = '';
//            foreach($errors as $v){
//                $err .= $v[0].'<br>';
//            }
//            Yii::$app->getSession()->setFlash('error', $err);
//        }

            //先将用户保存到admin_user表，再根据logic_type判断再次保存到对应的表

//            if($model->validate() && $rolesModel->load(yii::$app->getRequest()->post()) && $rolesModel->validate() && $model->save() ){
//                $rolesModel->uid = $model->getPrimaryKey();
//                $rolesModel->save();
//                Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
//                $logic_type=$model['logic_type'];
//                if($logic_type==1){
//                    //水厂
//              $res=   (new FactoryInfo())->insertBaseInfo($model["username"],$model["password"]);
//                }
//                if($logic_type==2){
//                    //设备厂家
//                    (new DevFactory())->insertBaseInfo($model["username"],$model["password"]);
//                }
//                if($logic_type==3||$logic_type==4){
//                    //区域代理(agent_info Level 4:运营中心  5：服务中心)
//                  (new AgentInfo())->insertBaseInfo($model["username"],$model["password"],$logic_type);
//                }
//
//                return $this->redirect(['index']);
//            }else{
//                $errors = $model->getErrors();
//                $err = '';
//                foreach($errors as $v){
//                    $err .= $v[0].'<br>';
//                }
//                Yii::$app->getSession()->setFlash('error', $err);
//            }

//        $temp = AdminRoles::find()->asArray()->all();//从admin_role表获取所有角色
//        $roles = [];
//        foreach ($temp as $v){
//            $roles[$v['id']] = $v['role_name'];
//        }
        return $this->render('create', [
            'model' => ["model"=>$model,
                        "data"=>json_encode($data),

//            'model' => $model,
//                        'rolesModel' => $rolesModel,
//                        'roles' => $roles
 ]
        ]);
    }

        public function actionUpdate($id)
    {
        if(empty($id)){
            Yii::$app->getSession()->setFlash('error', "参数错误");
            $this->goBack();
            exit();
        }
        //获取地址数据
        $data=(new Address())->allQuery()->asArray()->all();

//        $model = (new User())->findOne(['id'=>$id]);
        $model = User::findOne(['id'=>$id]);
            $logic_type=$model->logic_type;
            $password=$model->password;
//        var_dump($logic_type);exit;
        $model->setScenario('update');

            if(yii::$app->getRequest()->getIsPost()){
                $datas=Yii::$app->request->post();
//                var_dump($datas);exit;
                $model->username=$datas['User']['username'];
                $model->email=$datas['User']['email'];
                $model->updated_at=time();
                $model->contacts=$datas['User']['contacts'];
                $model->tel=$datas['User']['tel'];
                $model->name=$datas['User']['name'];
                $model->province=$datas['User']['province'];
                $model->city=$datas['User']['city'];
                $model->area=$datas['User']['area'];
                $model->address=$datas['User']['address'];
                $model->lng=$datas['User']['lng'];
                $model->lat=$datas['User']['lat'];
                $model->type=$datas['User']['type'];
                $model->agent=isset($datas['User']['agent'])?$datas['User']['agent']:'';

//                var_dump($datas['User']['name']);exit;

                $rolesModel = (new AdminRoleUser())->findOne(['uid'=>$id]);//admin_role_user 用户和角色关联表
                if($model->type=='管理员'){
                    $model->logic_type=0;
                    $rolesModel->role_id=1;
                }
                if($model->type=='水厂'){
                    $model->logic_type=1;
                    $rolesModel->role_id=2;
                }
                if($model->type=='设备厂家'){
                    $model->logic_type=2;
                    $rolesModel->role_id=4;
                }
                if($model->type=='运营中心'){
                    $model->logic_type=3;
                    $rolesModel->role_id=3;
                }
                if($model->type=='服务中心'){
                    $model->logic_type=4;
                    $rolesModel->role_id=5;
                }


//            var_dump($model->validate());exit;
                $transaction=Yii::$app->db->beginTransaction();
                try{

                    if(!$model->save(false)){//保存到admin_user
                        throw new yii\db\Exception('操作失败1');
//                    throw new yii\db\Exception($model->getFirstErrors());
                    }


//                    $rolesModel->uid = $model->getPrimaryKey();
                    $rolesModel->updated_at = time();
                    if(!$rolesModel->save()){//保存到admin_role_user表
                        throw new yii\db\Exception('操作失败2');
                    }

                    //根据$logic_type 再保存到对应的表
                    if($logic_type==$model->logic_type && $model->logic_type==1){//没有修改账户类型
                        //水厂
                        $res=   (new FactoryInfo())->findOne(['Admin_User_Id'=>$id])->insertBaseInfo($id,$model["username"],$model["name"],
                            $model["address"],$model["tel"],$model["contacts"],
                            $model["province"],$model["city"],
                            $model["area"],$model["lng"],$model["lat"],
                            $model["password"]);
                    }
                    if($logic_type==$model->logic_type && $model->logic_type==2){
                        //设备厂家
                        $res=  (new DevFactory())->findOne(['Admin_User_Id'=>$id])->insertBaseInfo($id,$model["username"],
                            $model["name"],$model["address"],$model["tel"],$model["contacts"],
                            $model["province"],$model["city"],$model["area"],$model["lng"],
                            $model["lat"],$model['password']);
//                    $res=   (new DevFactory())->insertBaseInfo($model["username"],$model["password"]);
                    }
                    if(($logic_type==$model->logic_type && $model->logic_type==3)||($logic_type==$model->logic_type && $model->logic_type==4)){

                        if($model->logic_type==3){
                            $ParentId=0;
                        }else{
                            $ParentId=AgentInfo::findOne(['Name'=>$model->agent])->Id;
                        }

                        //区域代理(agent_info Level 4:运营中心  5：服务中心)
                        $res=   (new AgentInfo())->findOne(['Admin_User_Id'=>$id])->insertBaseInfo($ParentId,$id,$model["username"],$model['name'],
                            $model["tel"],$model["contacts"],$model["address"],
                            $model["province"],$model["password"],$model["city"],
                            $model["area"],$model["lng"],$model["lat"],$model->logic_type);
//                    var_dump($res);exit;
                    }

                    //修改了账户类型
                    if($logic_type!=$model->logic_type){
                        //先删除原来的
                        if($logic_type==1){//水厂
                            $data=FactoryInfo::findOne(['Admin_User_Id'=>$id]);
                            if($data){
                               $re= $data->delete();
                            }
                        }
                        if($logic_type==2){//设备厂家
                            $data=DevFactory::findOne(['Admin_User_Id'=>$id]);
                            if($data){
                                $re= $data->delete();
                            }
                        }
                        if($logic_type==3 || $logic_type==4){//代理
                            $data=AgentInfo::findOne(['Admin_User_Id'=>$id]);
                            if($data){
                                $re= $data->delete();
                            }
                        }

                        if(!$re){//删除原来的失败
                            throw new yii\db\Exception('操作失败3');
                        }



                        //根据$model->logic_type 再保存到对应的表

                        if($model->logic_type==1){//水厂
                            //水厂
                            $res=   (new FactoryInfo())->insertBaseInfo($id,$model["username"],$model["name"],
                                $model["address"],$model["tel"],$model["contacts"],
                                $model["province"],$model["city"],
                                $model["area"],$model["lng"],$model["lat"],
                                $password);
                        }
                        if($model->logic_type==2){//设备厂家
                            //设备厂家
                            $res=  (new DevFactory())->insertBaseInfo($id,$model["username"],
                                $model["name"],$model["address"],$model["tel"],$model["contacts"],
                                $model["province"],$model["city"],$model["area"],$model["lng"],
                                $model["lat"],$password);
//                    $res=   (new DevFactory())->insertBaseInfo($model["username"],$model["password"]);
                        }
                        if($model->logic_type==3||$model->logic_type==4){//区域代理

                            //区域代理(agent_info Level 4:运营中心  5：服务中心)
                            $res=   (new AgentInfo())->insertBaseInfo($id,$model["username"],$model['name'],
                                $model["tel"],$model["contacts"],$model["address"],
                                $model["province"],$password,$model["city"],
                                $model["area"],$model["lng"],$model["lat"],$model->logic_type);
//                    var_dump($res);exit;
                        }


                    }




                    if(!$res){
                        throw new yii\db\Exception('操作失败4');
//                    throw new yii\db\Exception($model->getFirstErrors());
                    }

                    $transaction->commit();
                    \Yii::$app->getSession()->setFlash('success', \Yii::t('app', 'Success'));
                    return $this->redirect(['index']);

                }catch (yii\db\Exception $e){

                    $transaction->rollBack();
//                var_dump($e->getMessage());exit;

                    Yii::$app->getSession()->setFlash('error', $e->getMessage());

                    return $this->redirect(['index']);


                }


//            var_dump($model->type);exit;

            }

//        $temp = AdminRoles::find()->asArray()->all();
//        $roles = [];
//        foreach ($temp as $v){
//            $roles[$v['id']] = $v['role_name'];
//        }
            return $this->render('update2', [
                'model' => ["model"=>$model,
                    "data"=>json_encode($data),

//            'model' => $model,
//                        'rolesModel' => $rolesModel,
//                        'roles' => $roles
                ]
            ]);
    }





//    public function actionUpdate($id)
//    {
//        $model = $this->getModel($id);
////        var_dump($model);exit;
//        $model->setScenario('update');
//        $rolesModel = AdminRoleUser::findOne(['uid'=>$id]);
//        if($rolesModel == NULL){
//            $rolesModel = new AdminRoleUser();
//            $rolesModel->uid = $id;
//        }
//        if ( Yii::$app->getRequest()->getIsPost() ) {
//            if( $model->load(Yii::$app->request->post()) && $model->validate() && $rolesModel->load(yii::$app->getRequest()->post()) && $rolesModel->validate() && $model->save() && $rolesModel->save() ){
//                Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
//
//                return $this->redirect(['update', 'id'=>$model->getPrimaryKey()]);
//            }else{
//                $errors = $model->getErrors();
//                $err = '';
//                foreach($errors as $v){
//                    $err .= $v[0].'<br>';
//                }
//                Yii::$app->getSession()->setFlash('error', $err);
//            }
//            $model = User::findOne(['id'=>yii::$app->getUser()->getIdentity()->getId()]);
//        }
//
//        $temp = AdminRoles::find()->asArray()->all();
//        $roles = [];
//        foreach ($temp as $v){
//            $roles[$v['id']] = $v['role_name'];
//        }
//        return $this->render('update', [
//            'model' => $model,
//            'rolesModel' => $rolesModel,
//            'roles' => $roles
//        ]);
//    }

    public function getModel($id = '')
    {
        return User::findOne(['id'=>$id]);
    }

    public function actionUpdateSelf()
    {
        $model = User::findOne(['id'=>yii::$app->getUser()->getIdentity()->getId()]);
        $model->setScenario('self-update');
        if(yii::$app->getRequest()->getIsPost()){
            if( $model->validate() && $model->load(yii::$app->getRequest()->post()) && $model->self_update() ){
                Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
            }else{
                $errors = $model->getErrors();
                $err = '';
                foreach($errors as $v){
                    $err .= $v[0].'<br>';
                }
                Yii::$app->getSession()->setFlash('error', $err);
            }
            $model = User::findOne(['id'=>yii::$app->getUser()->getIdentity()->getId()]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionUpdateSelfAvatar()
    {
        $model = User::findOne(['id'=>yii::$app->getUser()->getIdentity()->getId()]);
        $model->setScenario('update');
        if(yii::$app->getRequest()->getIsPost() && $model->validate() && $model->load(yii::$app->getRequest()->post()) && $model->save()){
            return $this->redirect(['site/main']);
        }
        return $this->render('update-self-avatar', [
            'model' => $model,
        ]);
    }

    public function actionAssign($uid='')
    {
        $model = AdminRoleUser::findOne(['uid'=>$uid]);//->createCommand()->getRawSql();var_dump($model);die;
        if($model == ''){//echo 11;die;
            $model = new AdminRoleUser();
        }
        $model->uid = $uid;
        if( yii::$app->getRequest()->getIsPost() ){
            if($model->load(yii::$app->getRequest()->post()) && $model->save()){
                Yii::$app->getSession()->setFlash('success', yii::t('app', 'success'));
            }else{//var_dump($model->getErrors());die;
                $errors = $model->getErrors();
                $err = '';
                foreach($errors as $v){
                    $err .= $v[0].'<br>';
                }
                Yii::$app->getSession()->setFlash('error', $err);
            }
        }
        $temp = AdminRoles::find()->asArray()->all();
        $roles = [];
        foreach ($temp as $v){
            $roles[$v['id']] = $v['role_name'];
        }
        return $this->render('assign', [
            'model' => $model,
            'roles' => $roles,
        ]);
    }

    //js根据地址获取对应的运营中心数据
    public function actionGetAgent(){
        $province=Yii::$app->request->get('province');
        $city=Yii::$app->request->get('city');
        $area=Yii::$app->request->get('area');
        $where='where Level=4';
        if($province){
            $where.=" and Province='{$province}'";
        }
        if($city){
            $where.=" and City='{$city}'";

        }
        if($area){
            $where.=" and Area='{$area}'";

        }
        $sql="select Name from agent_info ".$where;
//var_dump($sql);exit;
        $agents=AgentInfo::findBySql($sql)->asArray()->all();
//        var_dump($agents);exit;
        return $agents;

    }

    //删除
    public function actionDelete($id)
    {
        if(empty($id)){
            $this->jsonErrorReturn("参数错误");
            return;
        }
        $admin_user=User::findOne(['id'=>$id]);
        $admin_user->delete();
        $res=$admin_user->delete();
//        if($res===false){
//            $this->jsonErrorReturn("操作错误,请稍后再试");
//            return ;
//        }
//        $this->jsonReturn(["state"=>0]);
        $transaction=Yii::$app->db->beginTransaction();
        try{

            if(!$res){//admin_user 删除失败
                throw new yii\db\Exception('操作失败1');
//                    throw new yii\db\Exception($model->getFirstErrors());
            }

            if($admin_user->logic_type==1){//水厂
                $res=FactoryInfo::findOne(['Admin_User_Id'=>$id])->delete();
                if(!$res){
                    throw new yii\db\Exception('操作失败2');
                }
            }

            if($admin_user->logic_type==3 || $admin_user->logic_type==4){//运营中心
                $res=AgentInfo::findOne(['Admin_User_Id'=>$id])->delete();
                if(!$res){
                    throw new yii\db\Exception('操作失败3');
                }
            }

            if($admin_user->logic_type==2){//设备厂家
                $res=DevFactory::findOne(['Admin_User_Id'=>$id])->delete();
                if(!$res){
                    throw new yii\db\Exception('操作失败4');
                }
            }
            $res=AdminRoleUser::findOne(['uid'=>$id])->delete();
            if(!$res){
                throw new yii\db\Exception('操作失败5');
            }

            $transaction->commit();
            $this->jsonReturn(["state"=>0]);

        }catch (yii\db\Exception $e){

            $transaction->rollBack();
//                var_dump($e->getMessage());exit;
            $this->jsonReturn(["state"=>-1]);


        }

    }



}