<!DOCTYPE html>
<html>
<head lang="en">
    <meta http-equiv="Content-Type" content="textml; charset=UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta HTTP-EQUIV="pragma" CONTENT="no-cache">
    <meta HTTP-EQUIV="Cache-Control" CONTENT="no-cache, must-revalidate">
    <meta HTTP-EQUIV="expires" CONTENT="0">
    <meta charset="utf-8" />
    <link rel="stylesheet" href="/static/css/common.css" />
    <link rel="stylesheet" href="/static/css/coderlu.css"/>
    <title>硬件告警</title>
    <style>

        .table_header {
		    display: inline-table;
		    width: 23%;
		    text-align: center;
		    
		    line-height: 20px;
		    border-left: 1px solid #f3f3f3;
        box-sizing: border-box;
     font-size: 12px;
     vertical-align: middle;
		}
        .table-hr{

           
    position: fixed;
    width: 100%;
    top: 0;
    height: 41px;
    border-bottom: 1px solid #f3f3f3;
    font-weight: bold;
        }
        .table-hr   .table_header {
        	height:40px;
           width: 23%;
        	line-height:40px;
           font-size: 12px
        }
        body{
            background:#f3f3f3;
        }
        .blud_line{
            background:white;border:1px solid #f3f3f3;border-radius: 4px;height:80px;
            margin-top:10px;
            line-height:80px;
        }
        .red_line{
            background:white;border:1px solid #f3f3f3;border-radius: 4px;height:80px;
            margin-top:10px;
            line-height:80px;
        }      .search{
          text-align: center;padding:10px;height: 50px;background: #f3f3f3;
        }
        .search input {
          height: 30px;
           border-top-left-radius: 10px;
           border-radius: 10px;text-indent: 10px;
           border: none;
        }
         .search button{
        height: 30px;      width: 50px;
        border-top-right-radius: 10px;
        border-radius: 10px;border: none;border-bottom: 3px solid #dddddd;
        }

    </style>
</head>
<body>
<div class="form">
  <div class="table-hr">
      <div class='search'>
 <label><input type="text" name="" value=""  placeholder="请输入用户名/设备编号"><span></span></label>
</div>
    <p style="background:white;border-bottom: solid 10px #f3f3f3;"><span class="table_header total_num" style="width: 8%;">0</span><span class="table_header">用户姓名</span><span class="table_header">设备编号</span><span class="table_header">设备状态</span><span class="table_header">租赁单</span></p>
</div>
  <!--   <div class="table-hr">
        <p style="background:white;"><span class="table_header total_num" style="width: 8%;">0</span><span class="table_header">用户姓名</span><span class="table_header">手机号</span><span class="table_header">告警类型</span><span class="table_header">告警时间</span></p>
    </div> -->
    <div class="table_bd" style="padding:0 8px;margin-top: 100px;">
        <p class="red_line"><span class="table_header">用户姓名</span><span class="table_header">手机号</span><span class="table_header">告警类型</span><span class="table_header">告警时间</span></p>
    </div>
</div>
<script type="text/javascript" src="/static/js/zepto.min.js"></script>
<script type="text/javascript" src="/static/js/coderlu.js"></script>
<script type="text/javascript" src="/static/js/common.js" ></script>
<script>
</script>
<script>
    $(function(){
        var res=<?=json_encode($data)?>;
       if(res.state!=0){
           return;
      }
console.log(res)
$('.search input').on('input propertychange', function() {
    var search=Trim($('.search input').val());
    console.log(search)
    var dataD=[]; 
    $.each(res.result, function(key, value){
      if(value.name.indexOf(search) != -1 ){
               dataD.push(value)
      }else if(value.mobile.indexOf(search) != -1 ){
               dataD.push(value)
      };
    });
console.log(dataD) 
data_init(dataD)
});
var list=res.result;
data_init(list)
function data_init(list){
     $(".table_bd").empty();
        $(".total_num").text(list.length)
       for(var index=0;index<list.length;index++){
            var item=list[index];
        var tr=' <p class="table_tr '+(index%2==0?"blud_line":"red_line")+'"><span  class="table_header" style="width:8%">'+(index*1+1)+'</span><span class="table_header">'+item.name+'</span><span class="table_header">'+item.mobile+'</span><span class="table_header"  style="color:'+getColorBywatervl(item.type)+'">'+item.type+'</span><span class="table_header ">'+ item.interval+'</span></p>';
           $(".table_bd").append($(tr));
        }
}

      
   
    });


   function getTime(_val){
     var val=Number(_val);
      if(val<60){
         return val+"分钟前";
         }
        var hours=(val/60).toFixed(0);
         if(hours<24){
             return hours+"小时前"
         }变
        var days=(hours/24).toFixed(0);
        return days+"天前";
    }
  function getColorBywatervl(_val){
        if(_val=='无数据上传'||_val=='长期未操作'||_val=='位置变更'){
            return "red";
        }else{
             return "#34a0f8";
        }
    }



</script>
</body>
</html>