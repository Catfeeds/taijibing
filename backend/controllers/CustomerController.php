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
use Symfony\Component\Console\Helper\Helper;
use yii;
use yii\data\Pagination;
use backend\models\Address;

class CustomerController extends BaseController
{
    //入网属性
//        public $UserType=[
//                            ''=>'',
//                            0=>'',
//                            1=>'自购',
//                            2=>'押金',
//                            3=>'买水借机',
//                            4=>'买机送水',
//                            5=>'免费',
//                            99=>'其他',
//                            ];
    //客户类型
        public $CustomerType=[
                                ''=>'',
                                0=>'',
                                1=>'家庭',
                                2=>'公司',
                                3=>'集团',
                                4=>'酒店',
                                99=>'其他',
                                ];

    public function actionList()
    {
        $page_size = $this->getParam("per-page");//每页显示条数
        $page = $this->getParam("page");//第几页

        if(!$page_size){
            $page_size=10;
        }
        if(!$page){
            $page=1;
        }

        $sort2=$this->getParam("sort2");//点击照片排序
        $sort=$this->getParam("sort");//点击登记时间排序
        if($sort==''){
            $sort=1;
        }

        //显示正常用户、未激活、已初始化用户
        $state1=$this->getParam("state1");
        $state2=$this->getParam("state2");
        $state3=$this->getParam("state3");
        $state5=$this->getParam("state5");//推荐用户
        if(!$state1&&!$state2&&!$state3&&!$state5){
            $state1=1;
        }
        $state4=$this->getParam("state4");//重复姓名

        $content=addslashes($this->getParam("content"));
        //照片状态（0没有上传；1 上传了图片，等待确认；2 图片确认通过；3 未通过）
        $picture_state=addslashes($this->getParam("picture_state"));
        $usetype=$this->getParam("usetype");
        $customertype=$this->getParam("customertype");
        $province=$this->getParam("province");
        $city=$this->getParam("city");
        $area=$this->getParam("area");
        $address=(new Address())->allQuery()->asArray()->all();
        $datas = CustomSearch::pageQuery($picture_state,$state4,$state1,$state2,$state3,$content,$usetype,$customertype,$province,$city,$area,$sort,$sort2,$state5);
//        var_dump($datas->sql);exit;
        //获取已初始化的设备编号
        $DevNos=yii\db\ActiveRecord::findBySql("select DevNo from dev_cmd
        where CmdType=4 and State=1 GROUP BY DevNo")->asArray()->all();

        $users_of_init=[];
        foreach($DevNos as $DevNo){
            $users_of_init[]=$DevNo['DevNo'];
        }
        if(ceil($datas->count()/$page_size)<$page){//输入的页数大于总页数
            $page=ceil($datas->count()/$page_size);
        }

        $pages = new Pagination(['totalCount' => $datas->count(), 'defaultPageSize' => $page_size]);
        if($state4){
            $model = yii\db\ActiveRecord::findBySql($datas->sql)->asArray()->all();
        }else{
            $model = yii\db\ActiveRecord::findBySql($datas->sql." limit ". $pages->offset.",".$pages->limit)->asArray()->all();
        }
//        var_dump($model);exit;
        //根据登陆者的信息，获取登陆者的角色
        $login_id=Yii::$app->user->id;
        //获取角色id
        $role_id=AdminRoleUser::findOne(['uid'=>$login_id])->role_id;

        //获取入网属性与代号的对应关系
        $usetype_code=yii\db\ActiveRecord::findBySql("select code,use_type from agent_usetype_code")->asArray()->all();
        $arr_code_usetype=array_column($usetype_code,'use_type','code');
        $arr_code_usetype['']='';
//        var_dump($page_size,$page);exit;

        //将姓名重复的挨着一起显示
        if($state4){
            $array_sort=[];
            foreach($model as $v){
//                var_dump($v);exit;
                $array_sort[]=$v["Name"];
            }
            array_multisort($array_sort,SORT_ASC,$model);
            //分页
            $model=array_slice($model,$page_size*($page-1),$page_size);

        }
        //上级
        foreach($model as &$v){
            $parent=$this->GetParentByDevNo($v['DevNo']);
            $v['AgentName']=$parent['agentFname'];
            $v['agentPname']=$parent['agentPname'];
            $v['agentYname']=$parent['agentYname'];
        }

        //当前默认活动
        $default_activity='';
        $default=yii\db\ActiveRecord::findBySql("select Title from activity where State=1 and StartTime < NOW() and EndTime > NOW()")->asArray()->one();
        if($default){
            $default_activity=$default['Title'];
        }
        return $this->render('list', [
            'picture_state' => $picture_state,
            'usetype' => $usetype,
            'role_id' => $role_id,
            'customertype' => $customertype,
            'UserType' => $arr_code_usetype,
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
            'sort'=>$sort,
            'sort2'=>$sort2,
            'page_size' => $page_size,
            'page' => $page,
            'state1' => $state1,
            'state2' => $state2,
            'state3' => $state3,
            'state4' => $state4,
            'state5' => $state5,
            'default_activity' => $default_activity,


            'users_of_init' => $users_of_init,
        ]);
    }

    //进入赏金详情页面
    public function actionMoneyDetail(){
        return $this->renderPartial('money-detail');
    }

    //ajax 获取赏金详情数据
    public function actionGetMoneyDetail(){
        $UserId=$this->getParam('UserId');
        if(!$UserId){
            return json_encode(['state'=>-1,'msg'=>'参数错误']);
        }
        $offset=$this->getParam('offset');
        $limit=$this->getParam('limit');
        if(!$offset&&$limit){
            $offset=0;
            $limit=10;
        }
        $datas=yii\db\ActiveRecord::findBySql("
        select * from (
        select user_info.Name,user_info.Tel,user_recommend_log.RowTime,null as Money,
        user_recommend_log.State,user_recommend_log.FirstMoney,user_recommend_log.DrinkMoney,
        user_recommend_log.Amount
        from user_recommend_log
        left join user_info on user_info.Id=user_recommend_log.UserId
        where user_recommend_log.UserId='$UserId'
        union
        select user_info.Name,user_info.Tel,user_cash_withdrawal_log.RowTime,user_cash_withdrawal_log.Money,
        user_cash_withdrawal_log.State,null as FirstMoney,null as DrinkMoney,null as Amount
        from user_cash_withdrawal_log
        left join user_info on user_info.Id=user_cash_withdrawal_log.UserId
        where user_cash_withdrawal_log.UserId='$UserId')as temp");
        $total=$datas->count();
        $data=yii\db\ActiveRecord::findBySql($datas->sql."order by RowTime desc limit $offset,$limit")->asArray()->all();
        return json_encode(['state'=>0,'data'=>$data,'total'=>$total]);

    }

    //操作详情
    public function actionDetail(){
        $urlobj = $this->getParam("Url");//返回参数记录
        $page_size = $this->getParam("per-page");//每页显示条数
        $page = $this->getParam("page");//第几页

        if(!$page_size){
            $page_size=10;
        }
        if(!$page){
            $page=1;
        }

        $sort=$this->getParam("sort");//点击排序

        if($sort==''){
            $sort=0;
        }
       $order=" order by ActTime desc ";
        if($sort && $sort%2==1){
            $order=" order by ActTime asc ";
        }

        $id=$this->getParam("id");
        $DevNo=$this->getParam("DevNo");
        if(empty($id)||empty($DevNo)){
            Yii::$app->getSession()->setFlash('error', '参数错误');
            return $this->redirect(['list']);
        }

        $sql="select user_info.Tel, dev_regist.DevBindMobile,dev_regist.Province,dev_regist.City,dev_regist.Area, dev_action_log.*,dev_location.`Address`,dev_location.`Lat`,dev_location.`Lng` from dev_action_log
                    left join dev_location on dev_action_log.`DevNo`=dev_location.`DevNo`
                    left join dev_regist on dev_regist.DevNo=dev_action_log.`DevNo`
                    left join user_info on dev_regist.UserId=user_info.`Id`
                    where dev_action_log.UserId='{$id}' and dev_action_log.DevNO={$DevNo} $order ";

        $datas=yii\db\ActiveRecord::findBySql($sql);

        if(ceil($datas->count()/$page_size)<$page){//输入的页数大于总页数
            $page=ceil($datas->count()/$page_size);
        }

        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => $page_size]);
//        $model=$datas->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        $model = yii\db\ActiveRecord::findBySql($datas->sql." limit ". $pages->offset.",".$pages->limit)->asArray()->all();
        return $this->render('detail',[
                                        'model'=>$model,
                                        'pages'=>$pages,
                                        'sort'=>$sort,
                                        'id'=>$id,
                                        'DevNo'=>$DevNo,
                                        'page_size' => $page_size,
                                        'page' => $page,
                                        'url'=>$urlobj
                                        ]);

//        var_dump($model);
    }

    //修改用户
    public function actionUpdate($id){
        $urlobj = $this->getParam("Url");//返回参数记录
        $devno=Yii::$app->request->get('devno');

        if(!$id||!$devno) return $this->render('/error/error', [
            'code' => '403',
            'name' => 'Params required',
            'message' => yii::t('app', "Id or devno doesn't exit"),
        ]);
        //获取该用户信息
        $model=Customer::findone(['Id'=>$id]);
        //获取该用户id和设备编号对应的用户数据   客户类型、入网属性
        $data2=DevRegist::find()->where(['DevNo'=>$devno])->one();
        //获取地址数据
        $data=(new Address())->allQuery()->asArray()->all();
        //获取品牌数据
        $dev_brand=yii\db\ActiveRecord::findBySql("select BrandNo,BrandName from brands where CategoryId=2")->asArray()->all();

        //获取该用户的品牌和型号
        $brand_name=yii\db\ActiveRecord::findBySql("select brand_id, goods_id from dev_regist where DevNo='$devno'")->asArray()->one();
//        var_dump($brand_name);exit;
        $brand_id=$brand_name['brand_id'];
        $goods_id=$brand_name['goods_id'];
        //获取该品牌下的所有的商品数据
        $dev_goods=yii\db\ActiveRecord::findBySql("select id,`name` from goods where category_id=2")->asArray()->all();
        //服务中心数据
        $agent=yii\db\ActiveRecord::findBySql('select Id,Name from agent_info where Level=5 or Level=8 ')->asArray()->all();

        if(!$model) return $this->render('/error/error', [
            'code' => '403',
            'name' => 'Params required',
            'message' => yii::t('app', "user doesn't exit"),
        ]);
        $tel=$model->Tel;//修改前的电话号码（后面对比看是否修改）
        $agent_id=$data2->AgentId;//修改前的所属服务中心（后面对比看是否修改）
        $CustomerType=$data2->CustomerType;//修改前用户类型
        $UserId=$data2->UserId;//修改前用户id
//var_dump($CustomerType);exit;
        if ( Yii::$app->request->isPost ) {


                //接收
                $model->load(Yii::$app->getRequest()->post());//user_info表
                $data2->load(Yii::$app->getRequest()->post());//dev_regist表
            //修改后的用户姓名、电话
            $UserName=$model->Name;
            $new_tel=$model->Tel;

            //sql命令
            $execute1='';
            $execute2='';
            $execute3='';
            $execute4='';

            //修改服务中心时，判断是否已分组
            //是否修改了所属服务中心
            if($agent_id!=$data2->AgentId) {//修改了所属服务中心
                //判断该服务中心是否有该可卖设备
                $result = yii\db\ActiveRecord::findBySql("
                    select id from dev_agent_investor
                    where agent_id=$data2->AgentId and brand_id='$data2->brand_id'
                    and goods_id=$data2->goods_id
                    ")->asArray()->one();
                if (!$result) {//该服务中心没有该可卖设备，不能变更
                    Yii::$app->getSession()->setFlash('error', '该服务中心没有该可卖设备，不能变更');
                    return $this->redirect(['update', 'id' => $id, 'devno' => $devno]);

                }

                $group=yii\db\ActiveRecord::findBySql("select GroupId from user_restmoney
                where UserId='$UserId' and AgentId=$agent_id and CustomerType=$CustomerType")->asArray()->one();
                if($group&&$group['GroupId']>0){
                    Yii::$app->getSession()->setFlash('error', '用户踢出分组后，才能变更服务中心');
                    return $this->redirect(['update', 'id' => $id, 'devno' => $devno]);
                }

            }

            //没有修改电话
            if($tel==$new_tel) {
                $model->Province = $data2->Province;
                $model->City = $data2->City;
                $model->Area = $data2->Area;
                $model->Address = $data2->Address;

                if($agent_id!=$data2->AgentId||$CustomerType!=$data2->CustomerType){//修改了所属服务中心或用户类型
                    //修改电子水票
                    $execute1=Yii::$app->db->createCommand("
                    update user_restmoney set AgentId=$data2->AgentId,CustomerType=$data2->CustomerType
                    where UserId='{$model->Id}'
                    and AgentId=$agent_id and CustomerType=$CustomerType
                    ");
                }
            }
            //电话修改了
            if($tel!=$new_tel){
            //电话修改了，再判断该电话的用户是否存在
                $result=yii\db\ActiveRecord::findBySql("select Id from user_info where Tel='$model->Tel'")->asArray()->one();
                if($result){//存在
                    //判断该用户下是否有设备（除开已初始化的）
                    $dev=yii\db\ActiveRecord::findBySql("
                    select DevNo from dev_regist
                    where AgentId > 0 and not exists
                    (select 1 from dev_cmd where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)
                    and UserId='{$result['Id']}'
                    ")->asArray()->one();

                    if($dev){//该用户下有设备，不能变更
                        Yii::$app->getSession()->setFlash('error', '该用户下有设备，不能变更');
                        return $this->redirect(['update','id'=>$id,'devno'=>$devno]);
                    }

                    //修改该电话的用户信息
                    $model=Customer::findone(['Tel'=>$new_tel]);
                    $model->Name = $UserName;
                    $model->Province = $data2->Province;
                    $model->City = $data2->City;
                    $model->Area = $data2->Area;
                    $model->Address = $data2->Address;


                    //变更（注册表）
                    $data2->UserId=$result['Id'];

                    //修改
                    //判断该服务中心是否有该可卖设备
                    $re = yii\db\ActiveRecord::findBySql("
                    select id from dev_agent_investor
                    where agent_id=$data2->AgentId and brand_id='$data2->brand_id'
                    and goods_id=$data2->goods_id
                    ")->asArray()->one();

                    if (!$re) {//该服务中心没有该可卖设备，不能变更
                        Yii::$app->getSession()->setFlash('error', '该服务中心没有该可卖设备，不能变更');
                        return $this->redirect(['update', 'id' => $id, 'devno' => $devno]);

                    }
                    $now=date('Y-m-d H:i:s');
                    //修改后的电子账户是否存在
                    $account=yii\db\ActiveRecord::findBySql("select Id from user_restmoney
                    where UserId='{$result['Id']}' and AgentId =$data2->AgentId and CustomerType=$data2->CustomerType")->asArray()->one();
                    if($account){//修改电话后的设备对应的电子账户存在
                        //修改前的电子账户信息更新到修改后的
                        $lod_account=yii\db\ActiveRecord::findBySql("select RestMoney,LastActTime,TotalSendV,LastSendV,
                        LastSendDate,LastSendTime,UseVolume,RestWater,SendWaterTime,AverageUse,State,GroupId,CreateTime
                        from user_restmoney where UserId='$UserId' and AgentId=$agent_id and CustomerType=$CustomerType")->asArray()->one();
                        if($lod_account){
                            //修改电子水票
                            $execute1=Yii::$app->db->createCommand("
                            update user_restmoney set RestMoney={$lod_account['RestMoney']},LastActTime='{$lod_account['LastActTime']}',
                            TotalSendV={$lod_account['TotalSendV']},LastSendV={$lod_account['LastSendV']},
                            ".($lod_account['LastSendDate']?"LastSendDate='{$lod_account['LastSendDate']}',":'')." ".($lod_account['LastSendTime']?"LastSendTime='{$lod_account['LastSendTime']}',":'')."
                            UseVolume={$lod_account['UseVolume']},RestWater={$lod_account['RestWater']},SendWaterTime='{$lod_account['SendWaterTime']}',
                            AverageUse={$lod_account['AverageUse']},State={$lod_account['State']},GroupId={$lod_account['GroupId']},CreateTime='{$lod_account['CreateTime']}'
                            where UserId='{$result['Id']}' and AgentId=$data2->AgentId and CustomerType=$data2->CustomerType
                            ");
                        }else{
                            //修改电子水票
                            $execute1=Yii::$app->db->createCommand("
                            update user_restmoney set RestMoney=0,LastActTime=Null,
                            TotalSendV=0,LastSendV=0,
                            LastSendDate=Null,LastSendTime=Null,
                            UseVolume=0,RestWater=0,SendWaterTime='没有送水记录',
                            AverageUse=0,State=1,GroupId=0,CreateTime=Null
                            where UserId='{$result['Id']}' and AgentId=$data2->AgentId and CustomerType=$data2->CustomerType
                            ");
                        }

                    }else{
                        //创建电子账户

                        $execute1=Yii::$app->db->createCommand("
                            insert into user_restmoney (`UserId`,`CustomerType`,`AgentId`,`LastActTime`,`SendWaterTime`)
                            values ('$data2->UserId',$data2->CustomerType,$data2->AgentId,'$now','没有送水记录')
                            ");

                    }

                }else{//修改后该电话的用户不存在

                    //生成用户id
                    $user_id=$this->CreateGuid();
                    $now=date('Y-m-d H:i:s',time());
                    //创建用户
                    $model=new Customer();
                    $model->Id=$user_id;
                    $model->Name=$UserName;
                    $model->Tel=$new_tel;
                    $model->Address=$data2->Address;
                    $model->RowTime=$now;
                    $model->Province=$data2->Province;
                    $model->City=$data2->City;
                    $model->Area=$data2->Area;
//                    Yii::$app->db->createCommand("
//                    insert into user_info (`Id`,`Name`,`Tel`,`Address`,`RowTime`,`Province`,`City`,`Area`)
//                    values ('$user_id','$model->Name','$model->Tel','$data2->Address','$now','$data2->Province','$data2->City','$data2->Area')
//                    ")->execute();

                    //创建电子账户
                    $execute1=Yii::$app->db->createCommand("
                    insert into user_restmoney (`UserId`,`CustomerType`,`AgentId`,`LastActTime`,`SendWaterTime`)
                    values ('$user_id',$data2->CustomerType,$data2->AgentId,'$now','没有送水记录')
                    ");
                    //将该设备关联到该用户下
                    $data2->UserId=$user_id;

                }

            }

                if($model->validate()&&$data2->validate()){
                    //创建事务
                    $transaction = Yii::$app->db->beginTransaction();
                    try{
                        //执行上面的sql命令
                        if($execute1){
                            $re=$execute1->execute();
                            if(!$re){
                                throw new \Exception('保存失败1！');
                            }
                        }
                        if($execute2){
                            $re=$execute2->execute();
                            if(!$re){
                                throw new \Exception('保存失败2！');
                            }
                        }
                        if($execute3){
                            $re=$execute3->execute();
                            if(!$re){
                                throw new \Exception('保存失败3！');
                            }
                        }
                        if($execute4){
                            $re=$execute4->execute();
                            if(!$re){
                                throw new \Exception('保存失败4！');
                            }
                        }



                        if(!$model->save()){
                            throw new \Exception('保存失败5！');
                        }
                        if(!$data2->save()){
                            throw new \Exception('保存失败6！');
                        }

                        $transaction->commit();

                        Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
                        return $this->redirect(['list']);

                    }catch (yii\db\Exception $e) {
                        //回滚
                        $transaction->rollBack();
                        Yii::$app->getSession()->setFlash('error', $e->getMessage());
                        //Yii::$app->getSession()->setFlash('error', '保存失败');
                        return $this->redirect(['update', 'id' => $id, 'devno' => $devno]);

//                        var_dump($e->getMessage());  //打印抛出的错误
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

        //获取对应服务中心的入网属性数据
        $use_type=yii\db\ActiveRecord::findBySql("select code,use_type from agent_usetype_code where agent_id=$data2->AgentId or agent_id=0 and state=0")->asArray()->all();

        return $this->render('update', [
            'use_type'=>$use_type,//入网属性数据
            'agent'=>$agent,//服务中心数据
            'model' => ["model"=>$model,
                "data"=>json_encode($data),
                'data2'=>$data2,
                'dev_brand'=>json_encode($dev_brand),
                'dev_goods'=>json_encode($dev_goods),
                'brand_id'=>$brand_id,
                'goods_id'=>$goods_id,
            ],
            'url'=>$urlobj
        ]);
    }

    //ajax获取对应设备品牌下的所有商品
    public function actionGetGoods(){
        $brand_id=$this->getParam('brand_id');
        $goods=yii\db\ActiveRecord::findBySql("select id,`name` from goods where brand_id='$brand_id' and category_id=2")->asArray()->all();
        return $goods;
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

    //解绑
    public function actionUntie(){
        $CodeNumber=trim($this->getParam('CodeNumber'));
        $devno=trim($this->getParam('devno'));

        if(!$CodeNumber||!$devno) return $this->render('/error/error', [
            'code' => '403',
            'name' => 'Params required',
            'message' => yii::t('app', "CodeNumber or devno doesn't exit"),
        ]);

        $data=yii\db\ActiveRecord::findBySql("select CodeNumber from dev_regist where DevNo='$devno' and CodeNumber='$CodeNumber'")->asArray()->one();
        if(!$data){
            Yii::$app->getSession()->setFlash('error', '该数据不存在');
            return $this->redirect(['list']);
        }

        $sql="update dev_regist set CodeNumber=Null where DevNo='$devno' and CodeNumber='$CodeNumber'";
        $re=Yii::$app->db->createCommand($sql)->execute();
        if($re){
            //初始化该设备
            $now=date('Y-m-d H:i:s',time());
            $ExpiredTime=date('Y-m-d H:i:s',time()+3600);
            $sql="insert into dev_cmd (DevNo,StartTime,ExpiredTime,CmdType,Cmd,RowTime)
VALUES ('$devno','$now','$ExpiredTime',4,'','$now')";

            $res=\Yii::$app->db->createCommand($sql)->execute();

            Yii::$app->getSession()->setFlash('success', '解绑成功');
            return $this->redirect(['list']);
        }
        Yii::$app->getSession()->setFlash('error', '解绑失败');
        return $this->redirect(['list']);


    }

    //生成唯一id
    public function CreateGuid(){
        $charid = strtolower(md5(uniqid(mt_rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = substr($charid, 6, 2).substr($charid, 4, 2).
            substr($charid, 2, 2).substr($charid, 0, 2).
            substr($charid, 10, 2).substr($charid, 8, 2).
            substr($charid,14, 2).substr($charid,12, 2).
            substr($charid,16, 4).
            substr($charid,20,12);
        return $uuid;
    }

    //确认上传图片是否通过
    public function actionCheckPicture(){
        $DevNo=$this->getParam('DevNo');
        $Image=$this->getParam('Image');
        $ImageErrorReason=trim($this->getParam('ImageErrorReason'));//图片错误原因
        $IsOk=$this->getParam('IsOk');//1 通过验证，-1 不通过
        if(!$DevNo||!$Image||!$IsOk){
           return json_encode(['state'=>-1,'msg'=>'参数错误']);
        }
        if($IsOk==-1&&!$ImageErrorReason){
            return json_encode(['state'=>-1,'msg'=>'必须填写原因']);
        }
        if($IsOk==-1){//不通过
            $sql=" update dev_regist set ImageState=3,ImageErrorReason='$ImageErrorReason' where DevNo='$DevNo' ";
        }else{
            $sql=" update dev_regist set Image='$Image',TempImage='',ImageState=2 where DevNo='$DevNo' ";
        }
        $re=Yii::$app->db->createCommand($sql)->execute();
        if($re){
            return json_encode(['state'=>0]);
        }
        return json_encode(['state'=>-1,'msg'=>'操作失败']);
    }

    //ajax 保存用户挥度测试
    public function actionSaveUserTest(){
        $ids=$this->getParam('ids');
        if(!$ids){
            return json_encode(['state'=>-1,'msg'=>'参数错误']);
        }
        $sql="update user_info set `IsUse`=1 where Id in ($ids)";
        $re=Yii::$app->db->createCommand($sql)->execute();
        if($re){
            return json_encode(['state'=>0,'num'=>$re]);
        }
        return json_encode(['state'=>-1,'msg'=>'失败']);
    }

}