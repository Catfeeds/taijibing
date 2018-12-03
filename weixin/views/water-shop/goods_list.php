<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>太极兵订水门店</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="http://image.ebopark.com/wx/static/coderlu.css"/>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=FCBpETlN4Snp2SfEl92y89WF"></script>
    <script type="text/javascript" src="http://developer.baidu.com/map/jsdemo/demo/convertor.js"></script>
</head>
<style type="text/css">
         #content{
            width:100%;
            height:100%;
            overflow: hidden;
            position:absolute;
        }


     .header{
            width:100%;
            height:144px;
            background-image: url(/static/images/background.png);
            background-position:center;
            background-size: 100% 144px;
        }
       
      .header_content{
            height:144px;
            width:
        }
        .header_p_icon{
            height:100px;width:100px;position:absolute;top:22px;
            border-radius: 72px;
            left:10px;
        }
        .container{
            width:100%;
             height: calc(100% - 144px);
            position: relative;
        }
         .agent_address{
            color: #fff;line-height: inherit;font-size:13px;overflow: hidden;
            margin-top:21px;
        }
        .header_right{
            position: absolute;left:130px;top:18px;
        }

        .Catalog{
            border-top:5px solid #f3f3f3;

        }
        .list{
       width: 33.3%;
    float: left;
    padding: 10px;
    text-align: center;
        }
                .container_left{
            position: absolute;
            top:0px;
             left:0px;
                width:70px;
                bottom:0px;
            background: #f8f8f8;
        }
              .tab_list li{
            height:54px;
            position:relative;
            text-align: center;
            line-height:54px;
            border-bottom: 1px solid #e9e9e9;
            font-size:14px;

        }
        .tab_list .selected{
            background:white;
        }
        .tab_list .unselected{
            background:#f8f8f8;
        }
                .container_right{
            position:absolute;
             left: 75px;
            right:0px;
            bottom:0px;
            top:144px;
            padding-right:10px;
            padding-bottom:80px;
            top:0px;
            background:white;
            height: 100%;
        }
                 .container_right_content{
            width:100%;
            height:100%;
            background:white;
            overflow: auto;
        }
        .list_container{
            height:80px;
            width:100%;
            position:relative;
        }
        .list_c_right{
            position:absolute;
            left:90px;
        }
                .buy_bnt{
     position: absolute;
    right: 0px;
    width: 50px;
    height: 25px;
    font-size: 13px;
    display: inline-block;
    background: #ff4e00;
    color: white;
    line-height: 25px;
    text-align: center;
    border-radius: 8px;
    top: 25px;
    right: 0px;
        }
    .goods_ul li{
    height:110px;
    border-bottom: 1px solid #e9e9e9;
    padding-top:15px;
    overflow: auto;
    background:white;
    }
    .goods_title{
    font-size:15px;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 1;
    overflow: hidden;
    }
    .tab_menu_item{
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 1;
    overflow: hidden;
    }
    .layui-m-layerbtn span[yes]{
    font-size: 25px;
    }
      .agent_contact{
      font-size: 12px;
      color: #fff
    }
.list img{
            width:70%;
        }

</style>
<body>
 <div id="content">
  <div class="header">
        <img src="" class="header_p_icon"/>
        <div class="header_right">
            <p style="color: #fff;font-size:18px;"><?=$agent_info[0]['shop_name']?></p>
            <p class="agent_address">地址：<?=$agent_info[0]['Address']?></p>
            <p class="agent_contact">简介：<?=$agent_info[0]['shop_detail']?></p>
            <p class="agent_contact">营业时间：<?=$agent_info[0]['morning'] ?>-<?=$agent_info[0]['night']?></p></p>
        </div>
    </div>
    <div class="conter" style='    position: relative;height: 100%;width: 100%;'>
           <div class="Catalog"  id="item_list">
                <a href="javascript:void(0)"> <div class="list"  data="1">
                      <img src="/static/images/Catalog-01.png" >
                      <p>天然好水</p>
                 </div>
               </a>

              <a href="javascript:void(0)"><div class="list"  data="2">
                    <img src="/static/images/Catalog-02.png" >
                        <p>茶吧机</p></div>
                   </div>
              </a>

        <!--          
                    <div class="list"  tyle="0">
                            <img src="/static/images/Catalog-03.png">
                          <p>茶叶</p>
                     </div>  
               

                  <p  style="clear:both"></p>
                   <div class="Catalog"><div>
                  <div class="list" tyle="0">
                        <img src="/static/images/Catalog-04.png" >
                      <p>母婴</p>
                 </div>
                 <div class="list"  tyle="0">
                        <img src="/static/images/Catalog-05.png" >
                      <p>生活服务</p>
                 </div>
                 <div class="list"  tyle="0">
                      <img src="/static/images/Catalog-06.png" >
                      <p>蓉城生活</p>
                 </div>
                 
-->

                  <p  style="clear:both"></p>
           </div>
    </div>
</div>
</body>


<script src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/layer.mobile-v2.0/layer_mobile/layer.js"></script>
<script type="text/javascript">
    $(function(){


      var agent_info =    <?=json_encode($agent_info) ?>;
      var datas_type1 =    JSON.parse( <?=json_encode($datas_type1) ?>);
      var agent_id =     JSON.parse( <?=json_encode($agent_id) ?>);
console.log(datas_type1)
   var image=agent_info[0].image1;
           if(agent_info[0].image1.indexOf("7xpcl7.com2.z0.glb.qiniucdn.com") != -1 ){
             image = agent_info[0].image1.replace('7xpcl7.com2.z0.glb.qiniucdn.com', 'image1.ebopark.com');
           }

  console.log(agent_info[0].image1)
      $(".header_p_icon").attr('src',image)
    if(datas_type1.length){
        var html='';
    $("#item_list").empty()
     for(var i=0;i<datas_type1.length;i++){
          for(var z in datas_type1[i]){
                  if(datas_type1[i][z]==null){
                    datas_type1[i][z]='其它'
              } 
          }
          html += '<a href="javascript:void(0)"> <div class="list" data ='+datas_type1[i].Id+' >'
          html+='<img src="/static/images/Catalog-0'+(i+1)+'.png" width="100%">'        
          html+='<p>'+datas_type1[i].FirstMenu+'</p>'
          html+='</div></a>';
          if((i+1)%3==0){
               html+='      <p  style="clear:both"></p><div>  <div class="Catalog">';
          }
        // $(html)appendTo('#item_list')
     }
       $("#item_list").append(html)
  }else{
    var html = '<div id="conter" style="padding-bottom: 50px;width: 100%;position: relative;">'  ;
        html+='<div class="empty_goods">'  ;
        html+='<div style="width:110px;margin:0 auto;margin-top:60px;">'  ;
        html+=' <p style="text-align:center;font-size:25px;color:#000;margin-bottom:10px;">暂无商品</p>'  ;
        html+=  '<img src="/static/images/empty_goods.png" style="width:110px;height:auto;"/>'  ;
        html+='</div>'  ;
        html+=' </div>'  ;
        html+='<div  id="imgUrl" style="margin-top:0px">'  ;
        html+='</div>'  ;
        html+='</div>'  ;

$("#item_list").html(html)
}
$(".list").click(function(){
 // $(this).css({'background-color':'rgba(0,0,0,.3)',"border-radius":'5px;'})
         var _src =   $("img",this).attr('src');
        // console.log(_src)
        var _srcName = _src.split(".")[0].split("-")[0];
        var _srcName1 = _src.split(".")[0].split("-")[1];
        // console.log(_srcName)
        // console.log(_srcName1.length)
        if(_srcName1.length==2){
           var src = _srcName+'-0'+_srcName1+'.png';
         }else{
           var src = _srcName+'-'+_srcName1+'.png';
         }
       // $("img",this).attr('src',src);
       var _data = $(this).attr('data');
          if(Number(_data)*1){
             location.href='second-menu?id='+agent_id+'&category1_id='+_data;
          }else{
            conter();
          }
          // $(this).css({'background-color':'none',"border-radius":'5px'})
      });
function conter(){
        var html = '<div id="conter" style="padding-bottom: 50px;width: 100%;position: relative;">'  ;
        html+='<div class="empty_goods">'  ;
        html+='<div style="width:110px;margin:0 auto;margin-top:60px;">'  ;
        html+=' <p style="text-align:center;font-size:25px;color:#000;margin-bottom:10px;width: 200px;margin-left: -35px;line-height: 35px;">敬请期待！</p>'  ;
        html+=  '<img src="/static/images/empty_goods.png" style="width:110px;height:auto;"/>'  ;
        html+='</div>'  ;
        html+=' </div>'  ;
        html+='<div  id="imgUrl" style="margin-top:0px">'  ;
        html+='</div>'  ;
        html+='</div>'  ;
// console.log()
// $(".conter").html(html)

 //信息框
  layer.open({
    content: html
    ,btn: '确定'
  });
}


    goDownload();   
    // 去下载 
    function goDownload() {   


    var u = navigator.userAgent, app = navigator.appVersion;

    console.log(u)

    var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Linux') > -1;  
      var isIOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);

    // 是PC端    
       if (IsPC()) {   
        
        } 

    // 是安卓浏览器     
    if (isAndroid) { 
   
    //   window.location.href = 'http://xxxxxxx.cn/release/xxxx-release.apk'; // 跳安卓端下载地址   
       }      
    // //   // 是iOS浏览器  
    var num = 1    
    if (isIOS) {
// location.replace(document.referrer);
        
    // 跳AppStore下载地址    
    }
    // // 是微信内部webView   
    if (is_weixn()) {    
        // location.reload() 
    } 
    // // 是PC端  
    // if (IsPC()) {   
    //  window.location.href = 'http://www.xxxxxxx.cn/index.html'; 
    //  // 公司主页     
    //  }    
    // }     
    }

     // 是PC端  
    function IsPC() {
      var userAgentInfo = navigator.userAgent;   
      var Agents = ["Android", "iPhone",        "SymbianOS", "Windows Phone",        "iPad", "iPod"];    
      var flag = true;   
      for (var v = 0; v < Agents.length; v++) {   
        if (userAgentInfo.indexOf(Agents[v]) > 0) {  
          flag = false;         
          break;    
        }     
      }      
      return flag;  

     } 



  // 是微信浏览器   
    function is_weixn(){  
      var ua = navigator.userAgent.toLowerCase();  
        if(ua.match(/MicroMessenger/i)=="micromessenger") {  
          return true;   
         }
        else {     
        return false;   
        }  
    }   


  function IsPC() {   
    var userAgentInfo = navigator.userAgent;  
    var Agents = ["Android", "iPhone", "SymbianOS", "Windows Phone","iPad", "iPod"];     
    var flag = true;     
    for (var v = 0; v < Agents.length; v++) {    
      if (userAgentInfo.indexOf(Agents[v]) > 0) {
        flag = false;     
        break;   
      }    
    }    

  return flag;
}













    })

</script>
</html>