<?php
namespace backend\controllers;


//片区中心
use yii\db\ActiveRecord;
use backend\models\Address;

class AreaCenterController extends BaseController{

    public function actionIndex(){
        //分页
        $offset=$this->getParam("offset");
        $limit=$this->getParam("limit");
        if(!$offset && !$limit){
            $offset=0;
            $limit=10;
        }
        //排序
        $order=" order by RowTime desc ";//默认降序
        $sort=$this->getParam("sort");
        if(!$sort){
            $sort=0;
        }
        if($sort && $sort%2==1){//奇数，升序
            $order=" order by RowTime asc ";
        }


        //搜索条件
        $name=addslashes($this->getParam('name'));//名称
        $tel_loginname=addslashes($this->getParam('tel_loginname'));//账号或手机号
        $province=$this->getParam('province');//省
        $city=$this->getParam('city');//市
        $area=$this->getParam('area');//区
//        var_dump($province);exit;
        $where='';
        if($name){
            $where=" Name = '$name' ";
        }
        if($tel_loginname){
            if($where){
                $where.=" and ";
            }
            $where.=" (LoginName like '%$tel_loginname%' or ContractTel like '%$tel_loginname%') ";
        }
        if($province){
            if($where){
                $where.=" and ";
            }
            $where.=" Province = '$province' ";
        }
        if($city){
            if($where){
                $where.=" and ";
            }
            $where.=" City= '$city' ";
        }
        if($area){
            if($where){
                $where.=" and ";
            }
            $where.=" Area= '$area' ";
        }


        $datas=ActiveRecord::findBySql("select LoginName,`Name`,Province,City,Area,
Address,ContractUser,ContractTel,RowTime
from agent_info where `Level`=7".(empty($where)?'':' and '.$where));
        $total=$datas->count();
        $lists=ActiveRecord::findBySql($datas->sql." $order limit $offset,$limit ")->asArray()->all();

        $address = (new Address())->allQuery()->asArray()->all();
        $datas=json_encode(['total'=>$total,
                            'datas'=>$lists,
                            'address'=>$address,
                            'sort'=>$sort,
                            'where'=>[
                                'name'=>$name,
                                'tel_loginname'=>$tel_loginname,
                                'province'=>$province,
                                'city'=>$city,
                                'area'=>$area,
                            ]
                            ]);
        return $this->render('index',['datas'=>$datas]);
//        var_dump($total,$lists);
    }

    //分页
    public function actionGetPage(){
        //分页
        $offset=$this->getParam("offset");
        $limit=$this->getParam("limit");
        if(!$offset && !$limit){
            $offset=0;
            $limit=10;
        }
        //排序
        $order=" order by RowTime desc ";//默认降序
        $sort=$this->getParam("sort");
        if(!$sort){
            $sort=0;
        }
        if($sort && $sort%2==1){//奇数，升序
            $order=" order by RowTime asc ";
        }


        //搜索条件
        $name=addslashes($this->getParam('name'));//名称
        $tel_loginname=addslashes($this->getParam('tel_loginname'));//账号或手机号
        $province=$this->getParam('province');//省
        $city=$this->getParam('city');//市
        $area=$this->getParam('area');//区
//        var_dump($province);exit;
        $where='';
        if($name){
            $where=" Name = '$name' ";
        }
        if($tel_loginname){
            if($where){
                $where.=" and ";
            }
            $where.=" (LoginName like '%$tel_loginname%' or ContractTel like '%$tel_loginname%') ";
        }
        if($province){
            if($where){
                $where.=" and ";
            }
            $where.=" Province = '$province' ";
        }
        if($city){
            if($where){
                $where.=" and ";
            }
            $where.=" City= '$city' ";
        }
        if($area){
            if($where){
                $where.=" and ";
            }
            $where.=" Area= '$area' ";
        }


        $datas=ActiveRecord::findBySql("select LoginName,`Name`,Province,City,Area,
Address,ContractUser,ContractTel,RowTime
from agent_info where `Level`=7".(empty($where)?'':' and '.$where));
        $total=$datas->count();
        $lists=ActiveRecord::findBySql($datas->sql." $order limit $offset,$limit ")->asArray()->all();

        return json_encode(['total'=>$total,'datas'=>$lists,'sort'=>$sort]);
    }

}
