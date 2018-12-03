<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/5/21
 * Time: 下午5:40
 */

namespace app\api;
use Yii;

class AgentApi extends BaseApi
{

    public function getUserInfoByOpenId($openid = null){
        if(empty($openid)){
            return;
        }
        $data["openid"]=$openid;
        return $this->ajaxPost('/agent/GetByOpenId',$data);
    }

    public function getUserStat(){
        return $this->ajaxAgentPost('/agent/GetUserStat',[]);
    }

    public function getTotalStat(){
        return $this->ajaxAgentPost('/agent/GetTotalStat',[]);
    }
    public function getWarning(){
        $data["take"]=500;
        $data["skip"]=0;
        return $this->ajaxAgentPost('/agent/GetWarning',$data);
    }

    public function getDayStat(){
        return $this->ajaxAgentPost('/agent/GetDayStat',[]);
    }
    public function getAgents(){
        return $this->ajaxAgentPost('/Agent/GetAgents',[]);
    }
    public function getUsers(){
        $data["take"]=500;
        $data["skip"]=0;
        return $this->ajaxAgentPost('/Agent/GetUsers',$data);
    }
    public function getInvestor(){//投资设备详情
        $data["take"]=500;
        $data["skip"]=0;
        return $this->ajaxAgentPost('/Agent/investors',$data);
    }
    public function getdevwarning(){//设备预警
        $data["take"]=500;
        $data["skip"]=0;
        return $this->ajaxAgentPost('/agent/GetWarning',$data);
    }
    public function getdevlist(){//设备列表
        $data["take"]=500;
        $data["skip"]=0;
        return $this->ajaxAgentPost('/agent/devices',$data);
    }
}