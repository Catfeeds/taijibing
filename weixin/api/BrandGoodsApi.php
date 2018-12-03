<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/5/21
 * Time: 下午5:40
 */

namespace app\api;
use Yii;

class BrandGoodsApi extends BaseApi
{
    public function getbrandgoods(){
        return $this->ajaxAgentPost('/Agent/saleinfos',[]);
    }

}
