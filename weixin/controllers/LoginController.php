<?php
namespace app\controllers;
use app\api\AgentLoginApi;
use yii;
/**
 * Created by PhpStorm.
 * User: pengjixiang
 * Date: 17/3/17
 * Time: 下午2:11
 */
class LoginController extends BaseController
{
    public function actionLoginPage()
    {

        return $this->renderPartial("login");
    }

    /**
     * ajax 登录
     */
    public function actionLogin()
    {
//        $data['Account']='test';
//        $data['Pwd']=md5('111111');

        $username=Yii::$app->request->get("username");
        $pwd=Yii::$app->request->get("password");
        if(empty($username)||empty($pwd)){
            $data=json_decode("{}");
            $data->state=-1;
            $data->msg='用户名或密码不能为空';
            $this->jsonReturn($data);
            return;
        }
        $data['Account']=$username;
        $data['Pwd']=md5($pwd);
        $res=(new AgentLoginApi())->post($data);
        if($res->state==0){
            //登录成功,保存登录信息
            $this->saveUser($res->result);
        }
        $this->jsonReturn($res);
    }

}