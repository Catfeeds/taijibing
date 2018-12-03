<?php
/**
 * Ahthor: lf
 * Email: job@feehi.com
 * Blog: http://blog.feehi.com
 * Date: 2016/4/1415:44
 */
?>

<style type="text/css">
    button{
      outline:none;

}
</style>        
<div class="middle-box text-center animated fadeInDown">
    <div style=" background:  url(/static/images3/484487747665958074.png) no-repeat  top;    background-size: 100%;"> 
         <div  class="font-bold"> 
            <p style="padding-top:100px;text-align: right;font-size: 20px;">很抱歉页面不小心迷路了~</p>
         </div>
        <button type="submit" class="btn btn-primary" onclick="reloadIframe()" style="margin-top: 20px;">刷新试试</button>
<!--         
    <h1><?=$code?></h1>
    <h3 class="font-bold"><?=$name?></h3>
    <div class="error-desc">
        <?=$message?>
        <form target="_blank" class="form-inline m-t" action="http://www.baidu.com/s" role="form">
            <div class="form-group">
            <input type="text" name="wd" class="form-control" placeholder="<?=yii::t('app', 'Please Enter the Question')?> …">
            </div>
            <button type="submit" class="btn btn-primary"><?=yii::t('app', 'Search')?></button>
        </form>
    </div> -->

    </div>

</div>
    <script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script>



    function  reloadIframe(){
     $(".btn-primary").css('backgroundColor','#E46045')
     // var url =window.location.href;
     // alert(url)

      
        location.reload();
        return false;
    }
</script>