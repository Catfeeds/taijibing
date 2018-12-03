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
        <link rel="stylesheet" href="/static/css/index52.css"/>
    <title>设备列表</title>
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
        top: 0px;
        height: 41px;
        border-bottom: 1px solid #f3f3f3;    font-weight: bold;
        }
        .table-hr   .table_header {
        	height:40px;  width: 23%;
        	line-height:40px;
          font-size: 12px
        }
        body{
          background:#f3f3f3;
        }
        .red_line{
            background:white;
            border:1px solid #f3f3f3;
            border-radius: 4px;height:80px;
            margin-top:10px;
            line-height:80px;
        }
        .blud_line {
            background: white;
            border: 1px solid #f3f3f3;
            border-radius: 4px;

            line-height: 80px;
        }
        .red_line {
            background: white;
            border: 1px solid #f3f3f3;
            border-radius: 4px;
            height: 80px;
        }
        .wrapper li{
          position: relative;
        }

        
        .search{
          text-align: center;padding:10px;height: 50px;background: #f3f3f3;
        }
        .search input {
          height: 30px;
           border-top-left-radius: 10px;
           border-radius: 10px;text-indent: 10px;
           border: none;
        }
        /* .search button{
        height: 30px;      width: 50px;
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;border: none;border-bottom: 3px solid #dddddd;
        }*/
      .picView-magnify-list li{
          width: 190px;
        }

    </style>
</head>
<body>
<div class="form">
    <div class="table-hr">
      <div class='search'>
 <label><input type="text" name="" value=""  placeholder="请输入用户名/电话"></label>
</div>
        <p style="background:white;border-bottom: solid 10px #f3f3f3;"><span class="table_header total_num" style="width: 8%;">0</span><span class="table_header">用户姓名</span><span class="table_header">设备编号</span><span class="table_header">设备状态</span><span class="table_header">租赁单</span></p>
    </div>
    <div class="table_bd" style="margin-top:100px;">
     <!--    <p class="red_line"><span class="table_header">小黄</span><span class="table_header">1366126875</span><span class="table_header">2017-15-15  12:20:34</span><span class="table_header">已登记</span></p> -->

    </div>
</div>


</body>
<script type="text/javascript" src="/static/js/zepto.min.js"></script>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/layer.mobile-v2.0/layer_mobile/layer.js"></script>
<script type="text/javascript" src="/static/js/coderlu.js"></script>
<script type="text/javascript" src="/static/js/common.js" ></script>
 <script type="text/javascript" src="/static/js/index.js"></script>
  <script type="text/javascript" src="/static/js/jquery.rotate.min.js"></script>
<script src="https://res.wx.qq.com/open/js/jweixin-1.1.0.js"> </script> 
<script>
 var data=<?=json_encode($data)?>;
   var image_state=<?=json_encode($image_state)?>;

   var $saoma_data=<?=json_encode($saoma_data)?>;

   
$(function(){
   var res=<?=json_encode($data)?>;
   var image_state=<?=json_encode($image_state)?>;
   var $saoma_data=<?=json_encode($saoma_data)?>;
	 var is_search=<?=json_encode($is_search)?>;
  var   dataNo= JSON.parse(image_state);

  var info = JSON.parse(sessionStorage.getItem('info'));


console.log(res)
  if($saoma_data.appId){
    wx.config({  
        debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。  
        appId: $saoma_data.appId,
         timestamp: $saoma_data.timestamp,
            nonceStr: $saoma_data.nonceStr,
            signature: $saoma_data.signature,//签名
            jsApiList: ["chooseImage","uploadImage"] 
   });
  }
// console.log($saoma_data);
if(res.state!=0){
          return;
}
    var list=res.result;

    if(is_search){
      console.log(is_search)  

      var obj_list = [];

      $.each(list, function(index, item){   
           // console.log( );  // true
          if(item.name.indexOf(is_search) != -1) {
            // console.log(item) 
                 obj_list.push(item)
          }else if(item.Tel.indexOf(is_search) != -1) {
            // console.log(item) 
                 obj_list.push(item)
          }
       }); 
    data_init(obj_list);
    }else{
      data_init(list)  
    }
$('.search input').on('input propertychange', function() {
         var searchVal = $(".search input").val();
         var test = window.location.href;
         console.log(searchVal)
      var obj_list = [];
      $.each(list, function(index, item){   
           // console.log( );  // true
          if(item.name.indexOf(searchVal) != -1) {
            // console.log(item) 
                 obj_list.push(item)
          }else if(item.Tel.indexOf(searchVal) != -1) {
            // console.log(item) 
                 obj_list.push(item)
          }
       }); 
    data_init(obj_list);

         // if(searchVal){
         //      if(test.indexOf("is_search")>0){
         //           var init = test.split("is_search")[0];
         //   // console.log(init)
         //             location.href=init+"is_search="+searchVal;
         //            // return;
         //        }else{
         //             // alert(infostrimg)
         //             location.href=test+"?is_search="+searchVal;
         //        }
         // }else{
         //     var init = test.split("?")[0];
         //       location.href=init;
         // };
    });

function data_init(list){
    $(".table_bd").empty();
      var total_num=0;
       $(".total_num").text(list.length)
       if(info.Level==5){
              for(var index=0;index<list.length;index++){
              var item=list[index];
                 // console.log(item);
              var mobile=item.mobile;
              var state = dataNo[item.mobile];
           

               // console.log(state);
              var  state_html='';
              if(state){
                var stateString = dataNo[item.mobile].DevNo;
                var Tel = dataNo[item.mobile].Tel;
                var TempImage = dataNo[item.mobile].TempImage;
                var Image = dataNo[item.mobile].Image;
                 if(state.ImageState==1){
                   state_html='<span class="empty"  onclick="noConfirm(this,&quot;'+stateString +'&quot;,&quot;'+TempImage +'&quot;,&quot;'+Image +'&quot;,&quot;'+state.ImageState +'&quot;,&quot;'+item.name +'&quot;,&quot;'+state.ImageErrorReason +'&quot;,&quot;'+Tel +'&quot;)"><a  style="color:#000">待确认</a></span>';
                  }
                  else if(state.ImageState==2){
                         state_html='<span class="confirm"  style="color: #00ff08;"  onclick="noConfirm(this,&quot;'+stateString +'&quot;,&quot;'+TempImage +'&quot;,&quot;'+Image +'&quot;,&quot;'+state.ImageState +'&quot;,&quot;'+item.name +'&quot;,&quot;'+state.ImageErrorReason +'&quot;,&quot;'+Tel +'&quot;)">已确认</span>'
                  }else if(state.ImageState==3){
                         state_html='<span class="confirm"   style="color: red;" onclick="noConfirm(this,&quot;'+stateString +'&quot;,&quot;'+TempImage +'&quot;,&quot;'+Image +'&quot;,&quot;'+state.ImageState +'&quot;,&quot;'+item.name +'&quot;,&quot;'+state.ImageErrorReason +'&quot;,&quot;'+Tel +'&quot;)">未通过</span>'
                  }else{
                     state_html='<span class="empty"   onclick="showDetail(this,&quot;'+stateString +'&quot;,&quot;'+TempImage +'&quot;,&quot;'+Image +'&quot;,&quot;'+state.ImageState +'&quot;,&quot;'+item.name +'&quot;,&quot;'+state.ImageErrorReason +'&quot;)"><a   style="color:#337ab7" >未上传</a></span>';
                  };
              };
              var tString = mobile.substr(3);
              var mobile = mobile.replace(tString, "****")
              var mobile = mobile.replace(tString, "****")
              // console.log(mobile)
             if(item.type!='初始化'){
                total_num++
               var tr=' <p class="table_tr '+(index%2==0?"blud_line":"red_line")+'"><span  class="table_header" style="width:8%">'+total_num+'</span><span class="table_header">'+item.name+'</span><span class="table_header">'+mobile+'</span><span class="table_header state"    style="color:'+getColorBywatervl(item.type)+'" >'+getTime22(item.type)+'</span><span class="table_header">'+state_html+'</span></p>';
               $(".table_bd").append($(tr));
              }
          }
        }else{
          for(var index=0;index<list.length;index++){
             var item=list[index];
              var mobileile=item.mobile;
              var tString = mobile.substr(3);
              var mobile = mobile.replace(tString, "****")
              // console.log(mobile)
             if(item.type!='初始化'){
                total_num++
               var tr=' <p class="table_tr '+(index%2==0?"blud_line":"red_line")+'"><span  class="table_header" style="width:8%">'+total_num+'</span><span class="table_header">'+item.name+'</span><span class="table_header">'+mobile+'</span><span class="table_header">'+item.interval+'</span><span class="table_header state"    style="color:'+getColorBywatervl(item.type)+'" >'+getTime22(item.type)+'</span></p>';
               $(".table_bd").append($(tr));
             }
          }
        }
        $(".total_num").text(total_num)
       //$(".search input").val(is_search)

    }

});
// 未确认拍照或者选择照片
function noConfirm(name,DevNo,TempImage,Image,ImageState,itemName ,ImageErrorReason,Tel){
  console.log(name)
  console.log(DevNo)
  console.log(TempImage)
  console.log(Image)
  console.log(ImageState)
  console.log(ImageErrorReason)
  console.log(Tel)
  var html ='<p style="text-align:left">用户姓名：<span>'+itemName+'</span></p><p style="text-align:left">电话：<span>'+Tel+'</span></p><div style="height:200px;overflow:auto">';
  if(ImageState==1){
    // if(TempImage!='null'){
    //     html += '<img src="'+TempImage+'" alt="图片丢失了" style="width:100%">';
    //     html += '<p>补拍图片</p>';
    //     html += '<img src="'+Image+'" alt="图片丢失了" style="width:100%">';
    //     html += '<p>历史图片</p>';
    // }
      html += '<div class="wrapper wrapper-content">'+
                 '<ul class="picView-magnify-list" style="padding: 30px">'+
                     '<li><div class="closeBtn" style="height:20px;position:absolute;top:-25px;right:0px;     line-height: 20px;"> <button type="btn">撤销</button></div><a href="javascript:void(0)" data-magnify="gallery" data-group="g1" data-src="'+TempImage+'"  data-caption="临时补拍">'+
                         ' <img src="'+TempImage+'"> <p>临时补拍</p></a>'+
                     ' </li>';
              if(TempImage!='null'){
                html += '<li><a href="javascript:void(0)" data-magnify="gallery" data-group="g1" data-src="'+Image+'"  data-caption="正式存档">'+
                         ' <img src="'+Image+'"> <p>正式存档</p></a>'+
                     ' </li>';
              }
                 html += '</ul>'+
             '</div>';

  }else if(ImageState==2){
        // html +='<img src="'+Image+'" alt="图片丢失了" style="width:100%">';
              html += '<div class="wrapper wrapper-content">'+
                 '<ul class="picView-magnify-list" style="padding: 30px">'+
                     '<li><a href="javascript:void(0)" data-magnify="gallery" data-group="g1" data-src="'+Image+'"  data-caption="正式存档">'+
                         ' <img src="'+Image+'"> <p>正式存档</p></a>'+
                     ' </li>'+
                 '</ul>'+
             '</div>';
  }else if(ImageState==3){
html ='<p style="text-align:left">用户姓名：<span>'+itemName+'</span></p><p style="text-align:left">电话：<span>'+Tel+'</span></p><p style="text-align:left">未通过原因：<span>'+ImageErrorReason+'</span></p><div style="height:200px;overflow:auto">'
        html += '<div class="wrapper wrapper-content">'+
           '<ul class="picView-magnify-list" style="padding: 30px">'+
               '<li><div class="closeBtn" style="height:20px;position:absolute;top:-25pxpx;right:0px;    line-height: 20px; "> <button type="btn" >撤销</button> </div><a href="javascript:void(0)" data-magnify="gallery" data-group="g1" data-src="'+TempImage+'"  data-caption="临时补拍">'+
                   ' <img src="'+TempImage+'"> <p>临时补拍</p></a>'+
               ' </li>';
               if(TempImage!='null'){
                html += '<li><a href="javascript:void(0)" data-magnify="gallery" data-group="g1" data-src="'+Image+'"  data-caption="正式存档">'+
                         ' <img src="'+Image+'"> <p>正式存档</p></a>'+
                     ' </li>';
              }
            html +='</ul>'+
       '</div>';
  }else{
           html += '<div class="wrapper wrapper-content">'+
                 '<ul class="picView-magnify-list" style="padding: 30px">'+
                     '<li><a href="javascript:void(0)" data-magnify="gallery" data-group="g1" data-src="'+Image+'"  data-caption="正式存档">'+
                         ' <img src="'+Image+'"> <p>正式存档</p></a>'+
                     ' </li>'+
                 '</ul>'+
             '</div>';
  }
       html += '</div>';
    //询问框
    layer.open({
      content: html
      // , style: 'height:60%;overflow:auto;'
      ,btn: ['补拍', '关闭']
      ,yes: function(index){
        showDetail(name,DevNo)
      layer.close(index);
    }
    });


     $(".closeBtn").click(function(){
          console.log(DevNo)
             $.get('/index.php/agent/go-back',{'DevNo':DevNo},function(data){
                        // console.log(pictureObj)
                        // alert(data)
                          var data=data;
                           if(typeof(data)=='string'){
                            data=  jQuery.parseJSON(data);
                          }
                        console.log(data)
                         if(data.state==-1){
                                 layer.msg(data.msg);
                                    return;
                            }else{
                                // layer.msg(data.msg);
                                // layer.close(index);
                                location.reload()
                            }
                    })

        })

    var _width = document.body.clientWidth-50;
    var _height = document.body.clientHeight-100;
    console.log(_height)
    console.log(_width)


}
// 拍照或者选择照片
function showDetail(name,DevNo,TempImage,Image,ImageState,itemName ){
     console.log(name)
     console.log(DevNo)
     // $(name).text(55)
     // var nameClass = $(name).attr('class');
     // //信息框

    var html = '<img src="/static/images/20180815103830.jpg" style="-moz-transform:rotate(-90deg);-webkit-transform:rotate(-90deg);transform:rotate(-90deg);width:100%;"><p style="margin-top:45px">请将租赁单及水卡放在机器屏幕旁，将设备编号一同拍摄清晰，然后上传。</p>' 
      layer.open({
        content: html
        ,btn: '确定'
        ,anim: 'up'
        ,yes: function(index){
           //页面层 
            wx.chooseImage({
                count: 1, // 默认9，这里每次只处理一张照片
                sizeType: ['original', 'compressed'],   // 可以指定是原图还是压缩图，默认二者都有
                sourceType: [ 'camera'],        // 可以指定来源是相册还是相机，默认二者都有
                success: function (res) {
                var  localIds = res.localIds;      // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
                   // $("#PhotoImg").attr('src',localIds)
                      // alert(images.localId );
                     // 上传照片
                        wx.uploadImage({
                            localId: '' + localIds,
                            isShowProgressTips: 1,
                            success: function(res) {
                              var   serverId = res.serverId;


                             
                                     var result = JSON.stringify(res);

                                     // alert(result)


                                // $(obj).next().val(serverId); // 把上传成功后获取的值附上
                                //提示

                                if(serverId){
                                     $.ajax
                                       ({cache: false,
                                           async: false,
                                           type: 'get',
                                           data:{'serverId':serverId,'DevNo':DevNo },
                                           url: "/index.php/agent/save-picture",
                                           success: function (data) {
                                                  // alert(data)
                                            var data=data;
                                      
                                             if(typeof(data)=='string'){
                                                data=  jQuery.parseJSON(data);
                                              }
                                               if(data.state==-1){
                                                   // alert(data.msg)
                                                   layer.open({
                                                    content: data.msg
                                                      ,btn: '确定'
                                                      ,anim: 'up'
                                                    });
                                                    layer.close(index);
                                                }else{
                                                    //提示
                                                      layer.open({
                                                        content: '成功'
                                                        ,skin: 'msg'
                                                        ,time: 2 //2秒后自动关闭
                                                      });
                                                window.location.reload()
                                                }
                                           }
                                       });
                                }
                                  
                            }
                      });
                } 
            });
           layer.close(index);
        }
      });
  
}
   function getTime(_val){
     var val=Number(_val);
      if(val=='已登记'){
         return val+"分钟前";
         }
        var hours=(val/60).toFixed(0);
         if(hours<24){
          return hours+"小时前"
         }
        var days=(hours/24).toFixed(0);
        return days+"天前";
    }
function getTime22(_val){
  console.log(_val)
  var _val=_val;
    if(_val =='未激活'){
    	 return '已登记'
    }
 return _val

    }

  function getColorBywatervl(_val){

                if(_val == '未激活'){
                        return "red";
                  }
                  else if(_val == '预警'){
                    return "#FF9800";
                    
                  }
                  else if(_val == '未联网'){
                     return "#2C0AFA";
           
                  }
                  else if(_val == '正常'){
                     return "#15ED11";
              
                  }
                  else if(_val == '初始化'){
                     return "#101010";
                  
                  }
    }

</script>



</html>