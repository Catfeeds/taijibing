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
use backend\models\OrdinaryAdmin;
use yii\db\ActiveRecord;
use yii;
use backend\models\AdminRoles;
use backend\models\User;
use yii\data\ActiveDataProvider;
use backend\models\AdminRoleUser;
use backend\models\Address;
class AdminUserController extends BaseController
{
    //限制的特殊字符
    public $str=['"',"'",'`','·','~','!','！','@','#','$','￥','%','^','&','*','(',')',
    '_','=','+',' ',',','，','<','.','>','。','?','？','/',';','；',':','：','、','|','\\'];

    public function actionIndex(){
        $page_size = $this->getParam("per-page");//每页显示条数
        $page = $this->getParam("page");//第几页

        if(!$page_size){
            $page_size=10;
        }
        if(!$page){
            $page=1;
        }
        //创建时间
        $sort=$this->getParam("sort");//点击排序
        if($sort==''){
            $sort=0;
        }

        //最后更新
        $sort2=$this->getParam("sort2");//点击排序
        if($sort2==''){
            $sort2=0;
        }
//var_dump($sort,$sort2);exit;

        $content=addslashes(trim($this->getParam('content')));
        $province=trim($this->getParam('province'));
        $city=trim($this->getParam('city'));
        $area=trim($this->getParam('area'));



        $where='';
        if($content!=''){
            $where.=" (LoginName like '%$content%' or Name like '%$content%' or type like '%$content%')";
        }
        if($province){
            if($where){
                $where.=" and ";
            }
            $where.=" Province='$province'";

        }
        if($city){
            if($where){
                $where.=" and ";
            }
            $where.=" City='$city'";

        }
        if($area){
            if($where){
                $where.=" and ";
            }
            $where.=" Area='$area'";

        }

//        var_dump($where);exit;
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



        //排序（创建时间）
        $order=" order by created_at desc ";
        if($sort && $sort%2==1){//偶数 升序
            $order=" order by created_at asc ";

        }
        if($sort && $sort%2==0){//偶数 降序
            $order=" order by created_at desc ";

        }

        //排序（最后更新时间）
        if($sort2 && $sort2%2==1){//偶数 升序
            $order=" order by updated_at asc ";

        }
        if($sort2 && $sort2%2==0){//偶数 升序
            $order=" order by updated_at desc ";

        }

        if($role_id==3){//运营中心

            $datas=yii\db\ActiveRecord::findBySql("select * from (select a.Id,a.Number,
    a.LoginName,a.Name,a.Province,a.City,a.Area,a.ContractUser,a.ContractTel,
    d.email,d.type,d.created_at,d.updated_at,d.Id as admin_id,
    admin_roles.role_name
    from agent_info as a
    LEFT JOIN admin_user as d
    ON a.LoginName=d.username
    LEFT JOIN admin_role_user
    ON d.id=admin_role_user.uid
    LEFT JOIN admin_roles
    ON admin_role_user.role_id=admin_roles.id
where a.ParentId=$parent_id
or a.ParentId in (select Id from agent_info where ParentId=$parent_id and Level=7 )
) as temp  ".(empty($where)?'':' where '.$where)." $order");

//            $datas=AgentInfo::find()->where(['ParentId'=>$parentid]);

        }elseif($role_id==7){//片区中心

            $datas=yii\db\ActiveRecord::findBySql("select * from (select a.Id,a.Number,
    a.LoginName,a.Name,a.Province,a.City,a.Area,a.ContractUser,a.ContractTel,
    d.email,d.type,d.created_at,d.updated_at,d.Id as admin_id,
    admin_roles.role_name
    from agent_info as a
    LEFT JOIN admin_user as d
    ON a.LoginName=d.username
    LEFT JOIN admin_role_user
    ON d.id=admin_role_user.uid
    LEFT JOIN admin_roles
    ON admin_role_user.role_id=admin_roles.id
where a.ParentId=$parent_id
) as temp  ".(empty($where)?'':' where '.$where)." $order");

        }else{

            $datas=yii\db\ActiveRecord::findBySql("select * from (select a.Id,a.Number,
    a.LoginName,a.Name,a.Province,a.City,a.Area,a.ContractUser,a.ContractTel,
    d.email,d.type,d.created_at,d.updated_at,d.Id as admin_id,admin_roles.role_name
    from agent_info as a
    LEFT JOIN admin_user as d
    ON a.LoginName=d.username
    LEFT JOIN admin_role_user
    ON d.id=admin_role_user.uid
    LEFT JOIN admin_roles
    ON admin_role_user.role_id=admin_roles.id
UNION select a.Id,a.Number,a.LoginName,a.Name,a.Province,a.City,a.Area,a.ContractUser,
    a.ContractTel,d.email,d.type,d.created_at,d.updated_at,d.Id as admin_id,admin_roles.role_name
    from factory_info as a
    LEFT JOIN admin_user as d
    ON a.LoginName=d.username
    LEFT JOIN admin_role_user
    ON d.id=admin_role_user.uid
    LEFT JOIN admin_roles
    ON admin_role_user.role_id=admin_roles.id
UNION select a.Id,a.Number,a.LoginName,a.Name,a.Province,a.City,a.Area,a.ContractUser,
  a.ContractTel,d.email,d.type,d.created_at,d.updated_at,d.Id as admin_id,admin_roles.role_name
   from dev_factory as a
   LEFT JOIN admin_user as d
   ON a.LoginName=d.username
   LEFT JOIN admin_role_user
    ON d.id=admin_role_user.uid
    LEFT JOIN admin_roles
    ON admin_role_user.role_id=admin_roles.id
UNION select a.Id,a.Number,a.LoginName,a.Name,a.Province,a.City,a.Area,a.ContractUser,
  a.ContractTel,d.email,d.type,d.created_at,d.updated_at,d.Id as admin_id,admin_roles.role_name
   from ordinary_admin as a
   LEFT JOIN admin_user as d
   ON a.LoginName=d.username
   LEFT JOIN admin_role_user
    ON d.id=admin_role_user.uid
    LEFT JOIN admin_roles
    ON admin_role_user.role_id=admin_roles.id
   ) as temp ".(empty($where)?'':' where '.$where)." $order");
        }

        if(ceil($datas->count()/$page_size)<$page){//输入的页数大于总页数
            $page=ceil($datas->count()/$page_size);
        }


        $pages=new yii\data\Pagination(['totalCount' => $datas->count(), 'pageSize' => $page_size]);
//        $model=$datas->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        $model = yii\db\ActiveRecord::findBySql($datas->sql." limit ". $pages->offset.",".$pages->limit)->asArray()->all();
//        var_dump($model);exit;

        $address=(new Address())->allQuery()->asArray()->all();


        return $this->render('index2',
            [   'model'=>$model,
                'pages'=>$pages,
                'address'=>$address,
                'content'=>$content,
                'province'=>$province,
                'city'=>$city,
                'area'=>$area,
                'sort' =>$sort,
                'sort2' =>$sort2,
                'page_size' => $page_size,
                'page' => $page,
                'role_id' => $role_id,
            ]);
    }


    public function actionCreate()
    {
        $urlobj = $this->getParam("Url");//返回参数记录
        $model = new User();//admin_user表b

        $model->setScenario('create');

        //获取登陆账号的角色id、账户名称
        $id=Yii::$app->user->id;
        $username=User::findOne(['id'=>$id])->username;
        $role_id=AdminRoleUser::findOne(['uid'=>$id])->role_id;
        $name='';
        if($role_id==3 || $role_id==7){
            $agent=AgentInfo::findOne(['LoginName'=>$username]);
            if($agent){
                $name=$agent->Name;
            }


        }

        //获取地址数据
        $data=(new Address())->allQuery()->asArray()->all();


        if(yii::$app->getRequest()->getIsPost()){
            $model->load(Yii::$app->getRequest()->post());

            $mesge=$this->CheckUser($model);
//            var_dump($mesge);exit;
            if($mesge){
                //Yii::$app->getSession()->setFlash('error', $mesge);
                return $this->renderPartial('_form', [
                    'url'=>$urlobj,
                    'model' => ["model"=>$model,
                        "data"=>json_encode($data),
                        "role_id"=>$role_id,
                        "name"=>$name,
                        "msg"=>$mesge,
                    ]
                ]);
            }

//var_dump($model->area_center);exit;
            $number='';
            $precode='';
            $ParentId=0;//上级id
            //创建服务中心时，判断上级id(没有选择片区中心，ParentId就是运营中心的id;选择了片区中心，ParentId就是片区中心的id)
            if($model->agent){
                $Parent=AgentInfo::findOne(['Name'=>$model->agent]);
                if($Parent){
                    $ParentId=$Parent->Id;
                }
            }
            if($model->area_center){
                $pq=AgentInfo::find()->where(['Name'=>$model->area_center])->andWhere(['Level'=>7])->one();
                if($pq){
                    $ParentId=$pq->Id;
                }
            }

            $model->password_hash=Yii::$app->security->generatePasswordHash($model->password);
            $rolesModel = new AdminRoleUser();//admin_role_user 用户和角色关联表

            if($model->type=='酒店中心'){
                $model->logic_type=8;
//                $rolesModel->role_id=9;
                //生成编号
                $precodeRes=ActiveRecord::findBySql("select max(agent_info.`PreCode`) as precode from `agent_info`
where Level=8 and City='$model->city'
")->asArray()->one();
                $precode=intval($precodeRes["precode"])+1;
                $precode=str_pad($precode,3,"0",STR_PAD_LEFT);//用'0'填充左边到长度为3
//                if($precode<11){//保留前10个内部使用
//                    $precode='011';
//                }
                $area_code=ActiveRecord::findBySql("select CityNumber from address_tree where `Name`='$model->city'")->asArray()->one()['CityNumber'];

                $number='J-'.$area_code."-$precode";


            }

            if($model->type=='管理员'){
                $model->logic_type=7;
                $rolesModel->role_id=8;
                //生成编号
                $precodeRes=(new OrdinaryAdmin())->findBySql("select max(ordinary_admin.`PreCode`) as precode from `ordinary_admin`
where City='$model->city'
")->asArray()->one();
                $precode=intval($precodeRes["precode"])+1;
                $precode=str_pad($precode,3,"0",STR_PAD_LEFT);//用'0'填充左边到长度为3
//                if($precode<11){//保留前10个内部使用
//                    $precode='011';
//                }
                $area_code=ActiveRecord::findBySql("select CityNumber from address_tree where `Name`='$model->city'")->asArray()->one()['CityNumber'];

                $number='A-'.$area_code."-$precode";

            }
            if($model->type=='供应商'){
                $model->logic_type=1;
                $rolesModel->role_id=2;

                //生成编号
                $precodeRes=(new FactoryInfo())->findBySql("select max(factory_info.`Code`) as precode from `factory_info`
where City='$model->city'
")->asArray()->one();
                $precode=intval($precodeRes["precode"])+1;
                $precode=str_pad($precode,3,"0",STR_PAD_LEFT);//用'0'填充左边到长度为3
//                if($precode<11){//保留前10个内部使用
//                    $precode='011';
//                }
                $area_code=ActiveRecord::findBySql("select CityNumber from address_tree where `Name`='$model->city'")->asArray()->one()['CityNumber'];

                $number='S-'.$area_code."-$precode";
//                var_dump($number);exit;


            }
            if($model->type=='设备厂家'){
                $model->logic_type=2;
                $rolesModel->role_id=4;

                //生成编号
                $precodeRes=(new DevFactory())->findBySql("select max(dev_factory.`PreCode`) as precode from `dev_factory`
where City='$model->city'
")->asArray()->one();
                $precode=intval($precodeRes["precode"])+1;
                $precode=str_pad($precode,3,"0",STR_PAD_LEFT);//用'0'填充左边到长度为3
//                if($precode<11){//保留前10个内部使用
//                    $precode='011';
//                }
                $area_code=ActiveRecord::findBySql("select CityNumber from address_tree where `Name`='$model->city'")->asArray()->one()['CityNumber'];

                $number='G-'.$area_code."-$precode";
//                var_dump($number);exit;
            }
            if($model->type=='运营中心'){
                $model->logic_type=3;
                $rolesModel->role_id=3;

                //生成编号
                $precodeRes=(new DevFactory())->findBySql("select max(agent_info.`PreCode`) as precode from `agent_info`
where Level=4 and City='$model->city'
")->asArray()->one();
                $precode=intval($precodeRes["precode"])+1;
                $precode=str_pad($precode,3,"0",STR_PAD_LEFT);//用'0'填充左边到长度为3
//                if($precode<11){//保留前10个内部使用
//                    $precode='011';
//                }
//                $area_code=$this->cityToInterNumber[$model->city];
                $area_code=ActiveRecord::findBySql("select CityNumber from address_tree where `Name`='$model->city'")->asArray()->one()['CityNumber'];

                $number='Y-'.$area_code."-$precode";
//                var_dump($number);exit;
            }
            if($model->type=='服务中心'){
                $model->logic_type=4;
                $rolesModel->role_id=5;

                //生成编号
                $precodeRes=(new DevFactory())->findBySql("select max(agent_info.`PreCode`) as precode from `agent_info`
where Level=5 and City='$model->city'
")->asArray()->one();
                $precode=intval($precodeRes["precode"])+1;
                $precode=str_pad($precode,5,"0",STR_PAD_LEFT);//用'0'填充左边到长度为5
//                if($precode<11){//保留前10个内部使用
//                    $precode='00011';
//                }
//                $area_code=$this->cityToInterNumber[$model->city];//区号
                $area_code=ActiveRecord::findBySql("select CityNumber from address_tree where `Name`='$model->city'")->asArray()->one()['CityNumber'];

                //运营中心代码
                $precode_y=AgentInfo::find()->where(['Name'=>$model->agent])->andWhere(['Level'=>4])->one();
                if($precode_y && $precode_y->PreCode){
                    $precode_y=$precode_y->PreCode;
                }else{
                    $precode_y='000';
                }
                //片区中心代码
                $precode_pq=AgentInfo::find()->where(['Name'=>$model->area_center])->andWhere(['Level'=>7])->one();
                if($precode_pq){
                    if($precode_pq->PreCode){
                        $precode_p=$precode_pq->PreCode;
                    }else{
                        $precode_p='0000';
                    }

                }else{
                    $precode_p='0000';

                }
                $number='F-'.$area_code."-$precode_y"."-$precode_p"."-$precode";
//                var_dump($number);exit;
            }
            if($model->type=='设备投资商'){
                $model->logic_type=5;
                $rolesModel->role_id=6;

                //生成编号
                $precodeRes=(new DevFactory())->findBySql("select max(agent_info.`PreCode`) as precode from `agent_info`
where Level=6 and City='$model->city'
")->asArray()->one();
                $precode=intval($precodeRes["precode"])+1;
                $precode=str_pad($precode,3,"0",STR_PAD_LEFT);//用'0'填充左边到长度为3
//                if($precode<11){//保留前10个内部使用
//                    $precode='011';
//                }
                $area_code=ActiveRecord::findBySql("select CityNumber from address_tree where `Name`='$model->city'")->asArray()->one()['CityNumber'];

                $number='T-'.$area_code."-$precode";
//                var_dump($number);exit;
            }
            if($model->type=='片区中心'){
                $model->logic_type=6;
                $rolesModel->role_id=7;

                //生成编号
                $precodeRes=(new DevFactory())->findBySql("select max(agent_info.`PreCode`) as precode from `agent_info`
where Level=7 and City='$model->city'
")->asArray()->one();
                $precode=intval($precodeRes["precode"])+1;
                $precode=str_pad($precode,4,"0",STR_PAD_LEFT);//用'0'填充左边到长度为4
//                if($precode<11){//保留前10个内部使用
//                    $precode='0011';
//                }
//                $area_code=$this->cityToInterNumber[$model->city];
                $area_code=ActiveRecord::findBySql("select CityNumber from address_tree where `Name`='$model->city'")->asArray()->one()['CityNumber'];

                $number='P-'.$area_code."-$precode";
//                var_dump($number);exit;
            }


//            var_dump($model->validate(),$model->save());exit;
            $transaction=Yii::$app->db->beginTransaction();
            try{
//                var_dump($model->validate());exit;

                if(!$model->validate()|| !$model->save()){//保存到admin_user
                    throw new yii\db\Exception('操作失败1');
//                    throw new yii\db\Exception($model->getFirstErrors());
                }

                if($model->logic_type!=8){//创建的是酒店中心的账户类型，不自动分配角色
                    $rolesModel->uid = $model->getPrimaryKey();
                    $rolesModel->created_at = time();
                    if(!$rolesModel->save()){//保存到admin_role_user表
                        throw new yii\db\Exception('操作失败2');
                    }
                }


//                var_dump($model->logic_type);exit;

                //根据logic_type 再保存到对应的表
                $res='';
                if($model->logic_type==1){
                    //供应商
                    $res=   (new FactoryInfo())->insertBaseInfo($model["id"],$model["username"],$model["name"],
                        $model["address"],$model["tel"],$model["contacts"],
                        $model["province"],$model["city"],
                        $model["area"],$model["lng"],$model["lat"],
                        $model["password"],$precode,$number);
                }
                if($model->logic_type==2){
                    //设备厂家
                    $res=  (new DevFactory())->insertBaseInfo($model["id"],$model["username"],
                        $model["name"],$model["address"],$model["tel"],$model["contacts"],
                        $model["province"],$model["city"],$model["area"],$model["lng"],
                        $model["lat"],$model['password'],$precode,$number);
//                    $res=   (new DevFactory())->insertBaseInfo($model["username"],$model["password"]);
                }
                if($model->logic_type==3||$model->logic_type==4||$model->logic_type==5||$model->logic_type==6||$model->logic_type==8){

//                    if($model->logic_type==3){
//                        $ParentId=0;//运营中心
//                    }elseif($model->logic_type==4||$model->logic_type==6||$model->logic_type==8){//服务中心、片区中心、酒店中心
////                        var_dump($model->area_center);exit;
//                        $Parent=AgentInfo::findOne(['Name'=>$model->agent]);
//                            if($Parent){
//                                $ParentId=$Parent->Id;
//                            }else{
//                                $ParentId=0;
//                            }
//                    }elseif($model->logic_type==6){//片区中心
//                        $ParentId=-2;
//                    }else{
//                        $ParentId=-1;//设备投资商
//                    }

//                    var_dump($ParentId);exit;

                    //区域代理(agent_info Level 4:运营中心  5：服务中心  6：设备投资商 7：片区中心)
                    $res=   (new AgentInfo())->insertBaseInfo($ParentId,$model["id"],$model["username"],$model['name'],
                        $model["tel"],$model["contacts"],$model["address"],
                        $model["province"],$model["city"],
                        $model["area"],$model["lng"],$model["lat"],$model->logic_type,$model["password"],$precode,$number);
//                    var_dump($res);exit;

                }
                if($model->logic_type==7){//普通管理员

                    //设备厂家
                    $res=  (new OrdinaryAdmin())->insertBaseInfo($model["id"],$model["username"],
                        $model["name"],$model["address"],$model["tel"],$model["contacts"],
                        $model["province"],$model["city"],$model["area"],$model["lng"],
                        $model["lat"],$model['password'],$precode,$number);
//                    $res=   (new DevFactory())->insertBaseInfo($model["username"],$model["password"]);
                }

                if(!$res){
                    throw new yii\db\Exception('操作失败3');
//                    throw new yii\db\Exception($model->getFirstErrors());
                }

                $transaction->commit();

                //创建的是服务中心的话，添加默认数据（入网属性，设备）
                if($model->logic_type==4 && is_numeric($res)){
                    $sql1="insert into agent_usetype(`agent_id`,`code`) VALUES ($res,'1,2,3')";
                    $sql2="insert into dev_agent_investor(`agent_id`,`investor_id`,`agent_name`,`brand_id`,`goods_id`)
VALUES ($res,65,'','4e4908505b89ae3eae99e0e8041a5307',36)";

                    $re1=Yii::$app->db->createCommand($sql1)->execute();
                    $re2=Yii::$app->db->createCommand($sql2)->execute();
                }
                //创建的是酒店中心的话，添加默认数据（入网属性0元购机）
                if($model->logic_type==8 && is_numeric($res)){
                    $sql="insert into agent_usetype(`agent_id`,`code`) VALUES ($res,'1')";
                    $re=Yii::$app->db->createCommand($sql)->execute();
                }

                \Yii::$app->getSession()->setFlash('success', \Yii::t('app', 'Success'));
                return $this->redirect(['index']);

            }catch (yii\db\Exception $e){

                $transaction->rollBack();
//                var_dump($e->getMessage());exit;


                Yii::$app->getSession()->setFlash('error', $e->getMessage());

                return $this->redirect(['index']);


            }

        }


        return $this->renderPartial("_form", [
            'url'=>$urlobj,
            'model' => ["model"=>$model,
                "data"=>json_encode($data),
                "role_id"=>$role_id,
                "name"=>$name,
                "msg"=>'',

            ]

        ]);


    }

    public function actionUpdate($LoginName)
    {
//        var_dump($LoginName);exit;
        $urlobj = $this->getParam("Url");//返回参数记录
        if(empty($LoginName)){
            Yii::$app->getSession()->setFlash('error',"参数错误");
            return $this->redirect(['index']);
        }

        //获取地址数据
        $data=(new Address())->allQuery()->asArray()->all();
        //获取片区中心
        $area_center=ActiveRecord::findBySql("select Id,Name from agent_info where Level=7")->asArray()->all();
//var_dump($area_center);exit;

            //判断修改的数据来自哪张表
            $admin_user = User::findOne(['username'=>$LoginName]);
        //获取上级运营中心名称
        $agent_data=ActiveRecord::findBySql("select c.`Name`
from agent_info as a
LEFT JOIN agent_info as b on b.Id=a.ParentId and b.`Level`=7
LEFT JOIN agent_info as c on (c.Id=b.ParentId or c.Id=a.ParentId) and c.`Level`=4
where a.LoginName='$LoginName'")->asArray()->one();
        $admin_user->agent=$agent_data['Name'];


            $logic_type=$admin_user->logic_type;
            $id=$admin_user->id;
            $agent_info=AgentInfo::findOne(['LoginName'=>$LoginName]);
            $dev_factory=DevFactory::findOne(['LoginName'=>$LoginName]);
            $factory_info=FactoryInfo::findOne(['LoginName'=>$LoginName]);
            $ordinary_admin=OrdinaryAdmin::findOne(['LoginName'=>$LoginName]);
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
            if($ordinary_admin){
                $model=$ordinary_admin;
                $name='OrdinaryAdmin';
            }

        $username=$model->Name;//后面判断是否修改了账户名称
        $loginname=$model->LoginName;
        $email=$admin_user->email;

        //先保存市（后面判断，市改变了就从新生成编号）
        $city=$model->City;

        $model->setScenario('update');
        $admin_user->setScenario('update');//(email、type、agent)

        //根据登陆者的信息，获取登陆者的角色
        $login_id=Yii::$app->user->id;
        $LogiName=User::findOne(['id'=>$login_id])->username;
        $dat=AgentInfo::findOne(['LoginName'=>$LogiName]);
        $agent='';
        if($dat){
            $agent=$dat->Name;
        }

        //获取角色id
        $role_id=AdminRoleUser::findOne(['uid'=>$login_id])->role_id;

        $Is_have_center_id=0;//上级是否有片区中心（0没，1有）

        if(property_exists($model,'ParentId')){
            $parent_data=AgentInfo::findOne(['Id'=>$model->ParentId]);
            if($parent_data&&$parent_data->ParentId>0&&$parent_data->Level==7){//上级是片区中心
                $Is_have_center_id=1;
            }
        }



            if(yii::$app->getRequest()->getIsPost()){

                $model->load(yii::$app->getRequest()->Post());

                $model->RowTime=date("Y-m-d H:i:s");

                $datas=(yii::$app->getRequest()->Post());//email、type、agent

                $user=$datas['User'];//email、type、agent
//                var_dump($user);exit;
                if(!array_key_exists('agent',$user)){
                    $user['agent']='';
                }
//                var_dump($user);exit;
//                var_dump(trim($model->ContractTel));exit;

                $ParentId=0;//上级id
                //创建服务中心时，判断上级id(没有选择片区中心，ParentId就是运营中心的id;选择了片区中心，ParentId就是片区中心的id)
                if(array_key_exists('agent',$user)){
                    if($user['agent']){
                        $Parent=AgentInfo::findOne(['Name'=>$user['agent']]);
                        if($Parent){
                            $ParentId=$Parent->Id;
                        }
                    }

                }

                if(array_key_exists('area_center',$user)){
                    if($user['area_center']){
                        $pq=AgentInfo::find()->where(['Name'=>$user['area_center']])->andWhere(['Level'=>7])->one();
                        if($pq){
                            $ParentId=$pq->Id;
                        }
                    }

                }

//                $Is_have_center_id=0;//上级是否有片区中心（0没，1有）
                $parent_data=AgentInfo::findOne(['Id'=>$ParentId]);
                if($parent_data&&$parent_data->ParentId>0&&$parent_data->Level==7){//上级是片区中心
                    $Is_have_center_id=1;
                }



                //验证
                $mesg=$this->CheckUserUpdate($model,$user,$username,$loginname,$email);

                if($mesg){
                    Yii::$app->getSession()->setFlash('error', $mesg);
                    return $this->render('update2', [
                        "name"=>$name,
                        "area_center"=>json_encode($area_center),//片区中心
                        'model' => ["model"=>$model,
                            'role_id'=>$role_id,
                            'agent'=>$agent,
                            "data"=>json_encode($data),
                            "admin_user"=>$admin_user,

                        ],
                        'url'=>$urlobj,
                        'Is_have_center_id'=>$Is_have_center_id,
                    ]);
                }



//                var_dump($user);exit;


//                var_dump( $model->Name,$model->LoginName,$model->Area);exit;

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

                if($user['type']=='酒店中心'){
                    $admin_user->logic_type=8;
                    $admin_user->type='酒店中心';
                    $model->ParentId=$ParentId;
//                    $AdminRoleUser->role_id=9;
                    //判断是否修改了市（否则修改编号）
                    if($city!=$model->City) {//修改了市
                        //生成编号
                        $precodeRes=ActiveRecord::findBySql("select max(agent_info.`PreCode`) as precode from `agent_info`
where Level=8 and City='$model->city'
")->asArray()->one();

                        $precode = intval($precodeRes["precode"]) + 1;
                        $precode = str_pad($precode, 3, "0", STR_PAD_LEFT);//用'0'填充左边到长度为3
                        $area_code = ActiveRecord::findBySql("select CityNumber from address_tree where `Name`='$model->City'")->asArray()->one()['CityNumber'];

                        $number = 'J-' . $area_code . "-$precode";
//                var_dump($number);exit;
                        $model->PreCode = $precode;
                        $model->Number = $number;

                    }
                }
//var_dump($model);exit;
                if($user['type']=='管理员'){
                    $admin_user->logic_type=7;
                    $admin_user->type='管理员';
//                    $AdminRoleUser->role_id=8;
                    //判断是否修改了市（否则修改编号）
                    if($city!=$model->City) {//修改了市
                        //生成编号
                        $precodeRes = (new OrdinaryAdmin())->findBySql("select max(ordinary_admin.`PreCode`) as precode from `ordinary_admin`
where City='$model->City'
")->asArray()->one();

                        $precode = intval($precodeRes["precode"]) + 1;
                        $precode = str_pad($precode, 3, "0", STR_PAD_LEFT);//用'0'填充左边到长度为3
                        $area_code = ActiveRecord::findBySql("select CityNumber from address_tree where `Name`='$model->City'")->asArray()->one()['CityNumber'];

                        $number = 'A-' . $area_code . "-$precode";
//                var_dump($number);exit;
                        $model->PreCode = $precode;
                        $model->Number = $number;
                    }
                }
                if($user['type']=='供应商'){
                    $admin_user->logic_type=1;
                    $admin_user->type='供应商';
//                    $AdminRoleUser->role_id=2;
                    //判断是否修改了市（否则修改编号）
                    if($city!=$model->City) {//修改了市
                        //生成编号
                        $precodeRes=(new FactoryInfo())->findBySql("select max(factory_info.`Code`) as precode from `factory_info`
where City='$model->City'
")->asArray()->one();

                        $precode=intval($precodeRes["precode"])+1;
                        $precode=str_pad($precode,3,"0",STR_PAD_LEFT);//用'0'填充左边到长度为3
                        $area_code=ActiveRecord::findBySql("select CityNumber from address_tree where `Name`='$model->City'")->asArray()->one()['CityNumber'];

                        $number='S-'.$area_code."-$precode";
//                var_dump($number);exit;
                        $model->Code=$precode;
                        $model->Number=$number;

                    }
                }
                if($user['type']=='设备厂家'){
                    $admin_user->logic_type=2;
                    $admin_user->type='设备厂家';
//                    $AdminRoleUser->role_id=4;
                    if($city!=$model->City) {//修改了市
                        //生成编号
                        $precodeRes=(new DevFactory())->findBySql("select max(dev_factory.`PreCode`) as precode from `dev_factory`
where City='$model->City'
")->asArray()->one();
                        $precode=intval($precodeRes["precode"])+1;
                        $precode=str_pad($precode,3,"0",STR_PAD_LEFT);//用'0'填充左边到长度为3
                        $area_code=ActiveRecord::findBySql("select CityNumber from address_tree where `Name`='$model->City'")->asArray()->one()['CityNumber'];

                        $number='G-'.$area_code."-$precode";
//                var_dump($number);exit;
                        $model->PreCode=$precode;
                        $model->Number=$number;

                    }
                }
                if($user['type']=='运营中心'){
                    $admin_user->logic_type=3;
                    $admin_user->type='运营中心';
                    //修改该运营中心下服务中心的agent值
                    if($admin_user->name!=$username){
                        Yii::$app->db->createCommand("update admin_user set agent='$admin_user->name' where agent='$username'")->execute();
                    }
//                    $AdminRoleUser->role_id=3;
                    if($city!=$model->City) {//修改了市
                        //生成编号
                        $precodeRes=(new DevFactory())->findBySql("select max(agent_info.`PreCode`) as precode from `agent_info`
where Level=4 and City='$model->City'
")->asArray()->one();
                        $precode=intval($precodeRes["precode"])+1;
                        $precode=str_pad($precode,3,"0",STR_PAD_LEFT);//用'0'填充左边到长度为3
                        $area_code=ActiveRecord::findBySql("select CityNumber from address_tree where `Name`='$model->City'")->asArray()->one()['CityNumber'];

                        $number='Y-'.$area_code."-$precode";
//                var_dump($number);exit;
                        $model->PreCode=$precode;
                        $model->Number=$number;
                    }
                }
                if($user['type']=='服务中心'){
                    $admin_user->logic_type=4;
                    $admin_user->type='服务中心';
                    $model->ParentId=$ParentId;
//                    $AdminRoleUser->role_id=5;
                    if($city!=$model->City) {//修改了市
                        //生成编号
                        $precodeRes=(new DevFactory())->findBySql("select max(agent_info.`PreCode`) as precode from `agent_info`
where Level=5 and City='$model->City'
")->asArray()->one();
                        $precode=intval($precodeRes["precode"])+1;
                        $precode=str_pad($precode,5,"0",STR_PAD_LEFT);//用'0'填充左边到长度为5
//                        if($precode<11){//保留前10个内部使用
//                            $precode='00011';
//                        }
                        $area_code=ActiveRecord::findBySql("select CityNumber from address_tree where `Name`='$model->City'")->asArray()->one()['CityNumber'];

                        //运营中心代码
                        $precode_y=AgentInfo::find()->where(['Name'=>$user['agent']])->andWhere(['Level'=>4])->one();
                        if($precode_y && $precode_y->PreCode){
                            $precode_y=$precode_y->PreCode;
                        }else{
                            $precode_y='000';
                        }
                        //片区中心代码
                        $precode_p='0000';
//                        $area_center_id=0;
                        if(array_key_exists('area_center', $user)){
                            $precode_pq=AgentInfo::find()->where(['Name'=>$user['area_center']])->andWhere(['Level'=>7])->one();
                            if($precode_pq){
                                if($precode_pq->PreCode){
                                    $precode_p=$precode_pq->PreCode;
                                }else{
                                    $precode_p='0000';
                                }
//                                $area_center_id=$precode_pq->Id;//片区中心id
                            }
                        }

                        $number='F-'.$area_code."-$precode_y"."-$precode_p"."-$precode";
//                var_dump($number);exit;
                        $model->PreCode=$precode;
                        $model->Number=$number;
//                        $model->area_center_id=$area_center_id;

                    }
                }
                if($user['type']=='设备投资商'){
                    $admin_user->logic_type=5;
                    $admin_user->type='设备投资商';
//                    $AdminRoleUser->role_id=6;
                    if($city!=$model->City) {//修改了市
                        //生成编号
                        $precodeRes = (new DevFactory())->findBySql("select max(agent_info.`PreCode`) as precode from `agent_info`
where Level=6 and City='$model->City'
")->asArray()->one();
                        $precode = intval($precodeRes["precode"]) + 1;
                        $precode = str_pad($precode, 3, "0", STR_PAD_LEFT);//用'0'填充左边到长度为3
//                        if($precode<11){//保留前10个内部使用
//                            $precode='011';
//                        }
                        $area_code = ActiveRecord::findBySql("select CityNumber from address_tree where `Name`='$model->City'")->asArray()->one()['CityNumber'];

                        $number = 'T-' . $area_code . "-$precode";

//                      var_dump($number);exit;
                        $model->PreCode=$precode;
                        $model->Number=$number;
                    }
                }
                if($user['type']=='片区中心'){
                    $admin_user->logic_type=6;
                    $admin_user->type='片区中心';
                    $model->ParentId=$ParentId;
//                    $AdminRoleUser->role_id=7;
                    if($city!=$model->City) {//修改了市
                        //生成编号
                        $precodeRes = (new DevFactory())->findBySql("select max(agent_info.`PreCode`) as precode from `agent_info`
where Level=7 and City='$model->City'
")->asArray()->one();
                        $precode = intval($precodeRes["precode"]) + 1;
                        $precode = str_pad($precode, 4, "0", STR_PAD_LEFT);//用'0'填充左边到长度为4
//                        if ($precode < 11) {//保留前10个内部使用
//                            $precode = '0011';
//                        }
//                      $area_code=$this->cityToInterNumber[$model->city];
                        $area_code = ActiveRecord::findBySql("select CityNumber from address_tree where `Name`='$model->City'")->asArray()->one()['CityNumber'];

                        $number = 'P-' . $area_code . "-$precode";
//                      var_dump($number);exit;
                        $model->PreCode=$precode;
                        $model->Number=$number;

                    }
                }


//            var_dump( $admin_user->logic_type,$admin_user->type);exit;
                $transaction=Yii::$app->db->beginTransaction();
                try{

                    if(!$admin_user->save(false)){//保存到admin_user
                        throw new yii\db\Exception('admin_user表操作失败1');
//                    throw new yii\db\Exception($model->getFirstErrors());
                    }


//                    $AdminRoleUser->updated_at = time();
//                    if(!$AdminRoleUser->validate()||!$AdminRoleUser->save()){//保存到admin_role_user表
//                        throw new yii\db\Exception('admin_role_user表操作失败2');
//                    }

                    //修改了账户类型
                    if($logic_type!=$admin_user->logic_type){
                        //先删除原来的
                        if($logic_type==1){//供应商
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


                        //根据$admin_user->logic_type 再保存到对应的表

                        if($admin_user->logic_type==1){//供应商
                            //供应商
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
            }

            return $this->renderPartial('update2', [
                "area_center"=>json_encode($area_center),//片区中心
                "name"=>$name,
                'model' => ["model"=>$model,
                    'role_id'=>$role_id,
                    'agent'=>$agent,
                    "data"=>json_encode($data),
                    "admin_user"=>$admin_user,

                ],
                'url'=>$urlobj,
                'Is_have_center_id'=>$Is_have_center_id,
            ]);
    }


    public function getModel($id = '')
    {
        return User::findOne(['id'=>$id]);
    }

    //修改个人资料
    public function actionUpdateSelf()
    {
        $model = User::findOne(['id'=>yii::$app->getUser()->getIdentity()->getId()]);
        $password_hash=$model->password_hash;
        $old_email=$model->email;
        $logic_type=$model->logic_type;
        $LoginName=$model->username;


//        var_dump($model);exit;
        $model->setScenario('self-update');
//        $model->load(yii::$app->getRequest()->post());var_dump($model);exit;


        if(yii::$app->getRequest()->getIsPost()){
            $model->load(yii::$app->getRequest()->post());
//            var_dump($model->old_password,$model->password,$model->repassword);exit;
            //验证数据
            if($model->username==''){
                Yii::$app->getSession()->setFlash('error', '登陆账号不能为空');
                return $this->render('update', [
                    'model' => $model,
                ]);
            }

            if($model->email==''){
                Yii::$app->getSession()->setFlash('error', '邮箱不能为空');
                return $this->render('update', [
                    'model' => $model,
                ]);
            }

            //是否修改邮箱
            if($model->email && $model->email!=$old_email){
                $email=User::findOne(['email'=>$model->email]);
                if($email){
                    Yii::$app->getSession()->setFlash('error', '邮箱已存在');
                    return $this->render('update', [
                        'model' => $model,
                    ]);
                }
            }


            if($model->old_password==''){
                Yii::$app->getSession()->setFlash('error', '旧密码不能为空');
                return $this->render('update', [
                    'model' => $model,
                ]);
            }

            if($model->password==''){
                Yii::$app->getSession()->setFlash('error', '密码不能为空');
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
            if($model->repassword==''){
                Yii::$app->getSession()->setFlash('error', '重复密码不能为空');
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
            if($model->repassword!=$model->password){
                Yii::$app->getSession()->setFlash('error', '两次输入密码不一致');
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
            //验证旧密码是否正确
           if(!Yii::$app->security->validatePassword($model->old_password,$password_hash)){
               Yii::$app->getSession()->setFlash('error', '旧密码错误');
               return $this->render('update', [
                   'model' => $model,
               ]);
           }
            $model->password_hash=Yii::$app->security->generatePasswordHash($model->password);
           //修改对应表的密码
            if($logic_type==0){//管理员
                if(!$model->save(false)){
                    Yii::$app->getSession()->setFlash('error', '失败!!');
                    return $this->render('update', [
                        'model' => $model,
                    ]);
                }
                Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));

            }else{


                if($logic_type==1){//供应商
                    $user=FactoryInfo::findOne(['LoginName'=>$LoginName]);
                }
                if($logic_type==2){//设备厂家
                    $user=DevFactory::findOne(['LoginName'=>$LoginName]);
                }
                if($logic_type==3 || $logic_type==4){//运营中心
                    $user=AgentInfo::findOne(['LoginName'=>$LoginName]);
                }

                $user->LoginPwd=md5($model->password);


                $transaction=Yii::$app->db->beginTransaction();
                try{
                    if(!$model->save(false)){
                        throw new yii\db\Exception('失败');
                    }
                    if(!$user->save(false)){
                        throw new yii\db\Exception('失败..');
                    }

                    $transaction->commit();
                    Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
                }catch (yii\db\Exception $e){
                    $transaction->rollBack();
                    Yii::$app->getSession()->setFlash('error', '失败!');

                }

            }


//            if( $model->validate() && $model->load(yii::$app->getRequest()->post()) && $model->self_update() ){
//                Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
//            }else{
//                $errors = $model->getErrors();
//                $err = '';
//                foreach($errors as $v){
//                    $err .= $v[0].'<br>';
//                }
//                Yii::$app->getSession()->setFlash('error', $err);
//            }
//            $model = User::findOne(['id'=>yii::$app->getUser()->getIdentity()->getId()]);
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

    //js根据地址获取对应的运营中心数据(现在又要把地址的限制放开)
    public function actionGetAgent(){
        $province=Yii::$app->request->get('province');
        $city=Yii::$app->request->get('city');
        $area=Yii::$app->request->get('area');
        $where='where Level=4';
//        if($province){
//            $where.=" and Province='{$province}'";
//        }
//        if($city){
//            $where.=" and City='{$city}'";
//
//        }
//        if($area){
//            $where.=" and Area='{$area}'";
//
//        }
        $sql="select Id,Name from agent_info ".$where;
//var_dump($sql);exit;
        $agents=AgentInfo::findBySql($sql)->asArray()->all();
        if(!in_array(['Id'=>62,'Name'=>'太极兵运营中心'],$agents)){
            array_push($agents,['Id'=>62,'Name'=>'太极兵运营中心']);
        }
//        var_dump($agents);exit;
        return $agents;

    }

    //重置密码
    public function actionResetPassword($LoginName){
        if(empty($LoginName)){
            $this->jsonErrorReturn("参数错误");
            return;
        }
        //找到该用户
        $admin_user=User::findOne(['username'=>$LoginName]);
        $user='';
        //根据logic_type修改对应表的密码
        $logic_type=$admin_user->logic_type;
        if($logic_type==1){//供应商
            $user=FactoryInfo::findOne(['LoginName'=>$LoginName]);
        }
        if($logic_type==2){//设备厂家
            $user=DevFactory::findOne(['LoginName'=>$LoginName]);
        }
        //运营中心、服务中心、设备投资商、片区中心、管理员、酒店中心
        if($logic_type==3 || $logic_type==4|| $logic_type==5|| $logic_type==6|| $logic_type==7|| $logic_type==8){
            $user=AgentInfo::findOne(['LoginName'=>$LoginName]);
        }


        if(!$admin_user||!$user){
            $this->jsonErrorReturn("该账号不存在");
            return ;
        }
        //重置该用户密码为：123456
        $admin_user->password_hash=Yii::$app->security->generatePasswordHash('123456');
        $user->LoginPwd=md5('123456');

        $transaction=Yii::$app->db->beginTransaction();
        try{
            if(!$admin_user->save(false)){
                throw new yii\db\Exception('失败');
            }
            if(!$user->save(false)){
                throw new yii\db\Exception('失败.');
            }


            $transaction->commit();
            $this->jsonReturn(["state"=>0,'desc'=>'操作成功']);
        }catch (yii\db\Exception $e){
            $transaction->rollBack();

            $this->jsonReturn(["state"=>-1,'desc'=>'失败']);
        }

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



            if(!$res){//admin_user 删除失败
                throw new yii\db\Exception('操作失败1');
//                    throw new yii\db\Exception($model->getFirstErrors());
            }

            if($admin_user->logic_type==1){//供应商
                $data=FactoryInfo::findOne(['LoginName'=>$LoginName]);
                if($data){
                    $res=$data->delete();
                    if(!$res){
                        throw new yii\db\Exception('操作失败2');
                    }
                }


            }
            //运营中心、服务中心、设备投资商、片区中心、酒店
            if($admin_user->logic_type==3 || $admin_user->logic_type==4 || $admin_user->logic_type==5 || $admin_user->logic_type==6 || $admin_user->logic_type==8){
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

            if($admin_user->logic_type==7){//普通管理员
                $data=OrdinaryAdmin::findOne(['LoginName'=>$LoginName]);
                if($data){
                    $res=$data->delete();
                    if(!$res){
                        throw new yii\db\Exception('操作失败4');
                    }
                }

            }
//var_dump($admin_user);exit;
            $id=$admin_user->id;

            $data=AdminRoleUser::findOne(['uid'=>$id]);
            if($data){
                $res=$data->delete();
                if(!$res){
                    throw new yii\db\Exception('操作失败5');
                }
            }


            $transaction->commit();
//            return $this->redirect(yii::$app->request->headers['referer']);
            $this->jsonReturn(["state"=>0,'msg'=>'成功']);

        }catch (yii\db\Exception $e){

            $transaction->rollBack();
//                var_dump($e->getMessage());exit;
            $this->jsonReturn(["state"=>-1,'msg'=>'失败']);


        }

    }


//验证数据（添加时验证）
    public function CheckUser($model){

        $mesge='';

        if(trim($model->name)==''){
            $mesge='账户名称不能为空';
            return $mesge;
        }
        //验证账户名称是否有特殊字符
        $length = mb_strlen($model->name, 'utf-8');
        for ($i=0; $i<$length; $i++){
            $Name = mb_substr($model->name, $i, 1, 'utf-8');//截取每一个进行验证
            if(in_array($Name,$this->str)){
                $mesge='账户名称不能有特殊字符';
                return $mesge;
            }
        }

        //判断账户名称是否重复
        $user=User::findOne(['name'=>trim($model->name)]);
        if($user){
            $mesge='该账户名称已存在';
            return $mesge;
        }

        if(trim($model->contacts)==''){
            $mesge='联系人不能为空';
            return $mesge;
        }
        //验证联系人是否有特殊字符
        $length = mb_strlen($model->contacts, 'utf-8');
        for ($i=0; $i<$length; $i++){
            $Name = mb_substr($model->contacts, $i, 1, 'utf-8');//截取每一个进行验证
            if(in_array($Name,$this->str)){
                $mesge='联系人不能有特殊字符';
                return $mesge;
            }
        }

        if(trim($model->tel)==''){
            $mesge='联系电话不能为空';
            return $mesge;
        }

        if(!preg_match('/^[0-9]{10}|[0-9]{12}|[0-9]{11}$/',trim($model->tel))){
            $mesge='请填写正确的电话格式';
            return $mesge;
        }

        if(trim($model->username)==''){
            $mesge='登陆账号不能为空';
            return $mesge;
        }
        //验证登陆账号是否有特殊字符
        $length = mb_strlen($model->username, 'utf-8');
        for ($i=0; $i<$length; $i++){
            $Name = mb_substr($model->username, $i, 1, 'utf-8');//截取每一个进行验证
            if(in_array($Name,$this->str)){
                $mesge='登陆账号不能有特殊字符';
                return $mesge;
            }
        }


        //判断登陆账号是否重复
        $user=User::findOne(['username'=>$model->username]);
//            var_dump($model->username,$user);exit;
        if($user){
            $mesge='该登陆账号已存在';
            return $mesge;
        }

        if($model->password==''||$model->repassword==''){
            $mesge='登陆密码和确认密码不能为空';
            return $mesge;
        }
        if($model->password!=$model->repassword){
            $mesge='登陆密码和确认密码必须相等';
            return $mesge;
        }
        if(trim($model->email)==''){
            $mesge='邮箱不能为空';
            return $mesge;
        }


        //判断邮箱是否重复
        $user=User::findOne(['email'=>$model->email]);
        if($user){
            $mesge='该邮箱已存在';
            return $mesge;
        }
        //判断是否选择地址
        if(!$model->province || !$model->city || !$model->area){
            $mesge='请选择完整地址';
            return $mesge;
        }
        //判断是否填写详细地址
        if(!$model->address){
            $mesge='请填写详细地址';
            return $mesge;
        }
        //验证详细地址是否有特殊字符
        $length = mb_strlen($model->address, 'utf-8');
        for ($i=0; $i<$length; $i++){
            $Name = mb_substr($model->address, $i, 1, 'utf-8');//截取每一个进行验证
            if(in_array($Name,$this->str)){
                $mesge='详细地址不能有特殊字符';
                return $mesge;
            }
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
        //如果选择的是服务中心或酒店中心判断是否选择所属运营中学
        if(($model->type=='服务中心'||$model->type=='酒店中心')&& !$model->agent){
            $mesge='请选择所属运营中心';
            return $mesge;
        }


    }


    //修改时验证数据
    public function CheckUserUpdate($model,$user_data,$username,$loginname,$email){
        $mesge='';

        if(trim($model->Name)==''){
            $mesge='账户名称不能为空';
            return $mesge;
        }

        //验证登陆账号是否有特殊字符
        $length = mb_strlen($model->Name, 'utf-8');
        for ($i=0; $i<$length; $i++){
            $Name = mb_substr($model->Name, $i, 1, 'utf-8');//截取每一个进行验证
            if(in_array($Name,$this->str)){
                $mesge='账户名称不能有特殊字符';
                return $mesge;
            }
        }

        if($model->Name!=$username){//修改了账户名称
            //判断账户名称是否重复
            $user=User::findOne(['name'=>trim($model->Name)]);
            if($user){
                $mesge='该账户名称已存在';
                return $mesge;
            }

        }

        if(trim($model->ContractUser)==''){
            $mesge='联系人不能为空';
            return $mesge;
        }
        //验证联系人是否有特殊字符
        $length = mb_strlen($model->ContractUser, 'utf-8');
        for ($i=0; $i<$length; $i++){
            $Name = mb_substr($model->ContractUser, $i, 1, 'utf-8');//截取每一个进行验证
            if(in_array($Name,$this->str)){
                $mesge='联系人不能有特殊字符';
                return $mesge;
            }
        }

        if(trim($model->ContractTel)==''){
            $mesge='联系电话不能为空';
            return $mesge;
        }
        if(!preg_match('/^[0-9]{10}|[0-9]{12}|[0-9]{11}$/',trim($model->ContractTel))){
            $mesge='请填写正确的电话格式';
            return $mesge;
        }



//            var_dump($model->username,$user);exit;
        if(trim($model->LoginName)!=$loginname){//修改了登陆账号

            if(trim($model->LoginName)==''){
                $mesge='登陆账号不能为空';
                return $mesge;
            }

            //验证登陆账号是否有特殊字符
            $length = mb_strlen($model->LoginName, 'utf-8');
            for ($i=0; $i<$length; $i++){
                $Name = mb_substr($model->LoginName, $i, 1, 'utf-8');//截取每一个进行验证
                if(in_array($Name,$this->str)){
                    $mesge='登陆账号不能有特殊字符';
                    return $mesge;
                }
            }

            //判断登陆账号是否重复
            $user=User::findOne(['username'=>trim($model->LoginName)]);
            if($user){
                $mesge='该登陆账号已存在';
                return $mesge;
            }

        }


        if(trim($user_data['email'])!=$email){//修改了邮箱

            if(trim($user_data['email'])==''|| !preg_match('/^\w+([-.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/',trim($user_data['email']))){

                $mesge='请填写正确的邮箱';
                return $mesge;

            }

            //判断邮箱是否重复
            $user=User::findOne(['email'=>trim($user_data['email'])]);
            if($user){
                $mesge='该邮箱已存在';
                return $mesge;
            }

        }
        //判断是否选择地址
        if(!$model->Province || !$model->City || !$model->Area){
            $mesge='请选择完整地址';
            return $mesge;
        }
        //判断是否填写详细地址
        if(!$model->Address){
            $mesge='请填写详细地址';
            return $mesge;
        }
        //验证详细地址是否有特殊字符
        $length = mb_strlen($model->Address, 'utf-8');
        for ($i=0; $i<$length; $i++){
            $Name = mb_substr($model->Address, $i, 1, 'utf-8');//截取每一个进行验证
            if(in_array($Name,$this->str)){
                $mesge='详细地址不能有特殊字符';
                return $mesge;
            }
        }


        //判断是否标记经纬度
        if(!$model->BaiDuLng||!$model->BaiDuLat){
            $mesge='请标记经纬度';
            return $mesge;
        }
        //判断是否选择账户类型
        if(!$user_data['type']){
            $mesge='请选择账户类型';
            return $mesge;
        }
        //如果选择的是服务中心判断是否选择所属运营中学
        if(($user_data['type']=='服务中心'||$user_data['type']=='酒店中心')&& !$user_data['agent']){
            $mesge='请选择所属运营中心';
            return $mesge;
        }





        //验证数据（agnet_info 或 dev_factory 或 factory_info ）

//
//
//
//        if(!$model->Province){
//            Yii::$app->getSession()->setFlash('error', '请填写地址');
//            return $this->render('update2', [
//                "name"=>$name,
//                'model' => ["model"=>$model,
//                    'role_id'=>$role_id,
//                    'agent'=>$agent,
//                    "data"=>json_encode($data),
//                    "admin_user"=>$admin_user,
//                ]
//            ]);
//        }
//
//        if(!$model->Address){
//            Yii::$app->getSession()->setFlash('error', '请填详细写地址');
//            return $this->render('update2', [
//                "name"=>$name,
//                'model' => ["model"=>$model,
//                    'role_id'=>$role_id,
//                    'agent'=>$agent,
//                    "data"=>json_encode($data),
//                    "admin_user"=>$admin_user,
//                ]
//            ]);
//        }
//
//        if(!$model->BaiDuLat||!$model->BaiDuLng){
//            Yii::$app->getSession()->setFlash('error', '请标记位置');
//            return $this->render('update2', [
//                "name"=>$name,
//                'model' => ["model"=>$model,
//                    'role_id'=>$role_id,
//                    'agent'=>$agent,
//                    "data"=>json_encode($data),
//                    "admin_user"=>$admin_user,
//                ]
//            ]);
//        }
//
//
//
//
//
//
//        if(!$user['type']){
//            Yii::$app->getSession()->setFlash('error', '请选择账户类型');
//            return $this->render('update2', [
//                "name"=>$name,
//                'model' => ["model"=>$model,
//                    'role_id'=>$role_id,
//                    'agent'=>$agent,
//                    "data"=>json_encode($data),
//                    "admin_user"=>$admin_user,
//                ]
//            ]);
//        }
//
//        if($user['type'] && $user['type']=='服务中心'){
//            if(!$user['agent']){
//                Yii::$app->getSession()->setFlash('error', '请选择所属运营中心');
//                return $this->render('update2', [
//                    "name"=>$name,
//                    'model' => ["model"=>$model,
//                        'role_id'=>$role_id,
//                        'agent'=>$agent,
//                        "data"=>json_encode($data),
//                        "admin_user"=>$admin_user,
//                    ]
//                ]);
//            }
//
//        }




    }


    public function actionMark(){
        return $this->renderPartial("mark");
    }


    //根据关键字搜索对应的片区中心
    public function actionSearchAreaCenter(){
//        $search=addslashes($this->getParam('search'));
//        if($search==''){
//            return '';
//        }
        $datas=ActiveRecord::findBySql("select Id,`Name`,ParentId from agent_info where Level=7 ")->asArray()->all();
//        var_dump($datas);
        return json_encode($datas);
    }



}