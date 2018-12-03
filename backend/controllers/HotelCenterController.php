<?php
namespace backend\controllers;

//酒店中心
use yii\db\ActiveRecord;
use backend\models\Address;

class HotelCenterController extends BaseController{
    public function actionIndex(){

        //分页
        $offset=$this->getParam('offset');
        $limit=$this->getParam('limit');
        if($offset==''&&$limit==''){
            $offset=0;
            $limit=10;
        }

        $search=$this->getParam('search');
        $tel=$this->getParam('login_name');//后面改成了手机号
        $province=$this->getParam('province');
        $city=$this->getParam('city');
        $area=$this->getParam('area');
        $where='';
        if($search){
            $where=" (agent_info.ContractUser like '%$search%'
                      or agent_info.Name like '%$search%'
                      or agent.Name like '%$search%'
                      or agent2.Name like '%$search%'
                        )";
        }

        if($tel){
            if($where){
                $where.='and';
            }
            $where.=" agent_info.ContractTel = $tel ";
        }
        if($province){
            if($where){
                $where.='and';
            }
            $where.=" agent_info.Province = '$province' ";
        }
        if($city){
            if($where){
                $where.='and';
            }
            $where.=" agent_info.City = '$city' ";
        }
        if($area){
            if($where){
                $where.='and';
            }
            $where.=" agent_info.Area = '$area' ";
        }
        //地址
        $address=(new Address())->allQuery()->asArray()->all();

        $datas=ActiveRecord::findBySql('select agent_info.Id,agent_info.LoginName,agent_info.Name,
 agent_info.Province,agent_info.City,agent_info.Area,agent_info.Address,agent_info.ContractUser,
 agent_info.ContractTel,agent_info.RowTime
 from agent_info
 where agent_info.`Level`=8'.(empty($where)?'':' and '.$where));
        $total=$datas->count();
        $data=ActiveRecord::findBySql($datas->sql." order by agent_info.RowTime desc limit $offset,$limit ")->asArray()->all();
        //上级
        foreach($data as &$v){
            $parent=$this->GetParentByAgentF($v['Id']);
            $v['PqName']=$parent['agentPname'];
            $v['YyName']=$parent['agentYname'];
        }
        //已选条件
        $search_where=json_encode(['offset'=>$offset,
                                    'limit'=>$limit,
                                    'search'=>$search,
                                    'login_name'=>$tel,
                                    'province'=>$province,
                                    'city'=>$city,
                                    'area'=>$area,
                                    ]);

        return $this->renderPartial('index',['total'=>$total,
                                    'data'=>json_encode($data),
                                    'search_where'=>$search_where,
                                    'address'=>$address,
                                    ]);
//        var_dump($total,$data);
    }

    //酒店中心分页接口
    public function actionPage(){
        //分页
        $offset=$this->getParam('offset');
        $limit=$this->getParam('limit');
        if($offset==''&&$limit==''){
            $offset=0;
            $limit=10;
        }

        $search=$this->getParam('search');
        $tel=$this->getParam('login_name');//后面改成了手机号
        $province=$this->getParam('province');
        $city=$this->getParam('city');
        $area=$this->getParam('area');
        $where='';
        if($search){
            $where=" (agent_info.ContractUser like '%$search%'
                      or agent_info.ContractTel like '%$search%'
                      or agent_info.Name like '%$search%'
                      or agent.Name like '%$search%'
                      or agent2.Name like '%$search%'
                        )";
        }

        if($tel){
            if($where){
                $where.='and';
            }
            $where.=" agent_info.ContractTel = $tel ";
        }
        if($province){
            if($where){
                $where.='and';
            }
            $where.=" agent_info.Province = '$province' ";
        }
        if($city){
            if($where){
                $where.='and';
            }
            $where.=" agent_info.City = '$city' ";
        }
        if($area){
            if($where){
                $where.='and';
            }
            $where.=" agent_info.Area = '$area' ";
        }

        $datas=ActiveRecord::findBySql('select agent_info.Id,agent_info.LoginName,agent_info.Name,
 agent_info.Province,agent_info.City,agent_info.Area,agent_info.Address,agent_info.ContractUser,
 agent_info.ContractTel,agent_info.RowTime
 from agent_info
 where agent_info.`Level`=8 '.(empty($where)?'':' and '.$where));
        $total=$datas->count();
        $data=ActiveRecord::findBySql($datas->sql." order by agent_info.RowTime desc limit $offset,$limit")->asArray()->all();
        //上级
        foreach($data as &$v){
            $parent=$this->GetParentByAgentF($v['Id']);
            $v['PqName']=$parent['agentPname'];
            $v['YyName']=$parent['agentYname'];
        }
        return json_encode(['total'=>$total,'data'=>$data]);
    }
}
