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

        //根据登陆者的信息，获取登陆者的角色
        $login_id=Yii::$app->user->id;
        //获取角色id
        $role_id=AdminRoleUser::findOne(['uid'=>$login_id])->role_id;

        $username=User::findOne(['id'=>$login_id])->username;

        $data=AgentInfo::findOne(['LoginName'=>$username]);
//        var_dump($data);exit;

        if($data){
            $parent_id=$data->Id;
        }else{
            $parent_id=-1;
        }
//        var_dump($parent_id);exit;

        if($role_id==3){//运营中心
            //获取对应运营中心下的服务中心账号
            $datas=yii\db\ActiveRecord::findBySql("select agent_info.*,admin_user.type,admin_user.email,admin_user.created_at,admin_user.updated_at from agent_info JOIN admin_user on agent_info.LoginName=admin_user.username where agent_info.ParentId=$parent_id");
//var_dump($datas);exit;
//            $datas=AgentInfo::find()->where(['ParentId'=>$parentid]);

        }else{

            $datas=yii\db\ActiveRecord::findBySql("select * from (select a.Id,a.LoginName,a.Name,a.Province,a.City,a.Area,a.ContractUser,a.ContractTel,d.email,d.type,d.created_at,d.updated_at from agent_info as a JOIN admin_user as d ON a.LoginName=d.username
                                            UNION select a.Id,a.LoginName,a.Name,a.Province,a.City,a.Area,a.ContractUser,a.ContractTel,d.email,d.type,d.created_at,d.updated_at from factory_info as a JOIN admin_user as d ON a.LoginName=d.username
                                            UNION select a.Id,a.LoginName,a.Name,a.Province,a.City,a.Area,a.ContractUser,a.ContractTel,d.email,d.type,d.created_at,d.updated_at from dev_factory as a JOIN admin_user as d ON a.LoginName=d.username) as temp order by created_at desc
                                             ");
        }
//        var_dump($data_agent_info,$data_dev_factory,$data_factory_info);exit;

        $pages=new yii\data\Pagination(['totalCount' => $datas->count(), 'pageSize' => 10]);
        $model=$datas->offset($pages->offset)->limit($pages->limit)->asArray()->all();
//        var_dump($model);exit;
        return $this->render('index2',['model'=>$model,'pages'=>$pages]);
    }

//    public function getIndexData()
//    {
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



    public function actionCreate()
    {
        $model = new User();//admin_user表
        $model->setScenario('create');


        //获取地址数据
        $data=(new Address())->allQuery()->asArray()->all();


        if(yii::$app->getRequest()->getIsPost()){
            $model->load(Yii::$app->getRequest()->post());

            $mesge=$this->CheckUser($model);
//            var_dump($mesge);exit;
            if($mesge){
                Yii::$app->getSession()->setFlash('error', $mesge);
                return $this->render('create', [
                    'model' => ["model"=>$model,
                        "data"=>json_encode($data),
                    ]
                ]);
            }



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
//                var_dump($model->save());exit;

                if(!$model->validate()|| !$model->save()){//保存到admin_user
                    throw new yii\db\Exception('操作失败1');
//                    throw new yii\db\Exception($model->getFirstErrors());
                }


                $rolesModel->uid = $model->getPrimaryKey();
                $rolesModel->created_at = time();
                if(!$rolesModel->save()){//保存到admin_role_user表
                    throw new yii\db\Exception('操作失败2');
                }

//                var_dump($model->logic_type);exit;

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

//                    var_dump($ParentId);exit;

                    //区域代理(agent_info Level 4:运营中心  5：服务中心)
                    $res=   (new AgentInfo())->insertBaseInfo($ParentId,$model["id"],$model["username"],$model['name'],
                        $model["tel"],$model["contacts"],$model["address"],
                        $model["province"],$model["city"],
                        $model["area"],$model["lng"],$model["lat"],$model->logic_type,$model["password"]);
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

        public function actionUpdate($LoginName)
    {
        if(empty($LoginName)){
            Yii::$app->getSession()->setFlash('error', "参数错误");
            $this->goBack();
            exit();
        }



        //获取地址数据
        $data=(new Address())->allQuery()->asArray()->all();

//        $model = (new User())->findOne(['id'=>$id]);
//            var_dump($id);exit;

            //判断修改的数据来自哪张表
            $admin_user = User::findOne(['username'=>$LoginName]);
            $logic_type=$admin_user->logic_type;
            $id=$admin_user->id;
            $agent_info=AgentInfo::findOne(['LoginName'=>$LoginName]);
            $dev_factory=DevFactory::findOne(['LoginName'=>$LoginName]);
            $factory_info=FactoryInfo::findOne(['LoginName'=>$LoginName]);
            if($agent_info){
                $model=$agent_info;
                $name='AgentInfo';
            }
            if($dev_factory){
                $model=$dev_factory;
                $name='DevFactory';
            }
            if($factory_info){
                $model=$factory_info;
                $name='FactoryInfo';
            }





//            $username=$model->username;
//            var_dump($model);exit;

//        var_dump($logic_type);exit;
        $model->setScenario('update');
        $admin_user->setScenario('update');

            if(yii::$app->getRequest()->getIsPost()){
//                var_dump( $model);
                $model->load(yii::$app->getRequest()->Post());
//                var_dump( $model->Province,$model->City,$model->Area);exit;
                $model->RowTime=date("Y-m-d H:i:s");
//                $admin_user->load(yii::$app->getRequest()->Post());//email、type、agent
                $datas=(yii::$app->getRequest()->Post());//email、type、agent
                $user=$datas['User'];//email、type、agent
//var_dump($admin_user);exit;
//                var_dump( $model->Name,$model->LoginName,$model->Area);exit;
//var_dump($model->LoginName);exit;
//                $model->LoginPwd=md5($admin_user->);
                $admin_user->username=$model->LoginName;
                $admin_user->updated_at=time();
                $admin_user->contacts=$model->ContractUser;
                $admin_user->tel=$model->ContractTel;
                $admin_user->name=$model->Name;
                $admin_user->province=$model->Province;
                $admin_user->city=$model->City;
                $admin_user->area=$model->Area;
                $admin_user->address=$model->Address;
                $admin_user->lat=$model->BaiDuLat;
                $admin_user->lng=$model->BaiDuLng;
                $admin_user->agent=$user['agent'];
                $admin_user->email=$user['email'];
//                var_dump($admin_user->agent);exit;



                $AdminRoleUser = (new AdminRoleUser())->findOne(['uid'=>$id]);//admin_role_user 用户和角色关联表

                if($user['type']=='管理员'){
                    $admin_user->logic_type=0;
                    $admin_user->type='管理员';
                    $AdminRoleUser->role_id=1;
                }
                if($user['type']=='水厂'){
                    $admin_user->logic_type=1;
                    $admin_user->type='水厂';
                    $AdminRoleUser->role_id=2;
                }
                if($user['type']=='设备厂家'){
                    $admin_user->logic_type=2;
                    $admin_user->type='设备厂家';
                    $AdminRoleUser->role_id=4;
                }
                if($user['type']=='运营中心'){
                    $admin_user->logic_type=3;
                    $admin_user->type='运营中心';
                    $AdminRoleUser->role_id=3;
                }
                if($user['type']=='服务中心'){
                    $admin_user->logic_type=4;
                    $admin_user->type='服务中心';
                    $AdminRoleUser->role_id=5;
                }

//var_dump($model,$admin_user);exit;

//                var_dump($admin_user);exit;

//                $logic_type=$admin_user->logic_type;
//                $password=$admin_user->password;
//                $datas=Yii::$app->request->post();
//                var_dump($datas);exit;
//                $model->username=$datas['User']['username'];
//                $model->email=$datas['User']['email'];
//                $model->updated_at=time();
//                $model->contacts=$datas['User']['contacts'];
//                $model->tel=$datas['User']['tel'];
//                $model->name=$datas['User']['name'];
//                $model->province=$datas['User']['province'];
//                $model->city=$datas['User']['city'];
//                $model->area=$datas['User']['area'];
//                $model->address=$datas['User']['address'];
//                $model->lng=$datas['User']['lng'];
//                $model->lat=$datas['User']['lat'];
//                $model->type=$datas['User']['type'];
//                $model->agent=isset($datas['User']['agent'])?$datas['User']['agent']:'';

//                var_dump($datas['User']['name']);exit;






//                $rolesModel = (new AdminRoleUser())->findOne(['uid'=>$id]);//admin_role_user 用户和角色关联表
//                if($model->type=='管理员'){
//                    $model->logic_type=0;
//                    $rolesModel->role_id=1;
//                }
//                if($model->type=='水厂'){
//                    $model->logic_type=1;
//                    $rolesModel->role_id=2;
//                }
//                if($model->type=='设备厂家'){
//                    $model->logic_type=2;
//                    $rolesModel->role_id=4;
//                }
//                if($model->type=='运营中心'){
//                    $model->logic_type=3;
//                    $rolesModel->role_id=3;
//                }
//                if($model->type=='服务中心'){
//                    $model->logic_type=4;
//                    $rolesModel->role_id=5;
//                }




//            var_dump($model->validate());exit;
                $transaction=Yii::$app->db->beginTransaction();
                try{

                    if(!$admin_user->save(false)){//保存到admin_user
                        throw new yii\db\Exception('admin_user表操作失败1');
//                    throw new yii\db\Exception($model->getFirstErrors());
                    }


//                    $rolesModel->uid = $model->getPrimaryKey();
                    $AdminRoleUser->updated_at = time();
                    if(!$AdminRoleUser->validate()||!$AdminRoleUser->save()){//保存到admin_role_user表
                        throw new yii\db\Exception('admin_role_user表操作失败2');
                    }

                    //根据$logic_type 再保存到对应的表
//                    if($logic_type==$admin_user->logic_type && $admin_user->logic_type==1){//没有修改账户类型
//                        //水厂
//
//                        $res=   (new FactoryInfo())->findOne(['LoginName'=>$LoginName])->insertBaseInfo($id,$model["username"],$model["name"],
//                            $model["address"],$model["tel"],$model["contacts"],
//                            $model["province"],$model["city"],
//                            $model["area"],$model["lng"],$model["lat"],
//                            $model["password"]);
//                    }
//                    if($logic_type==$admin_user->logic_type && $admin_user->logic_type==2){
//                        //设备厂家
//                        $res=  (new DevFactory())->findOne(['LoginName'=>$LoginName])->insertBaseInfo($id,$model["username"],
//                            $model["name"],$model["address"],$model["tel"],$model["contacts"],
//                            $model["province"],$model["city"],$model["area"],$model["lng"],
//                            $model["lat"],$model['password']);
////                    $res=   (new DevFactory())->insertBaseInfo($model["username"],$model["password"]);
//                    }
//                    if(($logic_type==$admin_user->logic_type && $admin_user->logic_type==3)||($logic_type==$admin_user->logic_type && $admin_user->logic_type==4)){
//
//                        if($model->logic_type==3){
//                            $ParentId=0;
//                        }else{
//                            $ParentId=AgentInfo::findOne(['Name'=>$model->agent])->Id;
//                        }
//
//                        //区域代理(agent_info Level 4:运营中心  5：服务中心)
//                        $res=   (new AgentInfo())->findOne(['LoginName'=>$LoginName])->insertBaseInfo($ParentId,$id,$model["username"],$model['name'],
//                            $model["tel"],$model["contacts"],$model["address"],
//                            $model["province"],$model["password"],$model["city"],
//                            $model["area"],$model["lng"],$model["lat"],$model->logic_type);
////                    var_dump($res);exit;
//                    }

                    //修改了账户类型
                    if($logic_type!=$admin_user->logic_type){
                        //先删除原来的
                        if($logic_type==1){//水厂
                            $data=FactoryInfo::findOne(['LoginName'=>$LoginName]);
                            if($data){
                               $re= $data->delete();
                                if(!$re){//删除原来的失败
                                    throw new yii\db\Exception('FactoryInfo操作失败3');
                                }
                            }
                        }
                        if($logic_type==2){//设备厂家
                            $data=DevFactory::findOne(['LoginName'=>$LoginName]);
                            if($data){
                                $re= $data->delete();
                                if(!$re){//删除原来的失败
                                    throw new yii\db\Exception('DevFactory操作失败3');
                                }
                            }
                        }
                        if($logic_type==3 || $logic_type==4){//代理
                            $data=AgentInfo::findOne(['LoginName'=>$LoginName]);
                            if($data){
                                $re= $data->delete();
                                if(!$re){//删除原来的失败
                                    throw new yii\db\Exception('AgentInfo操作失败3');
                                }
                            }
                        }

//                        if(!$re){//删除原来的失败
//                            throw new yii\db\Exception('操作失败3');
//                        }



                        //根据$admin_user->logic_type 再保存到对应的表

                        if($admin_user->logic_type==1){//水厂
                            //水厂
                            $res=   (new FactoryInfo())->insertBaseInfo2($id,$model->LoginName,$model->Name,
                                $model->Address,$model->ContractTel,$model->ContractUser,
                                $model->Province,$model->City,
                                $model->Area,$model->BaiDuLng,$model->BaiDuLat
                                );

                            if(!$res){
                                throw new yii\db\Exception('FactoryInfo操作失败4');
                            }

                        }
                        if($admin_user->logic_type==2){//设备厂家
                            //设备厂家
                            $res=  (new DevFactory())->insertBaseInfo2($id,$model->LoginName,$model->Name,
                                $model->Address,$model->ContractTel,$model->ContractUser,
                                $model->Province,$model->City,
                                $model->Area,$model->BaiDuLng,$model->BaiDuLat);
                            if(!$res){
                                throw new yii\db\Exception('DevFactory操作失败4');
                            }
//                    $res=   (new DevFactory())->insertBaseInfo($model["username"],$model["password"]);
                        }
                        if($admin_user->logic_type==3||$admin_user->logic_type==4){//区域代理

                            if($admin_user->logic_type==3){
                            $ParentId=0;
                        }else{
                            $ParentId=AgentInfo::findOne(['Name'=>$admin_user->agent])->Id;

                        }
                            //区域代理(agent_info Level 4:运营中心  5：服务中心)
                            $res=   (new AgentInfo())->insertBaseInfo2($ParentId,$id,$model->LoginName,$model->Name,
                                $model->Address,$model->ContractTel,$model->ContractUser,
                                $model->Province,$model->City,
                                $model->Area,$model->BaiDuLng,$model->BaiDuLat,$admin_user->logic_type);
//                    var_dump($res);exit;
                            if(!$res){
                                throw new yii\db\Exception('AgentInfo操作失败4');
                            }
                        }


                    }else{
                        //直接保存
//                        $model->setScenario("create");
//                        var_dump($model->validate());exit;
                        if(!$model->validate()||!$model->save()){


                            throw new yii\db\Exception('操作失败5');
                        }
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

            //根据登陆者的信息，获取登陆者的角色
            $login_id=Yii::$app->user->id;
            $LogiName=User::findOne(['id'=>$login_id])->username;
            $dat=AgentInfo::findOne(['LoginName'=>$LogiName]);
            $agent='';
            if($dat){
                $agent=$dat->Name;
            }

//            $agent=User::findOne(['Id'=>$login_id])->agent;
//            var_dump($login_id,$agent);exit;
//            $dat=Address::findOne(['Name'=>$agent]);
            //获取角色id
            $role_id=AdminRoleUser::findOne(['uid'=>$login_id])->role_id;


            return $this->render('update2', [
                "name"=>$name,
                'model' => ["model"=>$model,
                    'role_id'=>$role_id,
                    'agent'=>$agent,
                    "data"=>json_encode($data),
                    "admin_user"=>$admin_user,


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
    public function actionDelete($LoginName)
    {
        if(empty($LoginName)){
            $this->jsonErrorReturn("参数错误");
            return;
        }
        $admin_user=User::findOne(['username'=>$LoginName]);
//        var_dump($admin_user,$admin_user->logic_type);exit;
//        $admin_user->delete();

        if(!$admin_user){
            $this->jsonErrorReturn("该账号不存在");
            return ;
        }
//        $this->jsonReturn(["state"=>0]);
        $transaction=Yii::$app->db->beginTransaction();
        try{
            $res=$admin_user->delete();

//var_dump($res);exit;

            if(!$res){//admin_user 删除失败
                throw new yii\db\Exception('操作失败1');
//                    throw new yii\db\Exception($model->getFirstErrors());
            }

            if($admin_user->logic_type==1){//水厂
                $data=FactoryInfo::findOne(['LoginName'=>$LoginName]);
                if($data){
                    $res=$data->delete();
                    if(!$res){
                        throw new yii\db\Exception('操作失败2');
                    }
                }


            }

            if($admin_user->logic_type==3 || $admin_user->logic_type==4){//运营中心
                $data=AgentInfo::findOne(['LoginName'=>$LoginName]);
                if($data){
                    $res=$data->delete();
                    if(!$res){
                        throw new yii\db\Exception('操作失败3');
                    }
                }


            }

            if($admin_user->logic_type==2){//设备厂家
                $data=DevFactory::findOne(['LoginName'=>$LoginName]);
                if($data){
                    $res=$data->delete();
                    if(!$res){
                        throw new yii\db\Exception('操作失败4');
                    }
                }

            }

            $id=$admin_user->id;

            $data=AdminRoleUser::findOne(['uid'=>$id]);
            if($data){
                $res=$data->delete();
                if(!$res){
                    throw new yii\db\Exception('操作失败5');
                }
            }

            if(!$res){
                throw new yii\db\Exception('操作失败6');
            }



            $transaction->commit();
//            return $this->redirect(yii::$app->request->headers['referer']);
            $this->jsonReturn(["state"=>0]);

        }catch (yii\db\Exception $e){

            $transaction->rollBack();
//                var_dump($e->getMessage());exit;
            $this->jsonReturn(["state"=>-1]);


        }

    }



//验证数据
    public function CheckUser($model){

        $mesge='';

        //判断账户名称是否重复
        $user=User::findOne(['name'=>$model->name]);
        if($user){
            $mesge='该账户名称已存在';
            return $mesge;
        }
        //判断登陆账号是否重复
        $user=User::findOne(['username'=>$model->username]);
//            var_dump($model->username,$user);exit;
        if($user){
            $mesge='该登陆账号已存在';
            return $mesge;
        }

        //判断邮箱是否重复
        $user=User::findOne(['email'=>$model->email]);
        if($user){
            $mesge='该邮箱已存在';
            return $mesge;
        }
        //判断是否选择地址
        if(!$model->province){
            $mesge='请选择地址';
            return $mesge;
        }
        //判断是否填写详细地址
        if(!$model->address){
            $mesge='请填写详细地址';
            return $mesge;
        }
        //判断是否标记经纬度
        if(!$model->lng||!$model->lat){
            $mesge='请标记经纬度';
            return $mesge;
        }
        //判断是否选择账户类型
        if(!$model->type){
            $mesge='请选择账户类型';
            return $mesge;
        }
        //如果选择的是服务中心判断是否选择所属运营中学
        if($model->type=='服务中心'&& !$model->agent){
            $mesge='请选择所属运营中心';
            return $mesge;
        }


    }




}