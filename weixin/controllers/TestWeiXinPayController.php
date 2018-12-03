<?php
namespace app\controllers;

use yii\db\ActiveRecord;

header('Access-Control-Allow-Origin:http://manage.taijibing.cn');   // 指定允许其他域名访问（后台退款）

class WeiXinPayController extends WxController{
    public   $mchid = '1504203251';          //微信支付商户号 PartnerID 通过微信支付商户资料审核后邮件发送
    public   $Appid = 'wx3fd68d66f47f0b32';  //微信支付申请对应的公众号的APPID
    public   $apiKey = '28D2D76EE58ED5B95C0293420DB6C74C';   //微信支付申请对应的公众号的APP Key
    public   $appKey = '8866c01c3874df473a98852a3cba4a30';   //https://pay.weixin.qq.com 帐户设置-安全设置-API安全-API密钥-设置API密钥

    public $enableCsrfValidation = false;
    //容量对应的价格
    public $volume_price=[
        '0.4'=>0.01,
        '1'=>2,
        '2'=>3,
        '5'=>6,
        '7.5'=>10,
    ];
    public function beforeAction($action)
    {
        //获取openid后，微信原路径返回时会截取掉参数，先保存到seesion
        $datas=\Yii::$app->request->get()?\Yii::$app->request->get():\Yii::$app->request->post();
        if($datas){
            \Yii::$app->session->set('datas',$datas);
        }

        $this->checkOpenid();
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    //购水页面
    public function actionBuyWater(){
        if(!$this->is_weixin()){
            return $this->renderPartial('user_message',['msg'=>'请用微信扫码']);
        }
        $goods_info=\Yii::$app->session->get('datas');
        //接收二维码的参数（产品型号（XXX-XXXX）-工厂代码（X-XX）-产品批次号（X-XX）-流水号（XXXXX））
        $CodeNumber=array_key_exists('info',$goods_info)?$goods_info['info']:'';
        //判断是用户购水，还是酒店登记绑定设备
        $hotel=array_key_exists('hotel',$goods_info)?$goods_info['hotel']:'';
        //酒店继续登记，上次生成的编号
        $DevNo=array_key_exists('DevNo',$goods_info)?$goods_info['DevNo']:'';

        //用户购水
        if(!$hotel||$hotel!='YES'){//用户购水

            if(!$CodeNumber){
                return $this->renderPartial('user_message',['msg'=>'扫码失败，请重新扫码']);
            }

            $data=ActiveRecord::findBySql("select DevNo from dev_regist where CodeNumber='$CodeNumber'
and IsActive=1 and AgentId > 0
and not exists (select 1 from dev_cmd
        where CmdType=4 and State=1 and DevNo=dev_regist.DevNo)
")->asArray()->one();
            if(!$data){
                //提示错误，该二维码有误
                return $this->renderPartial('user_message',['msg'=>'该二维码有误，请联系工作人员']);

            }
            $DevNo=$data['DevNo'];
            //判断对应设备是否连网
            $connect=ActiveRecord::findBySql("select LastConnectTime,LastConnectDate from dev_status where DevNo='$DevNo'")->asArray()->one();
            if(!$connect){
                //没有连网
                return $this->renderPartial('user_message',['msg'=>'该设备没有连网，请联系工作人员']);
            }
            $last_connect_time=$connect['LastConnectDate'].' '.$connect['LastConnectTime'];
            $last_connect_time=strtotime($last_connect_time);
            if((time()-$last_connect_time)>180){//上次连网时间超过了3分钟
                //没有连网
                return $this->renderPartial('user_message',['msg'=>'该设备没有连网，请联系工作人员']);
            }

            //有连网
            return $this->renderPartial('buy_water',['CodeNumber'=>$CodeNumber,'DevNo'=>$DevNo]);
        }

        if(!$CodeNumber){
            return $this->renderPartial('message',['msg'=>'扫码失败，请重新扫码']);
        }

        //酒店登记绑定(判断该二维码是否已经绑定过了)
        $data=ActiveRecord::findBySql("select DevNo from dev_regist where CodeNumber='$CodeNumber'")->asArray()->one();
        if($data){//该二维码绑定了设备
            //提示
            return $this->renderPartial('message',['msg'=>'该二维码绑定过设备了，请联系太极兵工作人员']);
        }


        if($DevNo){//酒店继续登记
            //跳回登记第二个页面
            header("Location: /index.php/agent/register-dev-info?DevNo=$DevNo");
            exit;

        }

        //跳回登记第一个页面
        header("Location: /index.php/agent/register");
        exit;



    }

    public function actionPayMoney(){
        if(!$this->is_weixin()){
            return $this->renderPartial('user_message',['msg'=>'请用微信支付']);
        }
        //①、获取用户openid
        $openId = \Yii::$app->session->get('openid');      //获取openid
        if(!$openId){
            return $this->renderPartial('user_message',['msg'=>'获取openid失败']);
        }

        $now=date('Y-m-d H:i:s');

        $goods_info=\Yii::$app->session->get('datas');
        //酒店买水支付
            if(!array_key_exists('volume',$goods_info)||!array_key_exists('price',$goods_info)
                ||!array_key_exists('DevNo',$goods_info)||!array_key_exists('CodeNumber',$goods_info)){
                return json_encode(['state'=>-1,'msg'=>'参数错误']);
            }
            $volume=$goods_info['volume'];//容量
            $price=$goods_info['price'];//价格
            $DevNo=$goods_info['DevNo'];//设备编号
            $CodeNumber=$goods_info['CodeNumber'];//二维码编号
            //获取商品名称
            $goods_id=0;
            $brand_id='';
            $goods_name='一次性包装水';
            $data=ActiveRecord::findBySql("select GoodsId from dev_water_scan where DevNo='$DevNo' order by RowTime desc limit 1")->asArray()->one();
            if($data){
                $goods_id=$data['GoodsId'];
                $goods=ActiveRecord::findBySql("select `name`,brand_id from goods where id=$goods_id")->asArray()->one();
                if($goods){
                    $goods_name=$goods['name'].$goods_name;
                    $brand_id=$goods['brand_id'];
                }
            }

            //订单号
            $outTradeNo=$DevNo.date("YmdHis");
            //付款金额
            $pay_money=$this->volume_price[$volume];

            //保存订单
            $sql="insert into hotel_user_order(`DevNo`,`CodeNumber`,`OutTradeNo`,`OpenId`,`GoodsId`,`BrandId`,`Volume`,`PayMoney`,`RowTime`,`PayType`,`ActTime`,`State`,`OrderState`)
              VALUES ('$DevNo','$CodeNumber','$outTradeNo','$openId',$goods_id,'$brand_id',$volume,$pay_money,'$now',1,'$now',0,0)";
            $re=\Yii::$app->db->createCommand($sql)->execute();
            if(!$re){
                return json_encode(['state'=>-1,'msg'=>'生成订单失败，请重新购买']);
            }


        $wxPay = new WxpayService($this->mchid,$this->Appid,$this->appKey,$this->apiKey);

        //②、统一下单
//        $outTradeNo = uniqid();     //你自己的商品订单号
//        $payAmount = 0.01;          //付款金额，单位:元
//        $orderName = '测试';    //订单标题
        $notifyUrl = 'http://test.wx.taijibing.cn/index.php/wei-xin-pay/notify';     //付款成功后的回调地址(不要有问号)
        $payTime = time();      //付款时间
        $jsApiParameters = $wxPay->createJsBizPackage($openId,$pay_money,$outTradeNo,$goods_name,$notifyUrl,$payTime);
        $jsApiParameters = json_encode($jsApiParameters);
        return json_encode([
            'state'=>0,
            'jsApiParameters'=>$jsApiParameters,
            'editAddress'=>'',
        ]);
    }

    /**
     * notify_url接收页面
     */
    public function actionNotify(){

        $config = array(
            'mch_id' => $this->mchid,
            'appid' => $this->Appid,
            'key' => $this->apiKey,
        );
        $postStr = file_get_contents('php://input');
        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        if ($postObj === false) {
            die('parse xml error');
        }
        if ($postObj->return_code != 'SUCCESS') {
            die($postObj->return_msg);
        }
        if ($postObj->result_code != 'SUCCESS') {
            die($postObj->err_code);
        }
        $arr = (array)$postObj;
        unset($arr['sign']);
        $wxPay = new WxpayService($this->mchid,$this->Appid,$this->appKey,$this->apiKey);
        if ($wxPay->getSign($arr, $config['key']) == $postObj->sign) {
            //查看是否有该订单
            $data=ActiveRecord::findBySql("select Id,DevNo,Volume,PayMoney from hotel_user_order where OutTradeNo='$postObj->out_trade_no' and State=0 ")->asArray()->one();
            //酒店支付
                if($data['PayMoney']*100==$postObj->total_fee){//支付金额是否一致
                    $now=date('Y-m-d H:i:s',time());
                    //保存微信官方生成的订单流水号，修改支付状态、订单状态、操作时间
                    $sql="update hotel_user_order set TransactionId='$postObj->transaction_id',State=1,OrderState=1,ActTime='$now' where Id={$data['Id']}";
                    $re=\Yii::$app->db->createCommand($sql)->execute();

                    //下发可使用水量命令
                    $ExpiredTime=date('Y-m-d H:i:s',time()+300);
                    $WaterExpiredTime=date('Y-m-d H:i:s',time()+24*300);
                    $sql2="insert into dev_cmd (DevNo,StartTime,ExpiredTime,CmdType,Cmd,RowTime)
                        VALUES ('{$data['DevNo']}','$now','$ExpiredTime',9,'1,1,{$data['Volume']},$WaterExpiredTime','$now')";
                    $re2=\Yii::$app->db->createCommand($sql2)->execute();


                }

            echo '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';
            return $arr;
        }
    }

    /**
     * 微信退款
     * @param  string   $order_id   订单ID
     * @return 成功时返回(array类型)，其他抛异常
     */
    public function actionReturnMoney(){
        //订单号
        $out_trade_no=\Yii::$app->request->get('out_trade_no')?\Yii::$app->request->get('out_trade_no'):\Yii::$app->session->get('datas')['out_trade_no'];
        //微信官方生成的订单流水号
        $transaction_id=\Yii::$app->request->get('transaction_id')?\Yii::$app->request->get('transaction_id'):\Yii::$app->session->get('datas')['transaction_id'];

        if(!$out_trade_no||!$transaction_id){
            return json_encode(['state'=>-1,'msg'=>'参数错误']);
        }



        //退款金额
        //酒店订单
        $data=ActiveRecord::findBySql("select Id,DevNo,PayMoney,Volume from hotel_user_order where OutTradeNo='$out_trade_no' and TransactionId='$transaction_id' and State=1")->asArray()->one();
        //商城订单
        $data2=ActiveRecord::findBySql("select Id,PayMoney from shop_user_order where OutTradeNo='$out_trade_no' and TransactionId='$transaction_id' and PayState=1")->asArray()->one();
        if(!$data&&!$data2){
            return json_encode(['state'=>-1,'msg'=>'没有该订单']);
        }
        if($data&&!$data2){//酒店订单 退款
            $total_fee=$data['PayMoney']*100;//微信单位是分
            //生成退款单号
            $out_refund_no=$data['DevNo'].date('YmdHis');
        }elseif($data2&&!$data){//商城订单 退款
            $total_fee=$data2['PayMoney']*100;//微信单位是分
            //生成退款单号
            $out_refund_no=date('YmdHis');
        }
        $wxPay = new WxpayService($this->mchid,$this->Appid,$this->appKey,$this->apiKey);

        //查询该订单是否可以退款
        $res=$wxPay->orderquery($out_trade_no);
        if($res['code']==-1){
            return json_encode(['state'=>-1,'msg'=>$res['msg']]);
        }

        $result = $wxPay->doRefund($total_fee, $total_fee, $out_refund_no, $transaction_id,$out_trade_no);


        $now=date('Y-m-d H:i:s',time());
        if(($result['return_code']=='SUCCESS') && ($result['result_code']=='SUCCESS')){

            if($data&&!$data2){//酒店订单 退款
                //退款成功,修改订单状态、操作时间
                $sql="update hotel_user_order set OutRefundNo='{$result['out_refund_no']}', OrderState=3,ActTime='$now' where TransactionId='{$result['transaction_id']}' and OutTradeNo='{$result['out_trade_no']}'";
                \Yii::$app->db->createCommand($sql)->execute();

                //将该设备下发的可用水量命令设置无效
                $sql2="update dev_cmd set ExpiredTime='$now' where DevNo='{$data['DevNo']}' and CmdType=9 and Cmd = '1,{$data['Volume']}' and State=0 and ExpiredTime > '$now'";
                \Yii::$app->db->createCommand($sql2)->execute();

            }elseif($data2&&!$data){//商城订单 退款
                //退款成功,修改订单状态、操作时间
                $sql="update shop_user_order set OutRefundNo='{$result['out_refund_no']}',OrderState=2,ActTime='$now' where TransactionId='{$result['transaction_id']}' and OutTradeNo='{$result['out_trade_no']}'";
                \Yii::$app->db->createCommand($sql)->execute();
            }

            $data=json_encode(['state'=>0]);
        }else if(($result['return_code']=='FAIL') || ($result['result_code']=='FAIL')){

            if($data&&!$data2) {//酒店订单 退款
                //退款失败,修改订单状态、操作时间
                $sql = "update hotel_user_order set OrderState=4,ActTime='$now' where TransactionId='$transaction_id' and OutTradeNo='$out_trade_no'";
                \Yii::$app->db->createCommand($sql)->execute();
            }elseif($data2&&!$data){//商城订单 退款
                //退款成功,修改订单状态、操作时间
                $sql="update shop_user_order set OrderState=3,ActTime='$now' where TransactionId='{$result['transaction_id']}' and OutTradeNo='{$result['out_trade_no']}'";
                \Yii::$app->db->createCommand($sql)->execute();
            }
            //原因
            $reason = (empty($result['err_code_des'])?$result['return_msg']:$result['err_code_des']);
            $data=json_encode(['state'=>-1,'msg'=>$reason]);
        }else{
            //失败
            $data=json_encode(['state'=>-1,'msg'=>'失败,请重新操作']);
        }

        return $data;
    }

}


class WxpayService
{
    protected $mchid;
    protected $appid;
    protected $appKey;
    protected $apiKey;
    public $data = null;
    public function __construct($mchid, $appid, $appKey,$key)
    {
        $this->mchid = $mchid; //https://pay.weixin.qq.com 产品中心-开发配置-商户号
        $this->appid = $appid; //微信支付申请对应的公众号的APPID
        $this->appKey = $appKey; //微信支付申请对应的公众号的APP Key
        $this->apiKey = $key;   //https://pay.weixin.qq.com 帐户设置-安全设置-API安全-API密钥-设置API密钥
    }
    /**
     * 通过跳转获取用户的openid，跳转流程如下：
     * 1、设置自己需要调回的url及其其他参数，跳转到微信服务器https://open.weixin.qq.com/connect/oauth2/authorize
     * 2、微信服务处理完成之后会跳转回用户redirect_uri地址，此时会带上一些参数，如：code
     * @return 用户的openid
     */
    public function GetOpenid()
    {
        //通过code获得openid
        if (!isset($_GET['code'])){
            //触发微信返回code码
            $scheme = $_SERVER['HTTPS']=='on' ? 'https://' : 'http://';
            $baseUrl = urlencode($scheme.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].$_SERVER['QUERY_STRING']);
            $url = $this->__CreateOauthUrlForCode($baseUrl);
            Header("Location: $url");
            exit();
        } else {
            //获取code码，以获取openid
            $code = $_GET['code'];
            $openid = $this->getOpenidFromMp($code);
            return $openid;
        }
    }
    /**
     * 通过code从工作平台获取openid机器access_token
     * @param string $code 微信跳转回来带上的code
     * @return openid
     */
    public function GetOpenidFromMp($code)
    {
        $url = $this->__CreateOauthUrlForOpenid($code);
        $res = self::curlGet($url);
        //取出openid
        $data = json_decode($res,true);
        $this->data = $data;
        $openid = $data['openid'];
        return $openid;
    }
    /**
     * 构造获取open和access_toke的url地址
     * @param string $code，微信跳转带回的code
     * @return 请求的url
     */
    private function __CreateOauthUrlForOpenid($code)
    {
        $urlObj["appid"] = $this->appid;
        $urlObj["secret"] = $this->appKey;
        $urlObj["code"] = $code;
        $urlObj["grant_type"] = "authorization_code";
        $bizString = $this->ToUrlParams($urlObj);
        return "https://api.weixin.qq.com/sns/oauth2/access_token?".$bizString;
    }
    /**
     * 构造获取code的url连接
     * @param string $redirectUrl 微信服务器回跳的url，需要url编码
     * @return 返回构造好的url
     */
    private function __CreateOauthUrlForCode($redirectUrl)
    {
        $urlObj["appid"] = $this->appid;
        $urlObj["redirect_uri"] = "$redirectUrl";
        $urlObj["response_type"] = "code";
        $urlObj["scope"] = "snsapi_base";
        $urlObj["state"] = "STATE"."#wechat_redirect";
        $bizString = $this->ToUrlParams($urlObj);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?".$bizString;
    }
    /**
     * 拼接签名字符串
     * @param array $urlObj
     * @return 返回已经拼接好的字符串
     */
    private function ToUrlParams($urlObj)
    {
        $buff = "";
        foreach ($urlObj as $k => $v)
        {
            if($k != "sign") $buff .= $k . "=" . $v . "&";
        }
        $buff = trim($buff, "&");
        return $buff;
    }
    /**
     * 统一下单
     * @param string $openid 调用【网页授权获取用户信息】接口获取到用户在该公众号下的Openid
     * @param float $totalFee 收款总费用 单位元
     * @param string $outTradeNo 唯一的订单号
     * @param string $orderName 订单名称
     * @param string $notifyUrl 支付结果通知url 不要有问号
     * @param string $timestamp 支付时间
     * @return string
     */
    public function createJsBizPackage($openid, $totalFee, $outTradeNo, $orderName, $notifyUrl, $timestamp)
    {
        $config = array(
            'mch_id' => $this->mchid,
            'appid' => $this->appid,
            'key' => $this->apiKey,
        );
//        $orderName = iconv('GBK','UTF-8//IGNORE',$orderName);
        $unified = array(
            'appid' => $config['appid'],
            'attach' => 'pay',             //商家数据包，原样返回，如果填写中文，请注意转换为utf-8
            'body' => $orderName,
            'mch_id' => $config['mch_id'],
            'nonce_str' => self::createNonceStr(),
            'notify_url' => $notifyUrl,
            'openid' => $openid,            //rade_type=JSAPI，此参数必传
            'out_trade_no' => $outTradeNo,
            'spbill_create_ip' => $_SERVER['REMOTE_ADDR'],
            'total_fee' => intval($totalFee * 100),       //单位 转为分
            'trade_type' => 'JSAPI',
        );
        $unified['sign'] = self::getSign($unified, $config['key']);
        $responseXml = self::curlPost('https://api.mch.weixin.qq.com/pay/unifiedorder', self::arrayToXml($unified));
        $unifiedOrder = simplexml_load_string($responseXml, 'SimpleXMLElement', LIBXML_NOCDATA);
        if ($unifiedOrder === false) {
            die('parse xml error');
        }
        if ($unifiedOrder->return_code != 'SUCCESS') {
            die($unifiedOrder->return_msg);
        }
        if ($unifiedOrder->result_code != 'SUCCESS') {
            die($unifiedOrder->err_code);
        }
        $arr = array(
            "appId" => $config['appid'],
            "timeStamp" => "$timestamp",        //这里是字符串的时间戳，不是int，所以需加引号
            "nonceStr" => self::createNonceStr(),
            "package" => "prepay_id=" . $unifiedOrder->prepay_id,
            "signType" => 'MD5',
        );
        $arr['paySign'] = self::getSign($arr, $config['key']);
        return $arr;
    }
    public static function curlGet($url = '', $options = array())
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        if (!empty($options)) {
            curl_setopt_array($ch, $options);
        }
        //https请求 不验证证书和host
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
    public static function curlPost($url = '', $postData = '', $options = array())
    {
        if (is_array($postData)) {
            $postData = http_build_query($postData);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //设置cURL允许执行的最长秒数
        if (!empty($options)) {
            curl_setopt_array($ch, $options);
        }
        //https请求 不验证证书和host
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
    public static function createNonceStr($length = 16)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
    public static function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
        }
        $xml .= "</xml>";
        return $xml;
    }
    public static function getSign($params, $key)
    {
        ksort($params, SORT_STRING);
        $unSignParaString = self::formatQueryParaMap($params, false);
        $signStr = strtoupper(md5($unSignParaString . "&key=" . $key));
        return $signStr;
    }
    protected static function formatQueryParaMap($paraMap, $urlEncode = false)
    {
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v) {
            if (null != $v && "null" != $v) {
                if ($urlEncode) {
                    $v = urlencode($v);
                }
                $buff .= $k . "=" . $v . "&";
            }
        }
        $reqPar = '';
        if (strlen($buff) > 0) {
            $reqPar = substr($buff, 0, strlen($buff) - 1);
        }
        return $reqPar;
    }
    /**
     * 退款
     * @param float $totalFee 订单金额 单位元
     * @param float $refundFee 退款金额 单位元
     * @param string $refundNo 退款单号
     * @param string $wxOrderNo 微信订单号
     * @param string $orderNo 商户订单号
     * @return string
     */
    public function doRefund($totalFee, $refundFee, $refundNo, $wxOrderNo='',$orderNo='')
    {
        $config = array(
            'mch_id' => $this->mchid,
            'appid' => $this->appid,
            'key' => $this->apiKey,
        );
        $unified = array(
            'appid' => $config['appid'],
            'mch_id' => $config['mch_id'],
            'nonce_str' => self::createNonceStr(),
            'total_fee' => intval($totalFee),       //订单金额	 单位 转为分
            'refund_fee' => intval($refundFee),       //退款金额 单位 转为分
            'sign_type' => 'MD5',           //签名类型 支持HMAC-SHA256和MD5，默认为MD5
            'transaction_id'=>$wxOrderNo,               //微信订单号
            'out_trade_no'=>$orderNo,        //商户订单号
            'out_refund_no'=>$refundNo,        //商户退款单号
//            'refund_desc'=>'商品已售完',     //退款原因（选填）
        );
        $unified['sign'] = self::getSign($unified, $config['key']);
        $responseXml = $this->curlPost('https://api.mch.weixin.qq.com/secapi/pay/refund', self::arrayToXml($unified));
        $unifiedOrder = simplexml_load_string($responseXml, 'SimpleXMLElement', LIBXML_NOCDATA);
//        if ($unifiedOrder === false) {
//            die('parse xml error');
//        }
//        if ($unifiedOrder->return_code != 'SUCCESS') {
//            die($unifiedOrder->return_msg);
//        }
//        if ($unifiedOrder->result_code != 'SUCCESS') {
//            die($unifiedOrder->err_code);
//        }
//        return true;
        return $unifiedOrder;
    }

    public function orderquery($outTradeNo)
    {
        $config = array(
            'mch_id' => $this->mchid,
            'appid' => $this->appid,
            'key' => $this->apiKey,
        );
        //$orderName = iconv('GBK','UTF-8',$orderName);
        $unified = array(
            'appid' => $config['appid'],
            'mch_id' => $config['mch_id'],
            'out_trade_no' => $outTradeNo,
            'nonce_str' => self::createNonceStr(),
        );
        $unified['sign'] = self::getSign($unified, $config['key']);
        $responseXml = self::curlPost('https://api.mch.weixin.qq.com/pay/orderquery', self::arrayToXml($unified));
        $queryResult = simplexml_load_string($responseXml, 'SimpleXMLElement', LIBXML_NOCDATA);
        if ($queryResult === false) {
            die('parse xml error');
        }
        if ($queryResult->return_code != 'SUCCESS') {
            die($queryResult->return_msg);
        }
        $trade_state = $queryResult->trade_state;
        $data['code'] = $trade_state=='SUCCESS' ? 0 : -1;
        $data['data'] = $trade_state;
        $data['msg'] = $this->getTradeSTate($trade_state);
        $data['time'] = date('Y-m-d H:i:s');
        return $data;
    }

    public function getTradeSTate($str)
    {
        switch ($str){
            case 'SUCCESS';
                return '支付成功';
            case 'REFUND';
                return '转入退款';
            case 'NOTPAY';
                return '未支付';
            case 'CLOSED';
                return '已关闭';
            case 'REVOKED';
                return '已撤销（刷卡支付）';
            case 'USERPAYING';
                return '用户支付中';
            case 'PAYERROR';
                return '支付失败';
        }
    }
}