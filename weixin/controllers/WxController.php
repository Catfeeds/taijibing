<?php
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/5/19
 * Time: 下午2:32
 */

namespace app\controllers;
use yii;

class WxController extends BaseController
{
    private static $appid="wx3fd68d66f47f0b32";
    private static $appsecret="8866c01c3874df473a98852a3cba4a30";


    public function checkOpenid(){

        $openid=yii::$app->session->get("openid");
        if(empty($openid)){
            $this->getOpenid();
        }
    }
    public function getOpenid(){
        if(!$this->is_weixin()){
            return;
        }
        yii::$app->session->set("openid_url",$this->module->requestedRoute);
        $APPID=WxController::$appid;
        $REDIRECT_URI='http://'.$_SERVER['SERVER_NAME'].($_SERVER['SERVER_PORT']==80?'':':'.$_SERVER['SERVER_PORT']).'/index.php/wx/get-wx-auth';
        $scope='snsapi_base';
        $state="weixin";
        $url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$APPID.'&redirect_uri='.$REDIRECT_URI.'&response_type=code&scope='.$scope.'&state='.$state.'#wechat_redirect';
        header("Location:".$url);
        exit();
    }
    public function actionGetWxAuth(){
        $appid = WxController::$appid;
        $secret = WxController::$appsecret;
        $code = $_GET["code"];
        if($code==null){
            $this->toError();
        }
        $get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        $res = file_get_contents($get_token_url, false, stream_context_create($arrContextOptions));
        //$res=file_get_contents($get_token_url);
        $json_obj = json_decode($res,true);
        if(!empty($json_obj["errcode"])){
            //微信授权失败
            $this->toError();
        }
        $openid = $json_obj['openid'];
        yii::$app->session->set("openid",$openid);
        //跳转至原路径
        $openid_url=yii::$app->session->get("openid_url");
        if(empty($openid_url)){
            $this->toError();
        }
        header("Location:/index.php/".$openid_url);
        exit();
    }
    public function actionError(){
        return $this->renderPartial("error");
    }
    public function toError(){
        header("Location:/index.php/wx/error");
        exit();
    }

    //调用微信扫一扫，参数
    public function GetSignPackage() {
        if(!$this->is_weixin()){
            return [
                "appId"     => '',
                "nonceStr"  => '',
                "timestamp" => '',
                "url"       => '',
                "signature" => '',
                "rawString" => '',
            ];
        }
        $jsapiTicket = $this->getJsApiTicket();

        // 注意 URL 一定要动态获取，不能 hardcode.
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $timestamp = time();
        $nonceStr = $this->createNonceStr();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1($string);

        $signPackage = array(
            "appId"     => WxController::$appid,
            "nonceStr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
            "rawString" => $string,
        );
        return $signPackage;
    }

    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    private function getJsApiTicket() {
        // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
        $data = json_decode($this->get_php_file("../web/static/jsapi_ticket.php"));
        if ($data->expire_time < time()) {
            $accessToken = $this->getAccessToken();
            // 如果是企业号用以下 URL 获取 ticket
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
            $res = json_decode($this->httpGet($url));

            if($res->errcode==40001){
                $this->AccessTokenLog('获取ticket时access_token失效');
                $accessToken = $this->getAccessToken(1);
                $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
                $res = json_decode($this->httpGet($url));
            }

            $ticket = $res->ticket;
            if ($ticket) {
                $data->expire_time = time() + 3600;
                $data->jsapi_ticket = $ticket;
                $this->set_php_file("../web/static/jsapi_ticket.php", json_encode($data));
            }
        } else {
            $ticket = $data->jsapi_ticket;

        }

        return $ticket;
    }

    public function getAccessToken($is_get_new='') {
        // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
        $data = json_decode($this->get_php_file("../web/static/access_token.php"));
        if ($data->expire_time < time()||$is_get_new==1) {
            // 如果是企业号用以下URL获取access_token
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".WxController::$appid."&secret=".WxController::$appsecret;
            $res = json_decode($this->httpGet($url));
            $access_token = $res->access_token;
            if ($access_token) {
                $data->expire_time = time() + 3600;
                $data->access_token = $access_token;
                $this->set_php_file("../web/static/access_token.php", json_encode($data));
            }
        }else {
            $access_token = $data->access_token;
        }
        return $access_token;
    }

    private function httpGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
        // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }

    private function get_php_file($filename) {
        return trim(substr(file_get_contents($filename), 15));
    }
    private function set_php_file($filename, $content) {
        $fp = fopen($filename, "w");
        fwrite($fp, "<?php exit();?>" . $content);
        fclose($fp);
    }

    //记录access_token失效
    public function AccessTokenLog($type=''){
        $now=date('Y-m-d H:i:s',time());
        $filename="../web/static/access_token_log.txt";
        $handle=fopen($filename,"a+");
        $str=fwrite($handle,"$now $type \n");
        fclose($handle);
    }

    //根据微信用户信息下载头像
    public function GetInfo(){
        $access_token = $this->getAccessToken();
        $openid=\Yii::$app->session->get('openid');
        //获取用户信息地址
        $urlid = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $urlid);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
        //curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
        $tmpInfo = curl_exec($curl);     //返回api的json对象
        //关闭URL请求
        curl_close($curl);
        $userinfo = json_decode($tmpInfo,true);
        if($userinfo&&array_key_exists('headimgurl',$userinfo)){
            //设置头像图片保存的文件路径
            $file_dir='E:/www/yun/static/portrait';
//            $file_dir='E:/www/testwww/static/portrait';//测试环境的

            $file_name='http://www.taijibing.cn/static/portrait/'.$openid.".jpg";//图片路径
//            $file_name='http://test.www.taijibing.cn/static/portrait/'.$openid.".jpg";//图片路径

            $this->GetHeadPortrait($userinfo['headimgurl'],$openid,$file_dir);

            return $file_name;
        }
        return false;

    }

    //获取微信头像
    public function GetHeadPortrait($url,$openid,$file_dir){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        $file = curl_exec($ch);
        curl_close($ch);

        if (!file_exists($file_dir)) {
            mkdir($file_dir, 0777, true);
        }
        $resource = fopen($file_dir."/" . $openid.".jpg" ,'a');
        fwrite($resource, $file);
        fclose($resource);
    }


}