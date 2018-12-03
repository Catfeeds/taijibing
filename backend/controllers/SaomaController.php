<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/4/9
 * Time: 上午9:33
 */

namespace backend\controllers;

use backend\models\Address;
use backend\models\AgentInfo;
use backend\models\DevWaterScan;
use yii\data\Pagination;
use yii;
class SaomaController extends  BaseController
{
    //入网属性
    public $UserType=[
        ''=>'',
        0=>'',
        1=>'自购',
        2=>'押金',
        3=>'买水借机',
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
        //点击刷新时real_time=1
        $real_time=$this->getParam('real_time');//1 实时获取，0
        //点击查询时
        $real_search=$this->getParam('real_search');//1 实时获取，0

        $page_size = $this->getParam("per-page");//每页显示条数
        $page = $this->getParam("page");//第几页

        if(!$page_size){
            $page_size=10;
        }
        if(!$page){
            $page=1;
        }



        $province=$this->getParam("province");
        $city=$this->getParam("city");
        $area=$this->getParam("area");

        $selecttime=$this->getParam("selecttime");
        //默认统计近一周的
//        $date1=date('Y-m-d',strtotime('-6 day'));
//        $date2=date('Y-m-d',time());
//        if(empty($selecttime)){
//            $selecttime=$date1."至".$date2;
//        }

        $content=addslashes($this->getParam("content"));

        $state=$this->getParam("state");
        if(!$state){
            $state=1;//1:正常设备 2:已初始化的 3：未绑定用户的设备
        }
        $sort=$this->getParam("sort");//点击排序


        if($sort==''){
            $sort=0;
        }
        //有刷新或有搜索，实时读取
//        if($real_time||$real_search){

            $datas = DevWaterScan::totalQuery($state,$selecttime,$content,$province,$city,$area,$sort);

            $pages = new Pagination(['totalCount' => $datas->count(), 'PageSize' => $page_size]);

            $model=yii\db\ActiveRecord::findBySql($datas->sql.' limit '.$pages->offset.','.$pages->limit)->asArray()->all();

            //$model =$this->listWrapData($data);
//        }else{//没有刷新、没有搜索，从缓存文件取
//
//            $saoma_datas=json_decode(trim(substr(file_get_contents('../web/datas/SaoMaLogDatas.php'), 15)));
//            $result=json_decode($saoma_datas->datas);
//            $pages = new Pagination(['totalCount' => json_decode($saoma_datas->total), 'PageSize' => $page_size]);
//
//            $model=array_slice($result,$pages->offset,$pages->limit);
//            foreach($model as &$v){
//                if(is_object($v)){
//                    $v=(array)$v;
//                }
//            }
//        }

        //上级
        foreach($model as &$v){
            $parent=$this->GetParentByDevNo($v['DevNo']);
            $v['agentname']=$parent['agentFname'];
//                $v['agentPname']=$parent['agentPname'];
            $v['agentpname']=$parent['agentYname'];
        }


        //获取已初始化的设备编号
        $DevNos=yii\db\ActiveRecord::findBySql("select DevNo from dev_cmd
        where CmdType=4 and State=1 GROUP BY DevNo")->asArray()->all();

        $users_of_init=[];
        foreach($DevNos as $DevNo){
            $users_of_init[]=$DevNo['DevNo'];
        }

        $areas=Address::allQuery()->asArray()->all();

        //获取导出表格时的数据总条数
        $total=yii\db\ActiveRecord::findBySql("select count(*) as num from (select DevNo from dev_water_scan_log group by BarCode,DevNo)as temp ")->asArray()->one()['num'];

        return $this->render('list', [
            'model' => $model,
            'pages' => $pages,
            'selecttime'=>$selecttime,
            'content'=>$content,
            'areas' =>$areas,
            'sort' =>$sort,
            'province'=>empty($province)?"":$province,
            'city'=>empty($city)?"":$city,
            'area'=>empty($area)?"":$area,
            'page_size' => $page_size,
            'page' => $page,
            'state' => $state,
            'total' => $total,

            'users_of_init' => $users_of_init,
        ]);
    }


    //水厂条码使用记录
    public function actionFlist()
    {
        $urlobj = $this->getParam("Url");//返回参数记录
        $page_size = $this->getParam("per-page");//每页显示条数
        $page = $this->getParam("page");//第几页

        if(!$page_size){
            $page_size=10;
        }
        if(!$page){
            $page=1;
        }



        $content=addslashes(trim($this->getParam("content")));
        $selecttime=$this->getParam("selecttime");
        $sort=$this->getParam("sort");//点击排序
        $sort2=$this->getParam("sort2");//点击排序
        if($sort==''){
            $sort=0;
        }
        if($sort2==''){
            $sort2=0;
        }

        $pid=$this->getParam("pid");
        $BrandName=$this->getParam("BrandName");
        $goodsname=$this->getParam("goodsname");
        $Volume=$this->getParam("Volume");
//        var_dump($pid,$BrandName,$goodsname,$Volume);exit;
        if(empty($pid)){
            Yii::$app->getSession()->setFlash('error', "参数错误");
            return $this->redirect(['logic-user/factory-list']);
        }
        if(empty($BrandName)||empty($goodsname)||empty($Volume)){
            Yii::$app->getSession()->setFlash('error', "请先充值");
            return $this->redirect(['logic-user/factory-list']);
        }
        $brand_id=yii\db\ActiveRecord::findBySql("select BrandNo from brands where BrandName='$BrandName'")->asArray()->one()['BrandNo'];
        $goods_id=yii\db\ActiveRecord::findBySql("select id from goods
where `name`='$goodsname' and volume=$Volume and brand_id='$brand_id'")->asArray()->one()['id'];

        $datas = DevWaterScan::totalQuery2($pid,$brand_id,$goods_id,$Volume,$content,$selecttime,$sort,$sort2);

        if(ceil($datas->count()/$page_size)<$page){//输入的页数大于总页数
            $page=ceil($datas->count()/$page_size);
        }

        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => $page_size]);
//        var_dump($pages);exit;

//        $model =$this->listWrapData(DevWaterScan::pageQuery($pages->offset,$pages->limit,'','','',$waterfname)->asArray()->all());
//        $model =$datas->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        $model = yii\db\ActiveRecord::findBySql($datas->sql." limit ". $pages->offset.",".$pages->limit)->asArray()->all();
//        var_dump($model);exit;





//var_dump($waterfname);exit;
        return $this->render('flist2', [
            'model' => $model,
            'pages' => $pages,
            'sort' => $sort,
            'sort2' => $sort2,
            'selecttime' => $selecttime,
            'content' => $content,
            'page_size' => $page_size,
            'page' => $page,

            'pid' => $pid,
            'BrandName' => $BrandName,
            'goodsname' => $goodsname,
            'Volume' => $Volume,
            'url'=>$urlobj

        ]);




//        $waterfname=yii::$app->request->get("waterfname");
//        $datas = DevWaterScan::totalQuery('','','',$waterfname);
//        $pages = new Pagination(['totalCount' => $datas->count(), 'pageSize' => 10]);
//        $model =$this->listWrapData(DevWaterScan::pageQuery($pages->offset,$pages->limit,'','','',$waterfname)->asArray()->all());
//        return $this->render('flist', [
//            'model' => $model,
//            'pages' => $pages,
//        ]);
    }
    public function listWrapData($list){

        $listTemp=[];
        foreach($list as $val){
            $agentId=$val["agentId"];

//            if(empty($agentId)){
//                continue;
//            }
            if(empty($agentId)){

                $agentId=-1;

                $val["agentpname"]="-";
                $val["agentname"]="-";
            }
            $agentInfo=(new AgentInfo())->getAgentInfoById($agentId);

//            if(empty($agentInfo)){
//                continue;
//            }
            if(empty($agentInfo)){
                $val["agentpname"]="-";
                $val["agentname"]="-";
            }

            if($agentInfo["Level"]==4){
                $val["agentpname"]=$agentInfo["Name"];
                $val["agentname"]="-";
            }else{
                //社区
                $parentId=$agentInfo["ParentId"];
                $val["agentname"]=$agentInfo["Name"];
                if(empty($parentId)){
                    $val["agentpname"]="-";
                }else{
                    $agentpInfo=(new AgentInfo())->getAgentInfoById($parentId);
                    $val["agentpname"]=$agentpInfo["Name"];

                }
            }
            $listTemp[]=$val;
        }
        return $listTemp;
    }

    //获取对应设备的扫码详情
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

        $DevNo=$this->getParam("DevNo");
        $excel=$this->getParam("excel");


//        if($DevNo==''){
//            Yii::$app->getSession()->setFlash('error', "参数错误");
//            $this->goBack();
//            exit();
//        }


        $selecttime=$this->getParam("selecttime");

        //默认统计近一周的
//        if(empty($selecttime)){
//            $date1=date('Y-m-d',strtotime('-6 day'));
//            $date2=date('Y-m-d',time());
//            $selecttime=$date1."至".$date2;
//        }

        $content=addslashes($this->getParam("content"));

        $factory_id=$this->getParam("factory_id");
        $water_brandno=$this->getParam("water_brandno");
        $water_goods_id=$this->getParam("water_goods_id");
        $water_volume=$this->getParam("water_volume");

        $datas = DevWaterScan::totalQuery3($factory_id,$water_brandno,$water_goods_id,$water_volume,$DevNo,$selecttime,$content,$sort);
//var_dump($datas);exit;

        if($DevNo==''&&$excel=='xDME7Ea6BS5KFyYAw27rRi78HiNFGgpz'){
            if($page_size>50000)$page_size=50000;
            $this->SaomaLog($datas->sql." limit 0,$page_size");
            exit;
        }

        if(ceil($datas->count()/$page_size)<$page){//输入的页数大于总页数
            $page=ceil($datas->count()/$page_size);
        }

        $pages = new Pagination(['totalCount' => $datas->count(),
            'PageSize' => $page_size]);

//        $datas2=DevWaterScan::pageQuery3($DevNo,$selecttime,$content,$sort);

//        $sql=yii\db\ActiveRecord::findBySql($datas->sql." limit ".$pages->offset.",".$pages->limit)->sql;

//        $model =$this->listWrapData(yii\db\ActiveRecord::findBySql($datas->sql." limit ".$pages->offset.",".$pages->limit)->asArray()->all());


        $model =yii\db\ActiveRecord::findBySql($datas->sql." limit ".$pages->offset.",".$pages->limit)->asArray()->all();

        //上级
        foreach($model as &$v){
            $parent=$this->GetParentByDevNo($v['DevNo']);
            $v['agentname']=$parent['agentFname'];
//            $v['agentPname']=$parent['agentPname'];
            $v['agentpname']=$parent['agentYname'];
        }


        $areas=Address::allQuery()->asArray()->all();
        //水厂数据
        $factory=yii\db\ActiveRecord::findBySql("select Id,`Name` from factory_info")->asArray()->all();
        //水品牌
        $water_brands=yii\db\ActiveRecord::findBySql("select BrandNo,BrandName from brands where CategoryId=1")->asArray()->all();
        //水商品名称
        $water_goods=yii\db\ActiveRecord::findBySql("select id,`name`,brand_id from goods where category_id=1 and state=0")->asArray()->all();
        //容量
        $water_volumes=yii\db\ActiveRecord::findBySql("select brand_id,`name`,volume from goods where category_id=1 and state=0 group by brand_id,`name`,volume")->asArray()->all();

        //获取入网属性数据
        $type=yii\db\ActiveRecord::findBySql("select `code`,use_type from agent_usetype_code")->asArray()->all();
        $UserType=array_column($type,'use_type','code');
//        var_dump($UserType);exit;

//        if($DevNo==''){
//            return $model;
//        }

        return $this->render('detail', [
            'model' => $model,
            'DevNo' => $DevNo,
            'pages' => $pages,
            'selecttime'=>$selecttime,
            'content'=>$content,
            'areas' =>$areas,
            'sort' =>$sort,
            'page_size' => $page_size,
            'page' => $page,
            'UserType' => $UserType,
            'CustomerType' => $this->CustomerType,

            'factory' => $factory,
            'water_brands' => $water_brands,
            'water_goods' => $water_goods,
            'water_volumes' => $water_volumes,

            'factory_id'=>$factory_id,
            'water_brandno'=>$water_brandno,
            'water_goods_id'=>$water_goods_id,
            'water_volume'=>$water_volume,
            'url'=>$urlobj

        ]);


    }

    //导出表格
    public function Excel($model){
        //------------
        $filename = '扫码记录'.date('YmdHis');
        $header = array('水厂条码','设备编号','水厂','水品牌','商品名称','商品容量(L)','省','市','区','位置信息','设备商品型号','设备品牌','设备厂家','设备投资商','服务中心','运营中心','入网属性','用户类型','用户姓名','手机号','扫码时间');
        $index = array('BarCode','DevNo','factoryName','water_brand','water_name','Volume','Province','City','Area','Address','goodsname','BrandName','devfactoryname','investor','agentname','agentpname','UseType','CustomerType','Name','Tel','RowTime');
        $datas=$this->createtable($model,$filename,$header,$index);
//        var_dump($datas2);exit;
        return $datas;
        //--------------
    }

    protected function createtable($list,$filename,$header=array(),$index = array()){
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:filename=".$filename.".xls");
        $teble_header = implode("\t",$header);
        $strexport = $teble_header."\r";
        foreach ($list as $row){
            foreach($index as $val){
                $strexport.=$row[$val]."\t";
            }
            $strexport.="\r";

        }
        $strexport=iconv('UTF-8',"GB2312//IGNORE",$strexport);
        exit($strexport);
    }


    //导出表格
    public function SaomaLog($sql){
        ini_set("memory_limit", "1024M");
        set_time_limit(0);

        $data = yii\db\ActiveRecord::findBySql($sql)->asArray()->all();

        //设置导出的文件名
        $fileName = iconv('utf-8', 'gbk', '扫码记录'.date("Y-m-d H:i:s"));

        //设置表头
        $headlist = array('水厂条码','设备编号','水厂','水品牌','商品名称','商品容量(L)','省','市','区','位置信息','设备商品型号','设备品牌','设备厂家','设备投资商','服务中心','运营中心','入网属性','用户类型','用户姓名','手机号','扫码时间');

        header('Content-Type: application/vnd.ms-excel');

        //指明导出的格式
        header('Content-Disposition: attachment;filename="'.$fileName.'.csv"');
        header('Cache-Control: max-age=0');

        //打开PHP文件句柄,php://output 表示直接输出到浏览器
        $fp = fopen('php://output', 'a');

        //输出Excel列名信息
        foreach ($headlist as $key => $value) {
            //CSV的Excel支持GBK编码，一定要转换，否则乱码
            $headlist[$key] = iconv('utf-8', 'gbk', $value);
        }

        //将数据通过fputcsv写到文件句柄
        fputcsv($fp, $headlist);

        //每隔$limit行，刷新一下输出buffer，不要太大，也不要太小
        $limit = 10000;

        //逐行取出数据，不浪费内存
        foreach ($data as $k => $v) {
            //刷新一下输出buffer，防止由于数据过多造成问题
            if ($k % $limit == 0 && $k!=0) {
                ob_flush();
                flush();
            }
            $row = $data[$k];
            foreach ($row as $key => $value) {
                if($key=='Tel'||$key=='DevNo'||$key=='BarCode'){
                    $value="’".$value;
                }

                $row[$key] = iconv('utf-8', 'gbk', $value);
            }
            fputcsv($fp, $row);
        }
        return;
    }




}