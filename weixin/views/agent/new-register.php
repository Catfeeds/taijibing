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
    <link rel="stylesheet" href="/static/css/mui.css" />
    <title>登记</title>
    <style type="text/css">
        li {list-style-type:none;}
        .nav>.mui-row>.mui-col-sm-4:nth-child(3)  .mui-navigate-right:after, .nav>.mui-row>.mui-col-sm-4:nth-child(3)  .mui-push-right:after{
          display: none
        }
        .info .mui-table-view-cell {
            position: relative;
            overflow: hidden;
            /*padding: 11px 15px;*/
            -webkit-touch-callout: none;
            padding:0;
             padding-right: 10px; 
             text-align: right; 
        }
    .info select , .info input{
          font-size: 12px;
          height: auto;
          /* margin-top: 1px; */
          border: 0 !important;
          background-color: #fff;
          height: 30px;
          line-height: 30px;
          padding: 0 15px;
      }
      .submit{
        background:#ccc;
      }
      .ativer{
              background: url(/static/images/brnW.png) 0% 0% / 100% 100% no-repeat;
              color:#fff;
      }
      #address{
            text-align: left;    /*height: 50px;*/
      }
      #address select{
        /*width:90%;*/
        /*width:initial;*/
      }
      p{
        font-size: 11px;
      }
      #openMark{
        height: 100%;
          display: inline-block;
          position: absolute;
      }
      #PhotoBarCode td:nth-child(1){
         width: 15%;
         text-align: content;

      }

      #PhotoBarCode td:nth-child(1)>div{
        width:20px;height: 20px;border-radius: 50%;border:1px solid #000;margin: auto;text-align: center
      }
      #PhotoBarCode td:nth-child(2){
         width: 80%;
         text-indent: 10px;
         
      }
      .clickBtn button{
        margin-left: 30px;
      }
      .mui-table-view-cell{
        text-align: center
      }
</style>
</head>
<body>
<div class="register" style="font-size: 14px;">
  <div class="mui-content nav">
    <div class="mui-row">
        <div class="mui-col-sm-6 mui-col-xs-6">
            <li class="mui-table-view-cell">
                <a class="mui-navigate-right">
                    1.填写基本信息  
                </a>
            </li>
        </div>
        <div class="mui-col-sm-6 mui-col-xs-6">
            <li class="mui-table-view-cell">
                <a class="mui-navigate-right">
                    2.拍照
                </a>
            </li>
        </div>
    <!--     <div class="mui-col-sm-4 mui-col-xs-4">
            <li class="mui-table-view-cell">
                <a class="mui-navigate-right">
                    3.扫描水条码
                </a>
            </li>
        </div> -->
    </div>
   </div>
   <div class="mui-slider">
      <div class="mui-slider-group">
        <!--第一个内容区容器-->
        <div class="mui-slider-item">
          <!-- 具体内容 -->
            <div class='info'>
               <div class="mui-row" style='padding-bottom: 20px;'>
                    <div class="mui-col-sm-3 mui-col-xs-3">
                        <li class="mui-table-view-cell">
                            <!-- <a class="mui-navigate-right"> -->
                             <p style="line-height: 30px;font-size:14px;font-weight: bold">已选设备：</p> 
                            <!-- </a> -->
                        </li>
                    </div>
                    <div class="mui-col-sm-9 mui-col-xs-9">
                        <li class="mui-table-view-cell">
                           <input type="" name="" id="BrandGoods" style="width:100%;"  readonly  unselectable="on" >
                        </li>
                    </div>
                </div>
                <div class="mui-row">
                    <div class="mui-col-sm-3 mui-col-xs-3">
                        <li class="mui-table-view-cell">
                            <!-- <a class="mui-navigate-right"> -->
                             <p style="line-height: 30px;font-size:14px;font-weight: bold">购水套餐：</p> 
                            <!-- </a> -->
                        </li>
                    </div>
                    <div class="mui-col-sm-9 mui-col-xs-9">
                        <li class="mui-table-view-cell">
                           <select  id="usertype">
                                <option value="">请选择购水套餐</option>
                            </select>
                        </li>
                    </div>
                </div>
                <div class="mui-row">
                    <div class="mui-col-sm-3 mui-col-xs-3">
                        <li class="mui-table-view-cell">
                            <!-- <a class="mui-navigate-right"> -->
                             <p style="line-height: 30px;;font-size:14px;font-weight: bold">用户姓名：</p> 
                            <!-- </a> -->
                        </li>
                    </div>
                    <div class="mui-col-sm-9 mui-col-xs-9">
                      <li class="mui-table-view-cell">
                         <input type="text" class="mui-input-clear" id='username' placeholder="请输入用户姓名">
                       </li>
                    </div>
                </div>

                <div class="mui-row">
                    <div class="mui-col-sm-3 mui-col-xs-3">
                        <li class="mui-table-view-cell">
                            <!-- <a class="mui-navigate-right"> -->
                             <p style="line-height: 30px;;font-size:14px;font-weight: bold">手机号码：</p> 
                            <!-- </a> -->
                        </li>
                    </div>
                    <div class="mui-col-sm-9 mui-col-xs-9">
                      <li class="mui-table-view-cell">
                         <!-- <input type="text" class="mui-input-clear" placeholder="请输入用户姓名"> -->
                           <div class="mui-row">
                            <div class="mui-col-sm-8 mui-col-xs-8">
                               <input type="text" id="newTel" class="mui-input-clear"  maxlength="13" placeholder="请输入常用的手机号码">
                            </div>
                           <div class="mui-col-sm-4 mui-col-xs-4">
                                 <div style="text-align: right;">
                                     <button type="button" class="mui-btn mui-btn-outlined" id="getCodeBtn" style="width:90%">验证码</button>
                                 </div>
                              </div>
                           </div>
                       </li>
                    </div>
                </div>
               <div class="mui-row">
                    <div class="mui-col-sm-3 mui-col-xs-3">
                        <li class="mui-table-view-cell">
                            <!-- <a class="mui-navigate-right"> -->
                             <p style="line-height: 30px;;font-size:14px;font-weight: bold">验证码：</p> 
                            <!-- </a> -->
                        </li>
                    </div>
                    <div class="mui-col-sm-9 mui-col-xs-9">
                      <li class="mui-table-view-cell">
                         <input type="number" class="mui-input-clear"  id="vcode"  placeholder="请输入验证码">
                       </li>
                    </div>
                </div>
               <div class="mui-row">
                    <div class="mui-col-sm-3 mui-col-xs-3">
                        <li class="mui-table-view-cell">
                            <!-- <a class="mui-navigate-right"> -->
                             <p style="line-height: 30px;;font-size:14px;font-weight: bold">所在地区：</p> 
                            <!-- </a> -->
                        </li>
                    </div>
                    <div class="mui-col-sm-9 mui-col-xs-9">
                      <li class="mui-table-view-cell" id='address'>
                           <select  id="province">
                               <option value="">选择省</option>
                            </select>
                           <select  id="city">
                               <option value="">选择市</option>
                            </select>
                           <select  id="area">
                               <option value="">选择区</option>
                            </select>
                            <span   id="openMark" style='    height: 100%; display: inline-block;display:none'>
                                <div style=" height: 30px; display: inline-block;    margin-top: -10px;"> 
                               <img src="/static/images/mape-oringe.png" style="     padding: 0 10px;; width: initial;display: block;margin-top: 15px;">
                                  <!-- <p style="clear:both;"></p> -->
                             </div>
                              <p style="clear:both;"></p>
                            </span>
                           
                       </li>
                    </div>
                </div>

               <div class="mui-row">
                    <div class="mui-col-sm-3 mui-col-xs-3">
                        <li class="mui-table-view-cell">
                            <!-- <a class="mui-navigate-right"> -->
                             <p style="line-height: 30px;;font-size:14px;font-weight: bold">详细地址：</p> 
                            <!-- </a> -->
                        </li>
                    </div>
                    <div class="mui-col-sm-9 mui-col-xs-9">
                      <li class="mui-table-view-cell">
                           <textarea rows="4" cols="80" id="content"  id="search"  placeholder="请输入详细地址" style=" height: 100px;  width: 100%;"></textarea>
                       </li>
                    </div>
                </div>
                   <button class="btn submit" style=" font-size:16px;display:inline-block;width:80%;margin-left:10%;height:45px;line-height:30px;text-align:center;" >下一步</button>
            </div>
        </div>
        <!--第二个内容区-->
        <div class="mui-slider-item">
          <!-- 具体内容 -->
          <div id="Photo" style="padding:20px;">
               <!-- <div id='Photo' style="width:100%;height: 400px;"> -->
                    <img src="" alt="" style="width:100%;height: initial;min-height: 200px;" id="PhotoImg">
               <!-- </div> -->
                    <p style='text-align: center;'>上传成功 !</p>
                     <button class="btn ativer"  id='Scanned' style=" font-size:16px;display:inline-block;width:80%;margin-left:10%;height:45px;line-height:30px;text-align:center;" ><!-- 扫描水条码 -->关闭</button>
          </div>
        </div>
         <div class="mui-slider-item">
          <!-- 具体内容 -->
           <div id="PhotoBarCode"  style="padding:20px;">
               <p>提示：请认真核对水的数量及品牌、名称、容量是否相符！</p>
               <table style="width: 100%;"  border="1" cellspacing="0">
                <tbody>
                <!-- <tr class="item">
                     <td >
                         <div>
                           <span>1</span>
                         </div>
                     </td>
                     <td >
                      <p>品牌：冰川时代</p>
                      <p>商品名称：冰川矿泉水  </p>
                      <p>净含量：10L</p>
                      <p>送水时间：2018年7月1日  10:20:30</p>
                     </td>
                   </tr> -->
          </tbody>
       </table>
   <div class="clickBtn" style="margin-top:20px;    text-align: center;">
       <button class="btn ativer" ativer='1' id='complete' style="   margin-left: 0px;">登记完成</button>
       <button class="btn ativer" id='Continuous_scanning' >继续扫描</button>             
 </div>         
           </div>
        </div>
      </div>
    </div>
</div>
<script  type="text/html" charset="utf-8"  id="mark_html">
   <style type="text/css">
      .map{
        padding:20px;position: relative;    height: 100%;
        padding: 20px;
        position: relative;
        height: 100%;
        width: 100%;
        box-sizing: border-box;
        }
        .header{
        padding-bottom: 9px;
        border-bottom: 1px solid #f3f3f3;
        }
        .header p{
        border-left: 8px solid #E46045;    text-indent: 10px;    font-size: 20px;
        font-weight: bold;
        }

      #searchBtn{
        position: absolute;
          right: 0;
          width: 10%;
          height: 26px;
          background: #fff;
      }
      #allmap,#allmapNo {
      width:100%;
      height: 200px;
      }
      #allmapNo{
            position: absolute;
            top: 120px;
            left: 0;
            padding: 0 20px;
          box-sizing: border-box;
        }

      .tagging{
         width: 40px;
          height: 40px;
          position: absolute;
          top: 47%;
          left: 50%;
          margin-top: -30px;
          margin-left:-20px;
          display: none;
      }
      .close{
        position:absolute;width:25px;height:25px;right:10px;top:20px
      }
  </style> 
  <div class="map">
        <div class="header">
              <p>地图详情</p>
        </div> 

        <div  class="close">
          <img src="/static/images/loc_cancel.png" width=100%>
        </div>
        <div clss="address-search" style='padding-top: 10px;width: 100%; position: relative;height:35px;  '>
           <button type="button"  id="searchBtn"  class="mui-btn mui-btn-outlined">搜索</button>
               <input class="search"style='  box-sizing: border-box;width:80%'  lng="" lat="" type="text" name="" value="" placeholder="请输入具体地址">
          <br/>
       </div>
   <div id="allmapNo">

    <div id="allmap"></div>
    <div class="tagging">
        <img src="/static/images/bgcolopoi.gif" width=100%>
   </div>
   </div>
 <div style="clear:both"></div>
  <div class="Addmap" style='width: 100%;      margin-top: 225px; overflow: auto; height: 220px;text-align: left;text-indent:20px;background-color: #fff;padding:15px;    padding: 20px;
    box-sizing: border-box;'>
    
 <ul class="mui-table-view" id="muiList">
    <li class="mui-table-view-cell mui-media'"    datalat="104.207482" datalng = "30.74303"  >
        <a href="javascript:;">
            <img class="mui-media-object mui-pull-left" style="width:20px;height: initial;    margin-top: 10px;" src="/static/images/loc_icon.png">
            <div class="mui-media-body">
               <span  class="name">成都龙和国际茶城</span> 
                <p class='mui-ellipsis province'>四川省成都市</p>
            </div>
        </a>
    </li>
</ul> 
    </div>
</div>
</script>
<script  type="text/html" charset="utf-8"  id="code_Html">
      <style type="text/css">
        .bgt{
        width: 200px; height:50px;line-height:50px;text-align: center;    margin: auto;
        margin-top: 20px;
        background: url(/static/images/brnW.png) no-repeat;
        background-size: 100% 100%;
        color:#fff;
        }

        .bgt2{
        width: 200px; height:50px;line-height:50px;text-align: center;    margin: auto;
        margin-top: 20px;
        background: #ccc;
        background-size: 100% 100%;
        color:#fff;
        }
        .code_bg{
        text-align: center;
        margin-top:20px;
        background:white;
        margin-left:20px;
        margin-right:20px;
        /* height:280px;
        background:url("/static/images/code_bg.png");*/
        background-repeat:no-repeat;
        background-position: center;
        background-size: 100% 280px;

        /*margin-top:30px;*/
        /*padding-top:10px;*/
        }

        #code{
        padding:20px;    border-bottom: 4px solid #f3f3f3;
        }

        .header p{
        border-left: 8px solid #E46045;    text-indent: 10px;    font-size: 20px;
        font-weight: bold;
        }
        .mui-progressbar{
        height: 10px;
        }
        .mui-progressbar span{
        background: #fe6b14;
        }
        .btnobt{
        text-align: center;
        margin-top: 25px;
        margin-left: -15px;
        }
        .btnobt button{
        margin-left: 15px;
        }


       .ativer{
            background: url(/static/images/brnW.png) 0% 0% / 100% 100% no-repeat;
            color:#fff;
      }

</style>
      <div id="code">
         <div class="header">
              <p>登记配置</p>
        </div> 
        <!-- <p><span class='name'>设备品牌：<span id="BrandName" style="color:#999"></span></span></p> -->
        <!-- <p><span  class='name'>商品型号：<span id="GoodsName" style="color:#999"></span></span></p> -->
        <!-- <div style="clear:both "> </div> -->
    </div>

     <div>
         <p class="bgt">请在机器上扫码激活</p>
   </div>
    <div><p class="code_bg"> <img id="barcode"src=''/></p></div>
   <div style="clear:both ; padding: 20px;"> 
        <div id="demo1" class="mui-progressbar">
          <span></span>
        </div>
   </div>
     <div style="   position: relative;padding:0 15px;">
        <p style="float:left   ; color: #FF662E;"><span class='Time'>0</span>秒激活中</p>
        <p style="float:right;"><span  class='name'>若超过<span style=" color: #FF662E;"> 120s</span>未激活，请重新扫码</p>
        <div style="clear:both "> </div>
     </div>
  <p style="width:120px;"  class="bgt2"   id="take_photo" >拍摄租凭单<span id="take_photo_time">10s</span></p>
</script>


<script  type="text/html" charset="utf-8"  id="equipment_Html">

  <style type="text/css" media="screen">
    #distanceLabel{
color: #313131;
    /* padding-right: 31px; */
    background: url(/static/images2/Group9.png) no-repeat;
    background-position: 0;
    background-size: 26px 26px;

    height: 30px;
    line-height: 30px;
    text-indent: 20px;
    padding-left: 10px;
    font-weight: bold;
    }

    .agent_list li {
    height: 139px;
    border-top: 1px solid #e8e8e8;
    border-bottom: 1px solid #e8e8e8;
    position: relative;
    padding-bottom: 14px;
    padding-top: 14px;
}.agent_icon {
    height: 110px;
    width: 85px;
    position: absolute;
    left: 28px;top: 24px;
}.item_right {
    position: absolute;
    left: 125px;
    top: 35px;
    width: calc(100% - 140px);
}
.title{
  font-size:9px;   font-weight: bold;
 color:#313131;    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.title_top{
    font-size:12px;
}
.title span{
   font-weight: 400; color:#666
}
   .searchInit{
font-size: 12px;
     line-height: 6px;
    height: 6px;
    float: right;
    border: none;
    color: #FA6B38;
    background-color: transparent;
    border-radius: 900px;
    border: 1px solid rgba(250,107,56,1);
      
    }
    .searchInit:active {
            background-color: #fff;
        }
  .title_body{
        background: url(/static/images2/device.png) no-repeat;
      background-position: 0;
     background-size: 15px 15px;
     text-indent: 20px
  }

  .title_foort{
      background: url(/static/images2/repertory.png) no-repeat;
      background-position: 0;
      background-size: 15px 15px;
       text-indent: 20px
  }
  </style>
      <div style="overflow: auto;">
         
         <div id='list_container' style="padding:20px;    padding-bottom: 0;">
           <div id="distanceLabel">
                  请选择要登记的设备
           </div>
         </div>

         <ul class='agent_list'  style="padding:0px">
           <li>
              <img src="http://image1.ebopark.com/o_1cavqi6e6137oqtihv17em1pqb11.jpg" class="agent_icon">  
               <div class="item_right">   
                  <p class="title title_top"><span>金康</span><button type="button" class="searchInit" data=1>选择</button></p>   
                  <p class="title title_body" style="">设备名称：<span>44444</span></p>   
                  <p class="title title_foort" style="">库存数量：<span>44444</span></p>   
        <!--          <div style="width:100%;height: 20px;"> 
                    <div style="width:100%;height: 3px;background-color: #F2F2F2; border-radius: 2px;overflow: hidden;">
                        <p style="background-color: #f00;height: 5px;width: 50%"></p>
                    </div>
                    <div style="width:100%;height: 15px;"> 
                        <p style="float: left">紧张</p>
                        <p style="float: right">充足</p>
                    </div>
                 </div> -->
              </div>
              <icon class="org_sear_icon loc_icon_pos"></icon>
          </li>

         </ul>
     
      </div>
</script>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jsbarcode/3.5.8/barcodes/JsBarcode.code128.min.js"></script>
<script type="text/javascript" src="/static/js/layer.mobile-v2.0/layer_mobile/layer.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=riGCh76icYkT3OXnxPnNEvB54F3ADvzB"></script>
<script type="text/javascript" src="/static/js/mui.js" ></script>
<script type="text/javascript" src="/static/js/common.js" ></script>
<script src="https://res.wx.qq.com/open/js/jweixin-1.1.0.js"> </script> 
<script>


var  $use_type=  <?=json_encode($use_type)?>;
// console.log($use_type)
var  $Adata=  <?=json_encode($Adata)?>;
var  $saoma_data=  <?=json_encode($saoma_data)?>;
var  $agent_address=  <?=json_encode($agent_address)?>;
var  $csrf=  <?=json_encode($csrf)?>;
// console.log( $agent_address)
var phone='';
var lat;
var lng;
var vcode_register='';

var goodsid='36';
var brandid='4e4908505b89ae3eae99e0e8041a5307';
 var scanningIndex =0;
    var accountObj ={
       tel:'',
        CustomerType:'1',
        UseType:'1',
        codes_str:'',
        pay_type:'1',
        '_csrf':$csrf
    };

 $.get('/index.php/agent/stock-dev', function(data) {
    if(typeof(data)=='string'){
      data=  jQuery.parseJSON(data);
    }

    console.log(data)
   if(data.state==-1){
      //询问框
      layer.open({
        content:data.msg
        ,shadeClose:false
        ,btn: ['确定']
        ,yes: function(index){
             layer.closeAll();
          location.href="/index.php/agent/index";
        }
      });
   }
if(data.state==0){

if(data.datas.length>1){
//       // //页面层
  layer.open({
        type: 1
        ,content:$("#equipment_Html").html()
        ,anim: 'up'

        ,style: 'position:fixed; bottom:0; left:0; width: 100%;  padding:10px 0; border:none;height:100%;overflow:auto'
  });
}else if(data.datas.length==1){
      brandid = data.datas[0].brand_id
      goodsid =  data.datas[0].goods_id
      var  thie =  data.datas[0].GoodsName
      var  stock = data.datas[0].stock_id
      $("#BrandGoods").val(thie).attr('data',stock);
}else{
//    //询问框
      layer.open({
        content:"库存不足"
        ,btn: ['确定']
        ,yes: function(index){
            layer.closeAll();
           location.href="/index.php/agent/index";
        }
      });
}
  $(".agent_list").empty()
   for(var i=0;i<data.datas.length;i++){
      var item = data.datas[i];
      // console.log(item);
        var html = '<li>';



           var image =   item.goods_image1;
          console.log(image);
          if(image){
             if(image.indexOf("7xpcl7.com2.z0.glb.qiniucdn.com")!= -1 ){
             image =  image.replace('7xpcl7.com2.z0.glb.qiniucdn.com', 'image1.ebopark.com');
           }
         }
          

          html+='<img src="'+image+'" class="agent_icon">'



          html+='<div class="item_right">'
          html+=' <p class="title title_top"><span  data="'+item.brand_id+'">'+item.BrandName+'</span><button type="btn" class="mui-btn mui-btn-danger mui-btn-outlined searchInit" data=1>选择</button></p> '
          html += '<p class="title title_body" style="">设备名称：<span  data="'+item.goods_id+'">'+item.GoodsName+'</span></p>  '; 
          html += '<p class="title title_foort" style="">库存数量：<span  data="'+item.stock_id+'">'+item.stock+'</span></p> '; 
          // html += '<div style="width:100%;height: 20px;"> '; 
      
 
          // html += '<p style="float: left">紧张</p>'; 
          // html += '<p style="float: right">充足</p>';
          html += ' </div>';
          html += ' <icon class="org_sear_icon loc_icon_pos"></icon>';
          html += '</li>';
          $(".agent_list").append(html)
      // BrandGoods
   }


$(".searchInit").click(function(){
     var  thie = $(this).parents('li').find('.title_body').find('span').text()
     var  stock = $(this).parents('li').find('.title_foort').find('span').text()
     var  stock_id =  $(this).parents('li').find('.title_foort').find('span').attr('data')||'';

     // console.log(thie)
     // console.log(stock_id)
 if(stock<1){
//       //询问框
      layer.open({
        content:"库存不足"
        ,btn: ['确定']
        ,yes: function(index){
            layer.closeAll();
           location.href="/index.php/agent/index";
        }
      });
   }else{
      brandid = $(this).parents('li').find('.title_top').find('span').attr('data')||'';
      goodsid = $(this).parents('li').find('.title_body').find('span').attr('data')||'';
      var stock = $(this).parents('li').find('.title_foort').find('span').attr('data')||'';
      $("#BrandGoods").val(thie).attr('data',stock);
         layer.closeAll();
   }

})
}
// console.log(data)
});




</script>
<script type="text/javascript" src="/static/js/new-register/new-register.js?v=4.1"></script>
<script>
$(function(){
  mui('.mui-slider').slider().stopped = true; 
  // mui('.mui-slider').slider().gotoItem(1);
    circumstanceBtn()
    initGetVcodeBtn()
    use_typeApp ()
    initProvince() 
    //initListener()
    weixin_html()

    $("#Scanned").click(function(){
        var thisAgentId= $(this).attr('AgentId');
        var thisCustomerType= $(this).attr('CustomerType');
        var thisUserId=$(this).attr('UserId');
        if(thisAgentId){
         window.location.href='/index.php/agent/send-water-detail?UserId='+thisUserId+'&CustomerType='+thisCustomerType+'&AgentId='+thisAgentId;
        }else{
           window.location.href='/index.php/agent/send-water';
        }
    });
$("#Continuous_scanning").click(function(){
      var  ativ = $("#complete").attr('ativer');
       if(ativ==0){
            window.location.href='/index.php/agent/index';
       }
      scanningIndex = mui(".mui-slider").slider().getSlideNumber()
       // alert(scanningIndex)
       Scanned_html()
  });
    $("#complete").click(function(){
  // alert(JSON.stringify(accountObj));
   var ativr = $(this).attr('ativer');
   // alert(ativr);
    if(ativr==1){
      // alert(125);
        $(this).attr('ativer',0)
        $.ajax
          ({
          cache: false,
             async: false,
             type: 'POST',
             data:accountObj,
              url: "/index.php/agent/create-water-account",
             success: function (data) {
                var account = data
                // alert(114785)
                // alert(data)

               if(typeof(data)=='string'){
                  account=  jQuery.parseJSON(data);
                }else{
                  account = data;
                };
                if(account.state==-1){
                   mui.toast(account.msg,{ duration:'long', type:'div' }) ;

                 }  else if(account.state==0){
                  //信息框
                layer.open({
                  content: '登记完成'
                  ,btn: '确定'
                   ,shadeClose: false
                  ,anim: 'up'
                  ,yes: function(index){
                       window.location.href='/index.php/agent/index';
                  }
                })
                 }else{
                   mui.toast('异常',{ duration:'long', type:'div' }) ;
                 }
             }
         });
    }else{
        window.location.href='/index.php/agent/index';
    }

    });
})
function Scanned_html(){
        wx.ready(function() {
                        wx.scanQRCode({   
                            needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
                            scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
                            success: function (res) {
                            // var resultStr = res.resultStr;

                            var resultStr=  res.resultStr.split(',')[1];
                            // alert(resultStr)
                            // alert(vcode_register)

                            var infoByCode =  checkTel({'code':resultStr,'DevNo':vcode_register},"/index.php/agent/get-info-by-code");


                             // alert(JSON.stringify(infoByCode))

                            if(infoByCode.state==-1){
                                   // alert(2)
                                    // mui.toast(picture.msg,{ duration:'long', type:'div' }) ;
                                   layer.open({
                                    content: infoByCode.msg
                                      ,btn: '确定'
                                      ,anim: 'up'
                                    });
                                }else{
                                  // alert(3)
                                var date = new Date();
                                var d = date.getFullYear() + "年" + (date.getMonth() + 1) + "月" + date.getDate() + "日" +date.getHours()+ ":" + date.getMinutes()+":"+date.getSeconds();

                              var itemAmount=$("#PhotoBarCode").find(".item").length;
                              var itemAmountIndex = itemAmount*1+1;
                               // alert(itemAmountIndex)
                              var html ='<tr class="item"> <td >';
                                  html+='<div>';
                                  html+='<span>'+itemAmountIndex+'</span>';
                                  html+='</div>';
                                  html+='</td>';
                                  html+='<td >';
                                  html+='<p>品牌：'+infoByCode.info.BrandName+'</p>';
                                  html+='<p>商品名称：'+infoByCode.info.GoodsName+'  </p>';
                                  html+='<p>净含量：'+infoByCode.info.Volume+'L</p>';
                                  html+='<p>'+d+'</p>';
                                  html+='</td>';
                                  html+='</tr>';
                                  $("#PhotoBarCode tbody").prepend(html);
                                   if(itemAmountIndex==1){
                                      accountObj.codes_str=infoByCode.info.Code;
                                   }else{
                                      accountObj.codes_str=accountObj.codes_str+","+infoByCode.info.Code;
                                   }
                                  if(scanningIndex<3)
                                      mui('.mui-slider').slider().gotoItem(2);
                                  }
                            },
                            cancel:function(res){
                            // alert('取消')
                            },
                            fail:function(){
                            // alert('调用失败')
                            }
                        });
                    });
                        wx.error(function(res){
                            // alert(res);
                            // console.log(res)
                            // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
                        });
}





function initListener(province,city,area){
       initProvince() 
      $("#province").val(province)
       initCityOnProvinceChange();
       $("#city").val(city)
       initThree();
       $("#area").val(area)

$("#province").change(function(event) {
  /* Act on the event */
   initCityOnProvinceChange();
});
$("#city").change(function(event) {
  /* Act on the event */
    initThree()
});

}


function weixin_html(){
// 微信环境下
if( is_weixn()){
//定义一些常量
var x_PI = 3.14159265358979324 * 3000.0 / 180.0;
var PI = 3.1415926535897932384626;
var a = 6378245.0;
var ee = 0.00669342162296594323;

function gcj02tobd09(lng, lat) {
    var z = Math.sqrt(lng * lng + lat * lat) + 0.00002 * Math.sin(lat * x_PI);
    var theta = Math.atan2(lat, lng) + 0.000003 * Math.cos(lng * x_PI);
    var bd_lng = z * Math.cos(theta) + 0.0065;
    var bd_lat = z * Math.sin(theta) + 0.006;
    return [bd_lng, bd_lat]
}
wx.config({  
        debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。  
        appId: $saoma_data.appId,
         timestamp: $saoma_data.timestamp,
            nonceStr: $saoma_data.nonceStr,
            signature: $saoma_data.signature,//签名
            jsApiList: [ 'onMenuShareAppMessage', 'onMenuShareTimeline', 'onMenuShareQQ', 'onMenuShareWeibo', 'getLocation', 'openLocation','scanQRCode'
         ,"chooseImage", "previewImage", "uploadImage", "downloadImage"] 
   });
  wx.ready(function () {
      wx.getLocation({
        type: 'gcj02', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
        success: function (res) {
               var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
              var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
              var speed = res.speed; // 速度，以米/每秒计
              var accuracy = res.accuracy; // 位置精度
              // console.log(latitude)
                // alert(longitude+0.09154+'=>'+latitud+0.003184)
                var ouer =gcj02tobd09(longitude,latitude)
                lat=ouer[1];
                lng=ouer[0];
              // 创建地理编码实例      
                      var myGeo = new BMap.Geocoder();      
                     // 根据坐标得到地址描述    

                  myGeo.getLocation(new BMap.Point(lng, lat), function(result){      
                    if (result){      
                        // console.log(result) 
                        //  initProvince() 
                        // $("#province").val(result.addressComponents.province)
                        //  initCityOnProvinceChange();
                        //  $("#city").val(result.addressComponents.city)
                        //  initThree();
                        //  $("#area").val(result.addressComponents.district)


                         initListener(result.addressComponents.province,result.addressComponents.city,result.addressComponents.district)

                        // $("#content").text(result.address)
                    }      
                });
        },
        cancel: function (res) {
            initListener($agent_address.Province,$agent_address.City,$agent_address.Area);
            lat=$agent_address.BaiDuLat;
            lng=$agent_address.BaiDuLng;

          },
          fail: function (res) {
            initListener($agent_address.Province,$agent_address.City,$agent_address.Area);
            lat=$agent_address.BaiDuLat;
            lng=$agent_address.BaiDuLng;          }
      })
  })
}else{
  initListener($agent_address.Province,$agent_address.City,$agent_address.Area);
      lat=$agent_address.BaiDuLat;
      lng=$agent_address.BaiDuLng;
  }
}

// 地图点击
$("#openMark").on('click',function(){
   // alert(4)
    //页面层
    layer.open({
        type: 1
        ,content:$('#mark_html').html()
        ,anim: 'up'
        ,style: 'position:fixed; bottom:0; left:0; width: 100%; height: 200px; padding:10px 0; border:none;height:100%;'
    });



mui(".mui-table-view").on('tap','.mui-table-view-cell',function(){
  // alert(4)
  lat = $(this).attr("datalat");
  lng = $(this).attr("datalng");
  var _thisVal = $(this).find(".name").text();
  var _thisValprovince = $(this).find(".province").text();
  // console.log(_thisValprovince);


 var appProv = '';
if(_thisValprovince!=''){
    appProv=_thisValprovince

 }
 if(_thisVal!=''){
     if(_thisValprovince==''){

       appProv=_thisValprovince+','+_thisVal;
     }else{
      appProv=_thisValprovince+_thisVal;
     }

 }
 $("#content").text(appProv)

  layer.closeAll()
})

$(".close").click(function(){
  layer.closeAll()
})

// addressClick()
var map = new BMap.Map("allmap");
var point = new BMap.Point(lng,lat);
map.centerAndZoom(point,16);
map.enableScrollWheelZoom(); 
var geolocation = new BMap.Geolocation();
var marker  = new BMap.Marker(point)
map.clearOverlays();
map.addOverlay(marker);
var geoc = new BMap.Geocoder();  
// console.log(point)
getLocationA(point)
// 移动后
 map.addEventListener('moveend',function(){
    // console.log(5)
    // alert("当前地图中心点：" + map.getCenter().lng + "," + map.getCenter().lat);
     point =  new BMap.Point( map.getCenter().lng, map.getCenter().lat);
       map.addOverlay(new BMap.Marker(point));
       $(".tagging").hide()
      getLocationA(point)
 })


// 移动中
  map.addEventListener('ondragging', function(){
              $(".tagging").show()
             map.clearOverlays();
    });

  $("#searchBtn").click(function(){
       // alert(4)
       var _val = $(".search").val();
        getPointA(_val)

  })
function getPointA(address){
 if(address){
  
    var options = {      
    onSearchComplete: function(results){     

    // console.log(results) 

        if (local.getStatus() == BMAP_STATUS_SUCCESS){      
            // 判断状态是否正确      
            var s = [];  
            for (var i = 0; i < results.getCurrentNumPois(); i ++){      
                s.push(results.getPoi(i)); 
            }      
          if(s.length){
            map.centerAndZoom(s[0].point,16);
               $("#muiList").empty()
          for(var i=0;i<s.length;i++){
               var item =  s[i];
                var html = '<li class="mui-table-view-cell mui-media"     datalat = "'+item.point.lat +'"  datalng = "'+item.point.lng +' ">';
                    html+='  <a href="javascript:;">';
                    html+='  <img class="mui-media-object mui-pull-left" style="width:20px;height: initial;    margin-top: 10px;" src="/static/images/loc_icon.png">';
                    html+='  <div class="mui-media-body">';
                    html+='  <span  class="name">'+item.title +'</span> ';
                    html+='  <p class="mui-ellipsis province">'+item.address +'</p>';
                    html+='  </div>';
                    html+='  </a>';
                    html+='  </li>';
                $("#muiList").append(html)
        }
        // addressClick()

     }else{
      alert('没有搜索到位置')
     }
        }   else{
          alert('没有搜索到位置')
        }   
    }      
   };   
var local = new BMap.LocalSearch(map, options);  
    local.search(address);
}

}

})


</script>
<!-- <script type="text/javascript" src="/static/js/agent/register.js" ></script> -->
</body>
</html>