<?php
namespace app\api;

/**
 * 验证验证码
 * Class CheckVCodeApi
 * @package app\api
 */
class CheckVcodeApi extends BaseApi
{
    private $path='/Agent/CheckVCode';

    public function post($tel='',$vcode=''){
        $data["tel"]=$tel;
        $data["vcode"]=$vcode;
        return $this->ajaxPost($this->path,$data);

    }
}