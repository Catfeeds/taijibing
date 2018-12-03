<?php
//init.php  主要是引用lib中的4個文件
require_once  dirname(__FILE__).'/lib/WxPay.Api.php';
require_once  dirname(__FILE__).'/lib/WxPay.Config.php';
require_once  dirname(__FILE__).'/lib/WxPay.Data.php';
require_once  dirname(__FILE__).'/lib/WxPay.Exception.php';
require_once  dirname(__FILE__).'/lib/WxPay.Notify.php';