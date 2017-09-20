<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/4/6
 * Time: 下午5:35
 */

namespace backend\controllers;

use backend\models\Address;
use backend\models\AdminRoles;
use backend\models\AdminRoleUser;
use backend\models\AgentInfo;
use backend\models\CustomSearch;
use backend\models\DevCmd;
use backend\models\DevFactory;
use backend\models\DevLocation;
use backend\models\FactoryInfo;
use yii\data\Pagination;
use backend\models\DevRegist;
use yii;


class DevManagerController extends BaseController
{

    public function actionList()
    {

        $search=$this->getParam("search");
        $province=$this->getParam("province");
        $city=$this->getParam("city");
        $area=$this->getParam("area");

//        $datas =DevRegist::allQuery($devno,$xname,$sname,$mobile,$devf,$tel,$province,$city,$area);
        $datas =DevRegist::allQuery2($search,$province,$city,$area);
//        var_dump($datas);exit;

        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => 10]);
        $querys =DevRegist::pageQuery2($pages->offset,$pages->limit,$search,$province,$city,$area);
        $model =$this->listWrapData($querys->asArray()->all());
        foreach($model as &$v){
            $data=DevFactory::findOne(['Name'=>$v['DevFactory']]);
            if($data){
                $v['Type']=$data->Type;
            }else{
                $v['Type']='';
            }
            $data2=CustomSearch::findOne(['Tel'=>$v['Tel']]);

            if($data2){
                $v['UserName']=$data2->Name;
            }else{
                $v['UserName']='';
            }

//            var_dump($v['UserName']);exit;
        }

        $address=(new Address())->allQuery()->asArray()->all();

        //根据登陆者的信息，获取登陆者的角色
        $login_id=Yii::$app->user->id;
        //获取角色id
        $role_id=AdminRoleUser::findOne(['uid'=>$login_id])->role_id;



        $waterFlist=FactoryInfo::find()->asArray()->all();
        $address=(new Address())->allQuery()->asArray()->all();
        return $this->render('list', [
            'search' => $search,
            'role_id' => $role_id,
            'model' => $model,
            'pages' => $pages,
            'devno' =>empty($devno)?"":$devno,
            'xname' =>empty($xname)?"":$xname,
            'sname'=>empty($sname)?"":$sname,
            'mobile'=>empty($mobile)?"":$mobile,
            'devf'=>empty($devf)?"":$devf,
            'tel'=>empty($tel)?"":$tel,
            'address'=>$address,
            'province'=>empty($province)?"":$province,
            'city'=>empty($city)?"":$city,
            'area'=>empty($area)?"":$area,
            'waterFs'=>$waterFlist
        ]);
    }
    public function actionDevList(){
        $devno=yii::$app->request->post("devno");
        $xname=yii::$app->request->post("xname");
        $sname=yii::$app->request->post("sname");

        $datas =DevRegist::allQuery($devno,$xname,$sname);
        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => 10]);
        $querys =DevRegist::pageQuery($pages->offset,$pages->limit,$devno,$xname,$sname);
        $model =$this->listWrapData($querys->asArray()->all());
        $waterFlist=FactoryInfo::find()->asArray()->all();
        return $this->render('dev-list', [
            'model' => $model,
            'pages' => $pages,
            'devno' =>empty($devno)?"":$devno,
            'xname' =>empty($xname)?"":$xname,
            'sname'=>empty($sname)?"":$sname,
            'waterFs'=>$waterFlist
        ]);
    }
    public function listWrapData($list){
        $listTemp=[];
        foreach($list as $val){
            $agentId=$val["AgentId"];
            $agentInfo=(new AgentInfo())->getAgentInfoById($agentId);
            if($agentInfo["Level"]==4){
                $val["agentpname"]=$agentInfo["LoginName"];
                $val["agentname"]="-";
            }else{
                //社区
                $parentId=$agentInfo["ParentId"];
                $val["agentname"]=$agentInfo["LoginName"];
                if(empty($parentId)){
                    $val["agentpname"]="-";
                }else{
                    $agentpInfo=(new AgentInfo())->getAgentInfoById($parentId);
                    $val["agentpname"]=$agentpInfo["LoginName"];

                }
            }
            $listTemp[]=$val;
        }
        return $listTemp;
    }
    public function actionDynamic(){

//        $tel=yii::$app->request->get("tel");
        $content=yii::$app->request->get("content");
        $province=yii::$app->request->get("province");
        $city=yii::$app->request->get("city");
        $area=yii::$app->request->get("area");

        $datas =DevRegist::dynamicAllQuery($content,$province,$city,$area);
        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => 10]);
        $querys =DevRegist::dynamicPageQuery($pages->offset,$pages->limit,$content,$province,$city,$area);
        $areas=Address::allQuery()->asArray()->all();
        $model = $querys->asArray()->all();
        //获取用户名
        foreach($model as &$v){
            $data=CustomSearch::findOne(['Id'=>$v['UserId']]);
            if($data){
                $v['UserName']=$data->Name;
            }else{
                $v['UserName']='';
            }
        }


//        var_dump($model);exit;

        return $this->render('dynamic', [
            'model' => $model,
            'areas' =>$areas,
            'pages' => $pages,
//            'tel' =>empty($tel)?"":$tel,
            'content' =>empty($content)?"":$content,
            'province' =>empty($province)?"":$province,
            'city' =>empty($city)?"":$city,
            'area' =>empty($area)?"":$area,

        ]);
    }

    public function actionSendOrder(){

        $CmdType=yii::$app->request->get("CmdType");
        $Cmd=yii::$app->request->get("Cmd");
        $StartTime=yii::$app->request->get("StartTime");
        $ExpiredTime=yii::$app->request->get("ExpiredTime");
        $DevNo=yii::$app->request->get("DevNo");
        if(!is_numeric($CmdType)||empty($StartTime)||empty($ExpiredTime)||empty($DevNo)){
            $this->jsonReturn($this->getWrapData(-1,null,"参数错误"));
            return;
        }
        $devnos=explode(",",$DevNo);
         $devcmd=new DevCmd();
        try{
            foreach($devnos as $val){
                $devcmd->add($val,$StartTime,$ExpiredTime,$Cmd,$CmdType);
            }
            $this->jsonReturn($this->getWrapData(0,null,''));
        }catch(yii\base\Exception $e){
            $this->jsonReturn($this->getWrapData(-1,null,$e->getMessage()));
        }

    }
    public function actionMap(){
        $data=(new Address())->allQuery()->asArray()->all();
      return  $this->renderPartial("map",["address"=>$data]);
    }
    public function actionGetMarkers(){
        $usertype=$this->getParam("user_type");
        if(empty(trim($usertype))){
            return $this->jsonReturn($this->getWrapData(0,[],''));
        }
        $usertypeArr=explode(",",$usertype);
        $points=[];
        foreach($usertypeArr as $val){
            switch($val){
                //水厂
                case 1:$points=$this->array_push_all($points,$this->getFactoryPoints());break;
                //县区运营中心
                case 2:$points=$this->array_push_all($points,$this->getAgentList(4,2));break;
                //社区服务中心
                case 3:$points=$this->array_push_all($points,$this->getAgentList(5,3));break;
                //设备厂家
                case 4:$points=$this->array_push_all($points,$this->getDevManagers());break;
                //饮水机用户
                case 5:$points=$this->array_push_all($points,$this->getCustomers());break;

            }
        }
        return $this->jsonReturn($points);
    }
    public function getDevManagers(){
        $province=$this->getParam("province");
        $city=$this->getParam("city");
        $area=$this->getParam("area");
        $where='';
        if(!empty($province)){
            $where.="dev_factory.Province='$province'";
        }
        if(!empty($city)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="dev_factory.City='$city'";
        }
        if(!empty($area)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="dev_factory.Area='$area'";
        }
        $devManagers=DevFactory::findBySql("select BaiDuLat,BaiDuLng from dev_factory ".(empty($where)?"":" where ".$where))->asArray()->all();
        $temp=[];
        foreach($devManagers as $val){
            if(empty($val["BaiDuLat"])||empty($val["BaiDuLng"])){
                continue;
            }
            $val["user_type"]=4;
            array_push($temp,$val);
        }
        return $temp;


    }
    public function getCustomers(){
        $province=$this->getParam("province");
        $city=$this->getParam("city");
        $area=$this->getParam("area");
        $where='';
        if(!empty($province)){
            $where.="dev_regist.Province='$province'";
        }
        if(!empty($city)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="dev_regist.City='$city'";
        }
        if(!empty($area)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="dev_regist.Area='$area'";
        }
        $users=DevLocation::findBySql("select dev_location.BaiDuLat,dev_location.BaiDuLng from dev_location inner join dev_regist on dev_location.DevNo=dev_regist. DevNo".(empty($where)?"":" where ".$where))->asArray()->all();
        $temp=[];
        foreach($users as $val){
            if(empty($val["BaiDuLat"])||empty($val["BaiDuLng"])){
                continue;
            }
            $val["user_type"]=5;
            array_push($temp,$val);
        }
        return $temp;
    }
    public function getFactoryPoints(){
        $province=$this->getParam("province");
        $city=$this->getParam("city");
        $area=$this->getParam("area");
        $where='';
        if(!empty($province)){
            $where.="factory_info.Province='$province'";
        }
        if(!empty($city)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="factory_info.City='$city'";
        }
        if(!empty($area)){
            if(!empty($where)){
                $where.=" and ";
            }
            $where.="factory_info.Area='$area'";
        }
       $factList=  FactoryInfo::findBySql("select BaiDuLat,BaiDuLng from factory_info".(empty($where)?"":" where ".$where))->asArray()->all();
       $temp=[];
        foreach($factList as $val){
            if(empty($val["BaiDuLat"])||empty($val["BaiDuLng"])){
                continue;
            }
            $val["user_type"]=1;
            array_push($temp,$val);
        }
        return $temp;
    }
    public function getAgentList($level,$usertype){
        $province=$this->getParam("province");
        $city=$this->getParam("city");
        $area=$this->getParam("area");
        $where= "LEVEL =".$level;
        if(!empty($province)){
            $where.=" and agent_info.Province='$province'";
        }
        if(!empty($city)){

            $where.=" and agent_info.City='$city'";
        }
        if(!empty($area)){

            $where.=" and agent_info.Area='$area'";
        }
       $userList= AgentInfo::findBySql("select BaiDuLat,BaiDuLng from agent_info where ".$where)->asArray()->all();
        $temp=[];
        foreach($userList as $val){
            if(empty($val["BaiDuLat"])||empty($val["BaiDuLng"])){
                continue;
            }
            $val["user_type"]=$usertype;
            array_push($temp,$val);
        }
        return $temp;
    }

    public function array_push_all($oriArr,$arr){
        foreach($arr as $val){
            array_push($oriArr,$val);
        }
        return $oriArr;
    }


    //详情
    public function actionDetail($DevNo){
        if($DevNo=='') return $this->render('/error/error', [
            'code' => '403',
            'name' => 'Params required',
            'message' => yii::t('app', "DevNo doesn't exit"),
        ]);
        //获取该设备的所有操作记录
        $datas=yii\db\ActiveRecord::findBySql("select * from dev_action_log where DevNo=$DevNo order by dev_action_log.ActTime desc ");
        $pages = new Pagination(['totalCount' => $datas->count(), 'defaultPageSize' => 10]);
        $model=$datas->asArray()->all();

        return $this->render('detail',['model'=>$model,'pages'=>$pages]);


    }


}