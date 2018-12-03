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
    <title>设备列表</title>
    <style>
      .table-hr {
        border-bottom: 4px solid #f3f3f3;
        height: 90px;
        padding:15px;
      }

      .table-hr .red_line{
        height: 100%;
        line-height: 60px;
        text-indent: 80px;
        font-weight: bold;
      }
      .table-hr .red_line img{
        position: absolute;
        height: 60px;
        left: 25px;
      }
      .table_bd   .red_line{
        border-bottom: 1px solid #f3f3f3;
        padding:15px;
            font-size: 12px;
    color: #999;

      } 
      .table_right{
           display: inline-block;
          float: right;
          min-width: 40px;
          text-align: center;
          background: #f3f3f3;
          border-radius: 12px;
          padding: 2px;
      }




    </style>
</head>

<body>
<div class="form">

    <div class="table-hr">
          <div class="red_line">
              <div>
                <img src="/static/images/bgcolort.png" alt="">
                 <span>数据视图</span>
                  <p style="    float: right;  font-weight: 400;    text-indent: 0; color: #999;"> 新增用户人数</p>
              </div>
              
             
          </div>

            

    </div>


    <div class="table_bd" >

        
        <p class="red_line"><span class="table_left">小黄</span><span class="table_right">2</span></p>
        <p class="red_line"><span class="table_left">小黄</span><span class="table_right">3</span></p>
    </div>

</div>

</body>
<script type="text/javascript" src="/static/js/zepto.min.js"></script>
<script type="text/javascript" src="/static/js/coderlu.js"></script>
<script type="text/javascript" src="/static/js/common.js" ></script>
<script>

    var userdatax=  JSON.parse(<?=json_encode($userdatax)?>)  ;
    var userdatay= JSON.parse(<?=json_encode($userdatay)?>);

    $(".table_bd").empty();
    for(var i=0;i<userdatax.length;i++){

          var tr=' <p class="red_line"><span class="table_left">'+userdatax[i]+'</span><span class="table_right">'+userdatay[i]+'</span></p>';
           $(".table_bd").append($(tr));
    }

</script>
</html>