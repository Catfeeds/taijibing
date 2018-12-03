<?php
namespace backend\controllers;
//库存管理
use yii\base\Exception;
use yii\db\ActiveRecord;

class StockManageController extends BaseController{
    //库存管理页面
    public function actionIndex(){
        //搜索条件、下拉框数据
        //一级分类
        $category1=ActiveRecord::findBySql('select Id,Name from goods_category where Level=1 and ParentId=0')->asArray()->all();
        //二级分类
        $category2=ActiveRecord::findBySql('select Id,Name,ParentId from goods_category where Level=2 and ParentId>0')->asArray()->all();

        //商品一级分类、二级分类、品牌、型号
        $goods_brand=ActiveRecord::findBySql('
        select goods.category_id,goods.category2_id,goods.brand_id,
        brands.BrandName,goods.id as goods_id,goods.name as goods_name,
        goods.volume
        from goods
        left join brands on brands.BrandNo=goods.brand_id'
        )->asArray()->all();

        //搜索条件
        $category_one=$this->getParam('category_one');//一级分类
        $category_two=$this->getParam('category_two');//二级分类
        $BrandName=$this->getParam('BrandName');//品牌
        $goods_name=$this->getParam('goods_name');//商品
        $level=$this->getParam('level');//角色 4运营中心、5服务中心
        $search=$this->getParam('search');//搜索内容
        //分页
        $offset=$this->getParam('offset');
        $limit=$this->getParam('limit');
        if(!$offset||!$limit){
            $offset=0;
            $limit=10;
        }

        //已选条件数据
        $checked_datas=json_encode([
            'category_one'=>$category_one,
            'category_two'=>$category_two,
            'BrandName'=>$BrandName,
            'goods_name'=>$goods_name,
            'level'=>$level,
            'search'=>$search,
            'offset'=>$offset,
            'limit'=>$limit,
        ]);

        //下拉框数据
        $select_datas=json_encode([
            'category_one'=>$category1,
            'category_two'=>$category2,
            'goods_brand'=>$goods_brand,
        ]);

        $datas=$this->GetDatas($category_one,$category_two,$BrandName,$goods_name,$level,$search,$offset,$limit);
//        var_dump($datas);exit;
        return $this->renderPartial('index',[
            'select_datas'=>$select_datas,
            'checked_datas'=>$checked_datas,
            'form_datas'=>$datas,
        ]);
    }

    public function GetDatas($category_one,$category_two,$BrandName,$goods_name,$level,$search,$offset,$limit){

        //排序
        $sort=$this->getParam('sort');//排序 奇数升序，偶数降序
        $sort_column=$this->getParam('sort_column');//排序字段stock库存、update_time更新时间
        $order="order by stock asc";
        if($sort_column&&in_array($sort_column,['stock','update_time'])){
            if($sort%2==1){//奇数升序
                $order="order by $sort_column asc";
            }else{
                $order="order by $sort_column desc";
            }

        }

        $where='';
        if($category_one){
            $where=" goods.category_id='$category_one' ";
        }
        if($category_two){
            if($where)$where.=' and ';
            $where.=" goods.category2_id='$category_two' ";
        }
        if($BrandName){
            if($where)$where.=' and ';
            $where.=" brands.BrandNo='$BrandName' ";
        }
        if($goods_name){
            if($where)$where.=' and ';
            $where.=" goods.id='$goods_name' ";
        }
        if($level){
            if($where)$where.=' and ';
            $where.=" agent_info.Level='$level' ";
        }
        if($search){
            if($where)$where.=' and ';
            $where.=" (agent_info.Name like '%$search%'
            or agent_info.ContractUser like '%$search%'
            or agent_info.ContractTel like '%$search%') ";
        }

        $data=ActiveRecord::findBySql("
        select agent_info.Id,agent_info.Level,agent_info.Name,agent_info.ContractUser,
        agent_info.ContractTel,goods.name as goods_name,brands.BrandName,
        goods_category.Name as category_one,goods_category2.Name as category_two,
        agent_stock.stock,goods.id as goods_id,goods.brand_id,goods.category_id,
        goods.category2_id,goods.volume,agent_stock.update_time,
        agent_stock.factory_id,factory_info.Name as FactoryName
        from agent_info
        left join agent_stock on agent_stock.agent_id=agent_info.Id
        left join (select Id,`Name` from factory_info UNION select Id,`Name` from dev_factory) as factory_info
        on factory_info.Id=agent_stock.factory_id
        left join goods on goods.id=agent_stock.goods_id
        left join brands on brands.BrandNo=goods.brand_id
        left join goods_category on goods_category.Id=goods.category_id and goods_category.Level=1
        left join goods_category as goods_category2 on goods_category2.Id=goods.category2_id and goods_category2.Level=2
        where (agent_info.Level=4 or agent_info.Level=5)
        ".(!empty($where)?" and $where ":''));
        $total=$data->count();
        $datas=ActiveRecord::findBySql($data->sql." $order limit $offset,$limit")->asArray()->all();

        //供应商、设备厂家 是两个不同的表，可能导致厂家id一样---(已将dev_factory表的id初始值设大，可以先忽略)
        //根据分类获取对应的厂家
//        $dev_factory=ActiveRecord::findBySql("select Id,`Name` from dev_factory")->asArray()->all();
//        $arr_dev_factory=array_column($dev_factory,'Name','Id');
//        foreach($datas as &$v){
//            if($v['category_id']==2){//设备
//                $v['FactoryName']=$arr_dev_factory[$v['factory_id']];
//            }
//
//        }

        return json_encode(['total'=>$total,'datas'=>$datas]);
    }
    //分页
    public function actionGetPage(){
        //搜索条件
        $category_one=$this->getParam('category_one');//一级分类
        $category_two=$this->getParam('category_two');//二级分类
        $BrandName=$this->getParam('BrandName');//品牌
        $goods_name=$this->getParam('goods_name');//商品
        $level=$this->getParam('level');//角色 4运营中心、5服务中心
        $search=$this->getParam('search');//搜索内容
        //分页
        $offset=$this->getParam('offset');
        $limit=$this->getParam('limit');
        if(!$offset){
            $offset=0;
        }
        if(!$limit){
            $limit=10;
        }

        $datas=$this->GetDatas($category_one,$category_two,$BrandName,$goods_name,$level,$search,$offset,$limit);
//        var_dump($datas);exit;
        return $datas;
    }


    //添加库存
    public function actionAddStock(){
        $urlobj = $this->getParam("Url");//返回参数记录
        $level=$this->getParam('level');//代理商类型（4运营中心，5服务中心）
        $agent_id=$this->getParam('agent_id');//代理商id
        $goods_name=$this->getParam('goods_name');//商品名称
        $brand_id=$this->getParam('brand_id');//品牌id
        $category_id=$this->getParam('category_id');//一级分类id
        $category2_id=$this->getParam('category2_id');//二级分类id
        $volume=$this->getParam('volume');//容量
        $factory_id=$this->getParam('factory_id');//厂家
        if(!$agent_id||!$level){
            \Yii::$app->getSession()->setFlash('error','参数错误');
            return $this->redirect(['index']);
        }
        //下拉框条件
        //一级分类
        $category_one=ActiveRecord::findBySql('select Id,Name from goods_category where Level=1 and ParentId=0')->asArray()->all();
        //二级分类
        $category_two=ActiveRecord::findBySql('select Id,Name,ParentId from goods_category where Level=2 and ParentId>0')->asArray()->all();

        //商品一级分类、二级分类、品牌、型号
        $goods_brand=ActiveRecord::findBySql('
        select goods.category_id,goods.category2_id,goods.brand_id,
        brands.BrandName,goods.id as goods_id,goods.name as goods_name,
        goods.volume
        from goods
        left join brands on brands.BrandNo=goods.brand_id'
        )->asArray()->all();

        //下拉框数据
        $select_datas=json_encode([
            'category_one'=>$category_one,
            'category_two'=>$category_two,
            'goods_brand'=>$goods_brand,
        ]);
        //默认数据
        $checkde_datas=json_encode([
            'level'=>$level,
            'agent_id'=>$agent_id,
            'goods_name'=>$goods_name,
            'brand_id'=>$brand_id,
            'category_id'=>$category_id,
            'category2_id'=>$category2_id,
            'volume'=>$volume,
            'factory_id'=>$factory_id,
        ]);

        return $this->renderPartial('add-stock',[
            'checkde_datas'=>$checkde_datas,
            'select_datas'=>$select_datas,
            'url'=>$urlobj,
        ]);

    }

    //根据商品名称获取商品容量
    public function actionGetVolumeByGoodsName(){
        $brand_id=$this->getParam('brand_id');//品牌id
        $category_id=$this->getParam('category_id');//一级分类id
        $category2_id=$this->getParam('category2_id');//二级分类id
        $goods_name=$this->getParam('goods_name');//商品名称
        if(!$brand_id||!$category_id||!$category2_id||!$goods_name){
            return json_encode(['state'=>-1,'msg'=>'参数错误']);
        }
        $volumes=ActiveRecord::findBySql("select volume,unit from goods
        where name='$goods_name' and category_id=$category_id
        and category2_id=$category2_id and brand_id='$brand_id'")->asArray()->all();
        return json_encode(['state'=>0,'volumes'=>$volumes]);
    }

    //ajax 获取厂家
    public function actionGetFactory(){
        $agent_id=$this->getParam('agent_id');//代理商id
        $level=$this->getParam('level');//代理商类型（4运营中心，5服务中心）
        $goods_name=$this->getParam('goods_name');//商品名称
        $brand_id=$this->getParam('brand_id');//品牌id
        $category_id=$this->getParam('category_id');//一级分类id
        $category2_id=$this->getParam('category2_id');//二级分类id
        $volume=$this->getParam('volume');//容量

        if(($level!=4&&$level!=5)||!$goods_name||!$brand_id||!$category_id
            ||!$category2_id||!$volume||!is_numeric($volume)||!$agent_id){
            return json_encode(['state'=>-1,'msg'=>'参数错误']);
        }
        $goods_id=$this->GetGoodsId($category_id,$category2_id,$brand_id,$goods_name,$volume);
        if(!$goods_id){
            return json_encode(['state'=>-1,'msg'=>'没有找到商品']);
        }
        if($level==4){//运营中心
            //所有 有充值的厂家
            $factory=ActiveRecord::findBySql("
            SELECT DISTINCT factory_info.Id,factory_info.`Name` from (select Fid,GoodsId from factory_wcode UNION select Fid,GoodsId from dev_factory_wcode)as factory_wcode
            INNER JOIN (select Id,`Name` from factory_info UNION select Id,`Name` from dev_factory)as factory_info
            on factory_info.Id=factory_wcode.Fid
            where factory_wcode.GoodsId= $goods_id
            ")->asArray()->all();
            return json_encode(['state'=>0,'factory'=>$factory]);
        }
        if($level==5){//服务中心
            $agentY_id=$this->GetAgentId($agent_id);
            //上级 运营中心 添加该商品的 厂家
            $factory=ActiveRecord::findBySql("
            select DISTINCT factory_info.Id,factory_info.`Name` from agent_stock
            INNER JOIN (select Id,`Name` from factory_info UNION select Id,`Name` from dev_factory)as factory_info
            on factory_info.Id=agent_stock.factory_id
            where agent_stock.agent_id=$agentY_id and agent_stock.goods_id=$goods_id
            ")->asArray()->all();
            return json_encode(['state'=>0,'factory'=>$factory]);

        }
    }

    //获取已有库存、上级库存
    public function actionGetStock(){
        $factory_id=$this->getParam('factory_id');//厂家id
        $agent_id=$this->getParam('agent_id');//代理商id
        $level=$this->getParam('level');//角色4运营中心、5服务中心
        $goods_name=$this->getParam('goods_name');//商品名称
        $brand_id=$this->getParam('brand_id');//品牌id
        $category_id=$this->getParam('category_id');//一级分类id
        $category2_id=$this->getParam('category2_id');//二级分类id
        $volume=$this->getParam('volume');//容量
        if(!$agent_id||!$level||!$goods_name||!$brand_id||!$category_id
            ||!$category2_id||!$volume||!is_numeric($volume)||!$factory_id){
            return json_encode(['state'=>-1,'msg'=>'参数错误']);
        }
        $goods_id=$this->GetGoodsId($category_id,$category2_id,$brand_id,$goods_name,$volume);
        $stock=0;//已有库存
        $data=ActiveRecord::findBySql("select stock from agent_stock
        where agent_id=$agent_id and goods_id=$goods_id and factory_id=$factory_id
        ")->asArray()->one();
        if($data){
            $stock=$data['stock'];
        }
        //上级库存
        $stock2=100000;//运营中心上级库存默认100000
        if($level==5){//服务中心上级运营中心的库存
            $agentY_id=$this->GetAgentId($agent_id);//运营中心id
            $data2=ActiveRecord::findBySql("select stock from agent_stock
        where agent_id=$agentY_id and goods_id=$goods_id and factory_id=$factory_id
        ")->asArray()->one();
            if($data2){
                $stock2=$data2['stock'];
            }else{
                $stock2=0;
            }

        }
        return json_encode(['state'=>0,'stock'=>$stock,'stock2'=>$stock2]);

    }

    //根据商品信息获取商品id
    public function GetGoodsId($category_id,$category2_id,$brand_id,$goods_name,$volume){
        $data=ActiveRecord::findBySql("select id from goods
        where category_id=$category_id and category2_id=$category2_id
        and brand_id='$brand_id' and name='$goods_name' and volume=$volume")->asArray()->one();
        if($data){
           return $data['id'];
        }
        return 0;
    }

    //判断服务中心添加的库存是否大于上级运营中心的库存
    public function actionCheckStock(){
        $factory_id=$this->getParam('factory_id');//厂家id
        $agent_id=$this->getParam('agent_id');//代理商id
        $goods_name=$this->getParam('goods_name');//商品名称
        $brand_id=$this->getParam('brand_id');//品牌id
        $category_id=$this->getParam('category_id');//一级分类id
        $category2_id=$this->getParam('category2_id');//二级分类id
        $add_stock=$this->getParam('add_stock');//增加的库存数量
        $volume=$this->getParam('volume');//容量
        if(!$agent_id||!$goods_name||!$brand_id||!$category_id||!$category2_id
            ||!is_numeric($add_stock)||!$volume||!is_numeric($volume)||!$factory_id){
            return ['state'=>-1,'msg'=>'参数错误'];
        }
        $goods_id=$this->GetGoodsId($category_id,$category2_id,$brand_id,$goods_name,$volume);
        $result=$this->CheckStock($agent_id,$goods_id,$add_stock,$factory_id);
        if($result){
            return ['state'=>0];
        }
        return ['state'=>-1,'msg'=>'库存不足'];
    }

    //判断服务中心上级运营中心的库存是否充足
    public function CheckStock($agent_id,$goods_id,$add_stock,$factory_id){
        $agentY_id=0;//服务中心的所属运营中心id
        $stock=0;
        if($agent_id){
            $agentY_id=$this->GetAgentId($agent_id);
        }
        $data=ActiveRecord::findBySql("select id,stock from agent_stock
        where agent_id=$agentY_id and goods_id=$goods_id
        and factory_id=$factory_id")->asArray()->one();
        if($data){
            $stock= $data['stock'];
        }
        if($stock<$add_stock){
            return false;
        }

//        return true;
        return $data['id'];
    }


    //获取服务中心的所属运营中心id
    public function GetAgentId($agent_id){
        $agentY_id=0;//服务中心的所属运营中心id
        $data=ActiveRecord::findBySql("select Id,ParentId,Level from agent_info where Id=$agent_id")->asArray()->one();
        if(!$data) return 0;
        $data=ActiveRecord::findBySql("select Id,ParentId,Level from agent_info where Id={$data['ParentId']}")->asArray()->one();

        if(!$data) return 0;
        if($data['Level']==4){//服务中心直接挂在运营中心下的
            $agentY_id=$data['Id'];
        }

        if($data['Level']==7){//服务中心挂在片区中心下的
            $data=ActiveRecord::findBySql("select Id,ParentId,Level from agent_info where Id={$data['ParentId']}")->asArray()->one();
            if(!$data) return 0;
            if($data['Level']==4){//片区中心挂在运营中心下的
                $agentY_id=$data['Id'];
            }
        }
        return $agentY_id;
    }

    //验证添加的是否是同样商品，不同厂家
    public function CheckSameGoods($agent_id,$goods_id,$factory_id){
        //同一个商品、同一个厂家
        $data=ActiveRecord::findBySql("
        select id from agent_stock where agent_id=$agent_id
        and goods_id=$goods_id and factory_id=$factory_id")->asArray()->one();
        //同一个商品
        $data2=ActiveRecord::findBySql("
        select id from agent_stock where agent_id=$agent_id
        and goods_id=$goods_id")->asArray()->all();
        if(!$data&&!$data2){//都没有，说明：没有添加过商品
            return true;
        }elseif(!$data&&$data2){//添加过，再添加时选择的厂家和之前不一致
            return false;
        }elseif($data&&$data2&&count($data2)==1&&$data['id']==$data2[0]['id']){
        //添加过，再添加时选择的厂家和之前一致
            return true;
        }else{
            return false;
        }


    }

    //保存添加的库存
    public function actionSaveStock(){
        $factory_id=$this->getParam('factory_id');//厂家id
        $level=$this->getParam('level');//代理商类型（4运营中心，5服务中心）
        $agent_id=$this->getParam('agent_id');//代理商id
        $goods_name=$this->getParam('goods_name');//商品名称
        $brand_id=$this->getParam('brand_id');//品牌id
        $category_id=$this->getParam('category_id');//一级分类id
        $category2_id=$this->getParam('category2_id');//二级分类id
        $volume=$this->getParam('volume');//商品容量
        $add_stock=$this->getParam('add_stock');//增加的库存数量
        if(!$volume||!$level||!$agent_id||!$goods_name||!$brand_id||!$category_id||!$category2_id||!$add_stock||!is_numeric($add_stock)){
            return ['state'=>-1,'msg'=>'参数错误'];
        }
        $goods_id=$this->GetGoodsId($category_id,$category2_id,$brand_id,$goods_name,$volume);
        //验证是否添加同样商品，选择的不同厂家
        $result=$this->CheckSameGoods($agent_id,$goods_id,$factory_id);
        if(!$result){
            return ['state'=>-1,'msg'=>'同一商品只能选择同一厂家'];
        }


        $id=0;//运营中心该商品库存的id
        if($level==5){
            //检查上级运营中心库存是否充值
            $result=$this->CheckStock($agent_id,$goods_id,$add_stock,$factory_id);
            if(!$result){
                return ['state'=>-1,'msg'=>'所属运营中心库存不足'];
            }
            //获取上级运营中心该商品库存的id
            $id=$result;
        }

        $transaction =\Yii::$app->db->beginTransaction();
        try{

            $now=date('Y-m-d H:i:s');
            //保存出库、入库记录
            if($level==5){//服务中心增加库存
                $action_type=1;//1 入库，2 出库
                $remark=1;//1 进货，2 送货，3 退货，4 登记，5 初始化
                //库存记录
                $re=$this->GetTotalAndRestStock($agent_id,$goods_id,$factory_id);
                //累计入库数量
                if($add_stock < 0){//添加的是负数
                    $total=$re['total'];
                    $action_type=2;
                    $remark=3;
                }else{
                    $total=$re['total']+$add_stock;
                }

                //剩余库存总数
                $rest_stock=$re['rest_stock']+$add_stock;
                //运营中心出库记录
                $agentY_id=$this->GetAgentId($agent_id);//上级运营中心的id
                //服务中心入库记录
                $res=\Yii::$app->db->createCommand(" insert into agent_stock_log
                (agent_id,factory_id,goods_id,action_type,num,rest_stock,total,remark,row_time,`from`,`to`)
                values($agent_id,$factory_id,$goods_id,$action_type,".abs($add_stock).",$rest_stock,$total,$remark,'$now',$agent_id,$agentY_id)")->execute();
                if(!$res){
                    throw new \yii\db\Exception('添加服务中心入库记录失败');
                }


                $action_type=2;//1 入库，2 出库
                $remark=2;//1 进货，2 送货，3 退货，4 登记，5 初始化
                if($add_stock < 0){
                    $action_type=1;
                    $remark=3;
                }
                $re=$this->GetTotalAndRestStock($agentY_id,$goods_id,$factory_id);
                //累计入库数量
                $total=$re['total'];
                //剩余库存总数
                $rest_stock=$re['rest_stock']-$add_stock;

                $res=\Yii::$app->db->createCommand(" insert into agent_stock_log
                (agent_id,factory_id,goods_id,action_type,num,rest_stock,total,remark,row_time,`from`,`to`)
                values($agentY_id,$factory_id,$goods_id,$action_type,".abs($add_stock).",$rest_stock,$total,$remark,'$now',$agent_id,$agentY_id)")->execute();
                if(!$res){
                    throw new \yii\db\Exception('添加运营中心出库记录失败');
                }

                //上级运营中心减去对应的数量
                $res=\Yii::$app->db->createCommand(" update agent_stock set stock=stock-$add_stock,update_time='$now' where id=$id ")->execute();
                if(!$res){
                    throw new \yii\db\Exception('修改运营中心库存失败');
                }
            }


            if($level==4){//运营中心
                //保存入库记录
                $re=$this->GetTotalAndRestStock($agent_id,$goods_id,$factory_id);
                //累计入库数量
                $action_type=1;//1 入库，2 出库
                $remark=1;//1 进货，2 送货，3 退货，4 登记，5 初始化
                if($add_stock < 0){
                    $total=$re['total'];
                    $action_type=2;
                    $remark=3;
                }else{
                    $total=$re['total']+$add_stock;
                }

                //剩余库存总数
                $rest_stock=$re['rest_stock']+$add_stock;
                $res=\Yii::$app->db->createCommand(" insert into agent_stock_log
                (agent_id,factory_id,goods_id,action_type,num,rest_stock,total,remark,row_time)
                values($agent_id,$factory_id,$goods_id,$action_type,$add_stock,$rest_stock,$total,$remark,'$now')")->execute();
                if(!$res){
                    throw new \yii\db\Exception('添加运营中心入库记录失败');
                }
            }
            //增加库存-------------
            //判断是否添加过该商品的库存
            $data=ActiveRecord::findBySql(" select id from agent_stock
            where agent_id=$agent_id and goods_id=$goods_id
            and factory_id=$factory_id")->asArray()->one();

            if($data){
                //添加过直接修改库存
                $res=\Yii::$app->db->createCommand(" update agent_stock set stock=stock+$add_stock,update_time='$now' where id={$data['id']} ")->execute();
                if(!$res){
                    throw new \yii\db\Exception('修改库存失败');
                }
            }else{
                //之前没有添加过，新增
                $res=\Yii::$app->db->createCommand(" insert into agent_stock
            (agent_id,goods_id,stock,row_time,factory_id)
            values($agent_id,$goods_id,$add_stock,'$now',$factory_id)")->execute();
                if(!$res){
                    throw new \yii\db\Exception('增加库存失败');
                }
            }
            //---------------------------



            $transaction->commit();
            return ['state'=>0];
        }catch (Exception $e){
            $transaction->rollBack();
            return ['state'=>-1,'msg'=>$e->getMessage()];
        }

    }

    //出、入库时获取累计入库总数量、剩余库存数量
    public function GetTotalAndRestStock($agent_id,$goods_id,$factory_id){
        //总入库数量
        $total=0;
        $data=ActiveRecord::findBySql("select MAX(total)as total from agent_stock_log
            where agent_id=$agent_id and goods_id=$goods_id and factory_id=$factory_id")->asArray()->one();
        if($data&&$data['total'])$total=$data['total'];
        //剩余库存总数
        $rest_stock=0;
        $data2=ActiveRecord::findBySql("select stock from agent_stock
            where agent_id=$agent_id and goods_id=$goods_id and factory_id=$factory_id")->asArray()->one();
        if($data2&&$data2['stock'])$rest_stock=$data2['stock'];

        return ['total'=>$total,'rest_stock'=>$rest_stock];
    }

    //库存记录列表
    public function actionStockLogList(){
        $urlobj = $this->getParam("Url");//返回参数记录
        $agent_id=$this->getParam('agent_id');//代理商id
        $factory_id=$this->getParam('factory_id');//厂家id
        $goods_id=$this->getParam('goods_id');//商品id
        $brand_id=$this->getParam('brand_id');//品牌id
        $volume=$this->getParam('volume');//商品容量
        if(!$agent_id||!$factory_id||!$goods_id||!$brand_id||!$volume||!is_numeric($volume)){
            \Yii::$app->getSession()->setFlash('error','参数错误');
            return $this->redirect(['index']);
        }
        $where=" and agent_stock_log.agent_id=$agent_id
         and agent_stock_log.factory_id=$factory_id
         and agent_stock_log.goods_id=$goods_id
         and brands.BrandNo='$brand_id'
         and goods.volume=$volume";
        //搜索条件
        $search=$this->getParam('search');//搜索内容
        $action_type=$this->getParam('action_type');//操作类型（1 入库，2 出库）
        $start_time=$this->getParam('start_time');
        $end_time=$this->getParam('end_time');
        $remark=$this->getParam('remark');//备注：1 进货，2 送水，3 退货，4 登记，5 初始化
        //排序字段（数量num、剩余数量rest_stock、累计总数total、时间row_time）
        $sort_column=$this->getParam('sort_column');
        $sort=$this->getParam('sort');//排序（奇数降序，偶数升序）
        if(!$sort_column||!$sort){
            $sort_column='row_time';
            $sort=1;
        }
        $order='';
        if($sort&&$sort_column&&in_array($sort_column,['num','rest_stock','total','row_time'])){
            if($sort%2==1){
                $order=" order by $sort_column desc ";
            }else{
                $order=" order by $sort_column asc ";
            }

        }

        //分页
        $offset=$this->getParam('offset');
        $limit=$this->getParam('limit');
        if(!$offset){
            $offset=0;
        }
        if(!$limit){
            $limit=10;
        }


        //条件数据
        $where_datas=[
            'agent_id'=>$agent_id,
            'factory_id'=>$factory_id,
            'goods_id'=>$goods_id,
            'brand_id'=>$brand_id,
            'volume'=>$volume,
            'search'=>$search,
            'action_type'=>$action_type,
            'start_time'=>$start_time,
            'end_time'=>$end_time,
            'remark'=>$remark,
            'sort_column'=>$sort_column,
            'sort'=>$sort,
            'offset'=>$offset,
            'limit'=>$limit,
        ];

        //表格数据
        $datas=$this->StockLogDatas($where,$search,$action_type,$start_time,$end_time,$remark,$offset,$limit,$order);
        $total=$datas->count();
        $form_datas=ActiveRecord::findBySql($datas->sql." $order limit $offset,$limit")->asArray()->all();

        return $this->renderPartial('stock-log-list',[
            'where_datas'=>json_encode($where_datas),
            'form_datas'=>json_encode($form_datas),
            'total'=>$total,
            'url'=>$urlobj,
        ]);


    }

    //库存记录表格数据
    public function StockLogDatas($where,$search,$action_type,$start_time,$end_time,$remark,$offset,$limit,$order){
        if($search){
            $where.=" and agent_stock_log.bar_code like '%$search%' ";
        }
        if($action_type){
            $where.=" and agent_stock_log.action_type = $action_type ";
        }
        if($start_time&&$end_time){
            $EndTime=$end_time.' 23:59:59';
            $where.=" and agent_stock_log.row_time >= '$start_time' and agent_stock_log.row_time <= '$EndTime' ";
        }
        if($remark){
            $where.=" and agent_stock_log.remark = '$remark' ";
        }

        $datas=ActiveRecord::findBySql("
        select distinct * from (
            select distinct agent_info.Name,agent_info.ContractTel,agent_stock_log.bar_code,
            factory_info.Name as FactoryName,brands.BrandName,goods.name as GoodsName,
            goods.volume,agent_stock_log.action_type,agent_stock_log.num,agent_info.Level,
            agent_stock_log.rest_stock,agent_stock_log.total,agent_stock_log.remark,
            agent_stock_log.row_time,agent1.Name as FromName,agent2.Name as ToName
            from agent_stock_log
            left join agent_info on agent_info.Id=agent_stock_log.agent_id
            left join agent_info as agent1 on agent1.Id=agent_stock_log.from
            left join agent_info as agent2 on agent2.Id=agent_stock_log.to
            left join (select Id,`Name` from factory_info UNION select Id,`Name` from dev_factory) as factory_info
            on factory_info.Id=agent_stock_log.factory_id
            left join goods on goods.id=agent_stock_log.goods_id
            left join brands on brands.BrandNo=goods.brand_id
            where 1=1 $where
        )as temp");

        return $datas;
    }

    //ajax库存记录分页
    public function actionStockLogPage(){
        $agent_id=$this->getParam('agent_id');//代理商id
        $factory_id=$this->getParam('factory_id');//厂家id
        $goods_id=$this->getParam('goods_id');//商品id
        $brand_id=$this->getParam('brand_id');//品牌id
        $volume=$this->getParam('volume');//商品容量
        if(!$agent_id||!$factory_id||!$goods_id||!$brand_id){
            return json_encode(['state'=>-1,'msg'=>'参数错误']);
        }
        $where=" and agent_stock_log.agent_id=$agent_id
         and agent_stock_log.factory_id=$factory_id
         and agent_stock_log.goods_id=$goods_id
         and brands.BrandNo='$brand_id'
         and goods.volume=$volume";
        //搜索条件
        $search=$this->getParam('search');//搜索内容
        $action_type=$this->getParam('action_type');//操作类型（1 入库，2 出库）
        $start_time=$this->getParam('start_time');
        $end_time=$this->getParam('end_time');
        $remark=$this->getParam('remark');//备注：1 进货，2 送水，3 退货，4 登记，5 初始化
        //排序字段（数量num、剩余数量rest_stock、累计总数total、时间row_time）
        $sort_column=$this->getParam('sort_column');
        $sort=$this->getParam('sort');//排序（奇数降序，偶数升序）
        if(!$sort_column||!$sort){
            $sort_column='row_time';
            $sort=1;
        }
        $order='';
        if($sort&&$sort_column&&in_array($sort_column,['num','rest_stock','total','row_time'])){
            if($sort%2==1){
                $order=" order by $sort_column desc ";
            }else{
                $order=" order by $sort_column asc ";
            }

        }
        //分页
        $offset=$this->getParam('offset');
        $limit=$this->getParam('limit');
        if(!$offset){
            $offset=0;
        }
        if(!$limit){
            $limit=10;
        }
        //表格数据
        $datas=$this->StockLogDatas($where,$search,$action_type,$start_time,$end_time,$remark,$offset,$limit,$order);
        $total=$datas->count();
        $form_datas=ActiveRecord::findBySql($datas->sql." $order limit $offset,$limit")->asArray()->all();
        return json_encode(['total'=>$total,'form_datas'=>$form_datas]);

    }


}
