<?php
namespace backend\controllers;
//商品分类
use yii\db\ActiveRecord;

class GoodsTypeController extends BaseController{

    //商品分类列表页
    public function actionIndex(){
        $parent_id=$this->getParam('parent_id');//一级分类id
        $id=$this->getParam('id');//二级分类id
        $sort=$this->getParam('sort');//添加时间排序
        $offset=$this->getParam('offset');
        $limit=$this->getParam('limit');
        if($sort){
            $sort=0;
        }
        if($offset==''||$limit==''){
            $offset=0;
            $limit=10;
        }
        $where='';
        $order=' order by RowTime desc ';
        if($parent_id && $id){//选了一级和二级分类
            $where=" type1_id = $parent_id and type2_id = $id ";
        }
        if($parent_id && !$id){//没有二级分类
            $where=" type1_id = $parent_id ";
        }
        if(!$parent_id && $id){//只选了二级分类
            $where=" type2_id = $id ";
        }
        //排序
        if($sort && $sort%2==1){
            $order=' order by RowTime asc ';
        }

        $datas=ActiveRecord::findBySql("select * from (select temp.Id as type1_id,temp.Name as ParentName,
goods_category.Id as type2_id,goods_category.Name, goods_category.RowTime,temp.UpdateTime
from goods_category
left join goods_category as temp on temp.Id=goods_category.ParentId
where goods_category.`Level`=2
UNION
select goods_category.Id as type1_id,goods_category.Name as ParentName,
temp.Id as type2_id,temp.Name, goods_category.RowTime,temp.UpdateTime
from goods_category
left join goods_category as temp on temp.Id=goods_category.ParentId
where goods_category.`Level`=1)as temp
".(empty($where)?'':' where '.$where)." $order limit $offset,$limit ")->asArray()->all();
        //一级分类
        $type1=ActiveRecord::findBySql("select Id,`Name` from goods_category where `Level`=1")->asArray()->all();
        //二级分类
        $type2=ActiveRecord::findBySql("select Id,`Name`,ParentId from goods_category where `Level`=2")->asArray()->all();

//var_dump($datas);exit;
        return $this->render('index',['datas'=>$datas,'type1'=>$type1,'type2'=>$type2,'sort'=>$sort,'parent_id'=>$parent_id,'id'=>$id]);
    }

    //分页
    public function actionGetPage(){
        $parent_id=$this->getParam('parent_id');//一级分类id
        $id=$this->getParam('id');//二级分类id
        $sort=$this->getParam('sort');//添加时间排序
        $offset=$this->getParam('offset');
        $limit=$this->getParam('limit');
        if($sort){
            $sort=0;
        }
        if($offset==''||$limit==''){
            $offset=0;
            $limit=10;
        }
        $where='';
        $order=' order by RowTime desc ';
        if($parent_id && $id){//选了一级和二级分类
            $where=" type1_id = $parent_id and type2_id = $id ";
        }
        if($parent_id && !$id){//没有二级分类
            $where=" type1_id = $parent_id ";
        }
        if(!$parent_id && $id){//只选了二级分类
            $where=" type2_id = $id ";
        }
        //排序
        if($sort && $sort%2==1){
            $order=' order by RowTime asc ';
        }

        $data=ActiveRecord::findBySql("select * from (select temp.Id as type1_id,temp.Name as ParentName,
goods_category.Id as type2_id,goods_category.Name, goods_category.RowTime,temp.UpdateTime
from goods_category
left join goods_category as temp on temp.Id=goods_category.ParentId
where goods_category.`Level`=2
UNION
select goods_category.Id as type1_id,goods_category.Name as ParentName,
temp.Id as type2_id,temp.Name, goods_category.RowTime,temp.UpdateTime
from goods_category
left join goods_category as temp on temp.Id=goods_category.ParentId
where goods_category.`Level`=1)as temp
".(empty($where)?'':' where '.$where)." $order ");
        $total=$data->count();
        $datas=ActiveRecord::findBySql($data->sql."limit $offset,$limit")->asArray()->all();
//var_dump($datas);exit;
        return json_encode(['datas'=>$datas,'total'=>$total]);

    }

    //创建商品分类
    public function actionAddGoodsType(){
        $urlobj = $this->getParam("Url");//返回参数记录
        //上级分类
        $parent=ActiveRecord::findBySql("select Id,`Name`,`Level` from goods_category where ParentId=0")->asArray()->all();
        if(\Yii::$app->request->isPost){
            $name=addslashes($this->getParam('name'));//分类名称
            $parent_id=$this->getParam('parent_id');//上级分类id (0,顶级分类)
            //判断是否创建过该分类
            $data=ActiveRecord::findBySql("select Id from goods_category
where `Name`='$name' and ParentId=$parent_id")->asArray()->all();
            if($data){
                \Yii::$app->getSession()->setFlash('error','该分类创建过了');
                return $this->redirect(['index']);
            }

            $level=addslashes($this->getParam('level'));//上级分类级别
            if($parent_id==0){
                $level=1;
            }else{
                $level=$level+1;
            }
            if($name!=''&&$parent_id!=''&&$level!=''){
                $row_time=date('Y-m-d H:i:s',time());
                $re=\Yii::$app->db->createCommand("insert into goods_category (`Name`,`RowTime`,`ParentId`,`Level`) VALUES ('$name','$row_time',$parent_id,$level)")->execute();
                if($re){
                    \Yii::$app->getSession()->setFlash('success','成功');
                }else{
                    \Yii::$app->getSession()->setFlash('error','失败');
                }
                return $this->redirect(['index']);

            }else{
                \Yii::$app->getSession()->setFlash('error','数据不完整');
                return $this->redirect(['index']);
            }
        }
        return $this->render('add-goods-type',['parent'=>$parent,'url'=>$urlobj]);

    }

    //修改
    public function actionEdit(){
        $urlobj = $this->getParam("Url");//返回参数记录
        $type1_id=$this->getParam('type1_id');
        $type2_id=$this->getParam('type2_id');
//        var_dump($type1_id,$type2_id);exit;
        if($type1_id==''){
            \Yii::$app->getSession()->setFlash('error', "参数错误");
            return $this->redirect(["index"]);
        }
        if(\Yii::$app->request->isPost){
            $name=addslashes($this->getParam('name'));//分类名称
            $parent_id=$this->getParam('parent_id');//上级分类id (0,顶级分类)
            $level=addslashes($this->getParam('level'));//上级分类级别
            $update_time=date('Y-m-d H:i:s',time());

            if($parent_id==0){
                $level=1;
            }else{
                $level=$level+1;
            }
            if($name!=''){

                if($type1_id&&!$type2_id){//修改的是一级分类
                    $re=\Yii::$app->db->createCommand("update goods_category set `Name`='$name',`UPdateTime`='$update_time' where Id=$type1_id")->execute();
                    if($re){
                        \Yii::$app->getSession()->setFlash('success','成功');
                    }else{
                        \Yii::$app->getSession()->setFlash('error','失败');
                    }
                    return $this->redirect(['index']);
                }

                $re=\Yii::$app->db->createCommand("update goods_category set `Name`='$name',`ParentId`=$parent_id,`Level`=$level,`UPdateTime`='$update_time' where Id=$type2_id")->execute();
                if($re){
                    \Yii::$app->getSession()->setFlash('success','成功');
                }else{
                    \Yii::$app->getSession()->setFlash('error','失败');
                }
                return $this->redirect(['index']);
            }else{
                \Yii::$app->getSession()->setFlash('error','数据不完整');
                return $this->redirect(['index']);
            }
        }


        //修改前的数据
        //二级分类数据
        $datas='';
        if($type2_id){
            $datas=ActiveRecord::findBySql("select Id,ParentId,`Name`,`Level` from goods_category where Id=$type2_id")->asArray()->all();
        }
        if($type1_id&&!$type2_id){
            $datas=ActiveRecord::findBySql("select Id,ParentId,`Name`,`Level` from goods_category where Id=$type1_id")->asArray()->all();
        }

        //一级分类数据
        $types=ActiveRecord::findBySql("select Id,`Name`,`Level` from goods_category where `Level`=1")->asArray()->all();
//        var_dump($datas);exit;
        return $this->render('edit',['datas'=>$datas,'types'=>$types,'type1_id'=>$type1_id,'type2_id'=>$type2_id,'url'=>$urlobj]);

    }

    //删除
    public function actionDel(){
        $type1_id=$this->getParam('type1_id');
        $type2_id=$this->getParam('type2_id');
//        var_dump($type1_id,$type2_id);exit;
        if(!is_numeric($type1_id)&&!is_numeric($type2_id)){
            \Yii::$app->getSession()->setFlash('error','参数错误');
            return $this->redirect(['index']);
        }
        if(!is_numeric($type2_id)){//没有二级分类
            //判断该一级分类下是否有商品
            $goods=ActiveRecord::findBySql("select id from goods where category_id=$type1_id")->asArray()->all();
            if($goods){
                \Yii::$app->getSession()->setFlash('error','该分类下有商品，不能直接删除');
                return $this->redirect(['index']);
            }
            //直接删除一级分类
            $re=\Yii::$app->db->createCommand("delete from goods_category where Id=$type1_id")->execute();
        }else{
            //上传二级分类
            //判断该二级分类下是否有商品
            $goods=ActiveRecord::findBySql("select id from goods where category_id=$type1_id and category2_id=$type2_id")->asArray()->all();
            if($goods){
                \Yii::$app->getSession()->setFlash('error','该分类下有商品，不能直接删除');
                return $this->redirect(['index']);
            }
            $re=\Yii::$app->db->createCommand("delete from goods_category where Id=$type2_id")->execute();
        }

        if($re){
            \Yii::$app->getSession()->setFlash('success','成功');
            return $this->redirect(['index']);
        }else{
            \Yii::$app->getSession()->setFlash('error','删除失败');
            return $this->redirect(['index']);
        }

    }

}
