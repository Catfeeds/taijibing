<?php
error_reporting(E_ALL & ~ E_NOTICE);
header('Content-Type:text/html;charset=utf-8');

$start=[1=>'个',2=>'十',3=>'百',4=>'千',5=>'万'];
$begin=$start[mt_rand(1,5)];


echo '<div id="no" style="width: 500px;height:100px;background-color: #e6e6e6;margin:100px auto">
    <div style="width: 500px;height:40px;background-color: #e6e6e6;margin-bottom: 0;">
        
    </div>
    <h1 style="text-align: center">';
		echo $begin.'</span>&nbsp;&nbsp;';
foreach($red as $k=>$v){
    if($k<5){
        echo '<span style="color: red">'.$v.'</span>&nbsp;&nbsp;';
    }else{
        echo '<span style="color: blue">'.$v.'</span>&nbsp;&nbsp;';
    }

}
echo '</h1>
    <div  style="width:80px;height:40px;margin: auto;background-color: blue;text-align: center;cursor:pointer;border:1px solid;border-radius:15px;" id="btn"><h3 style="font: 20px/8px 微软雅黑">重新获取</h3></div>
</div>';
?>
<!--<script type="text/javascript" src="/static/js/common.js"></script>-->
<script src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>
<script>
    $(function(){
        $('#btn').mouseover(function(){
            $(this).css('background-color','orange');
            //$(this).css('cursor ','pointer');
        });
        $('#btn').mouseout(function(){
            $(this).css('background-color','blue');
        });
        $('#btn').click(function(){
            window.location.href="/index.php?r=test/test2";
        });
    })


</script>