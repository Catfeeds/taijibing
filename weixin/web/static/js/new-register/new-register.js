


// 拍照或者选择照片
function take_a_photo(){
  mui("#demo1").progressbar().hide();
    var html = '<img src="/static/images/20180815103830.jpg" style="-moz-transform:rotate(-90deg);-webkit-transform:rotate(-90deg);transform:rotate(-90deg);width:100%;"><p style="margin-top:35px">请将租赁单及水卡放在机器屏幕旁，将设备编号一同拍摄清晰，然后上传。</p>' 
     //信息框
      layer.open({
        content: html
        ,btn: '确定'
        ,anim: 'up'
        ,yes: function(index){
         
            wx.chooseImage({
                count: 1, // 默认9，这里每次只处理一张照片
                sizeType: ['original', 'compressed'],   // 可以指定是原图还是压缩图，默认二者都有
                sourceType: [ 'camera'],        // 可以指定来源是相册还是相机，默认二者都有
                success: function (res) {
                      var result = JSON.stringify(res);
                   // alert(result)
                    var  localIds = res.localIds;      // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
                     $("#PhotoImg").attr('src',localIds);

                    // alert(localIds)
           //    alert(localIds)
                      // 上传照片
                        wx.uploadImage({
                            localId: '' + localIds,
                            isShowProgressTips: 1,
                            success: function(res) {
                                serverId = res.serverId;
                                var result = JSON.stringify(res);
                                // alert(result)
                              if(serverId){
                                  var picture =  checkTel({'serverId':serverId,'DevNo':vcode_register },"/index.php/agent/save-picture");
                                       // alert(picture.msg)
                                   if(picture.state==-1){
                                     // mui.toast(picture.msg,{ duration:'long', type:'div' }) ;
                                     layer.open({
                                      content: picture.msg
                                        ,btn: '确定'
                                        ,anim: 'up'
                                      });
                                      layer.close(index);
                                    }else{
                                        // picture.image;
                                        // alert(picture.image)
                                      $("#PhotoImg").attr('src',picture.image);
                                       mui('.mui-slider').slider().gotoItem(1)
                                       layer.closeAll()
                                   }
                                }
                            },
                             fail: function (e) {
                                console.log(e);
                                wx.showModal({
                                  title: '提示',
                                  content: '上传失败',
                                  showCancel: false
                                })
                              }
                        });
                  } ,
                  cancel:function(res){
                  alert('取消')
                  },
                  fail:function(){
                   alert('调用失败')
                  }
            });
           layer.close(index);
        }
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
         ] 
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

                // 116.364, 39.993
           // console.log(ouer)

              // 创建地理编码实例      
                      var myGeo = new BMap.Geocoder();      
                     // 根据坐标得到地址描述    

                      myGeo.getLocation(new BMap.Point(lng, lat), function(result){      
                    if (result){      
                        console.log(result) 
                         initProvince() 
                      $("#province").val(result.addressComponents.province)
                         initCityOnProvinceChange();
                         $("#city").val(result.addressComponents.city)
                         initThree();
                         $("#area").val(result.addressComponents.district)
                         $("#content").text(result.address)
                    }      
                });
        }
      })
  })
}
}







// 渲染地图坐标附近
function  getLocationA(point){
   geoc = new BMap.Geocoder();  
          geoc.getLocation(point, function (rs) {

            console.log(rs)
          var addArr = rs.surroundingPois;
          
            $("#muiList").empty()

          if(addArr.length>0){
              for(var i=0;i<addArr.length;i++){
                 var item =  addArr[i];
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
          }else{
                var html = '<li class="mui-table-view-cell mui-media"     datalat = "'+rs.point.lat +'"  datalng = "'+rs.point.lng +' ">';
                    html+='  <a href="javascript:;">';
                    html+='  <img class="mui-media-object mui-pull-left" style="width:20px;height: initial;    margin-top: 10px;" src="/static/images/loc_icon.png">';
                    html+='  <div class="mui-media-body">';
                    html+='  <span  class="name">'+rs.business +'</span> ';
                    html+='  <p class="mui-ellipsis province">'+rs.address +'</p>';
                    html+='  </div>';
                    html+='  </a>';
                    html+='  </li>';
                 $("#muiList").append(html)
          }
        });
}




//开始
function  circumstanceBtn() {
$('.submit').on('click', function(){
// mui(".register").on('tap','.submit',function(){
       if($('.submit').hasClass("ativer")){
          // alert(4)
          $(".submit").removeClass('ativer');
           var opuiuo=  Verification1();

           console.log(opuiuo)
            if(opuiuo.state==1){
                $(".submit").addClass('ativer')
                mui.toast(opuiuo.mag);
                layer.close(loading)  
                // alert(1)
                return false;
            }
            accountObj.tel=opuiuo.datas.Tel;
            accountObj.CustomerType=1;
            accountObj.UseType=opuiuo.datas.UseType;
            accountObj.pay_type=1;

            var loading =  layer.open({
              type: 2
              ,shadeClose:false
              ,content: '加载中'
            });
       
      var tel= TrimAll($('#newTel').val(),"g");
      var  address=TrimAll($("#content").val(),"g");
      var  vcode=TrimAll($("#vcode").val(),"g");
      // 验证是否注册过
       var telNo =  checkTel({'tel':tel,'vcode':vcode},"/index.php/agent/check-vcode")
       console.log(telNo)

      if(telNo.state!=0){
             // alert(JSON.stringify(telNo))
          mui.toast(telNo.msg,{ duration:'long', type:'div' }) 
            layer.close(loading) 

       $(".submit").addClass('ativer')
               // alert(2)
          return false;
      }
        // 验证是地址重复
      var addressNo =  checkTel({'tel':tel,'address':address},"/index.php/agent/check-address-and-tel")
      console.log(addressNo)
      if(addressNo.state!=0){
          mui.toast(addressNo.msg,{ duration:'long', type:'div' }) 
            layer.close(loading)  
            $(".submit").addClass('ativer')
               alert(3)
          return false;
      }
      console.log(opuiuo.datas)
        // 生成设备编号
      var register =  checkTel({'data':opuiuo.datas},"/index.php/agent/save-register");
      console.log(register);

      $("#Scanned").attr('AgentId',register.AgentId);
      $("#Scanned").attr('CustomerType',register.CustomerType);
      $("#Scanned").attr('UserId',register.UserId);
// {state: 0, DevNo: "2810011528", UserId: "bd62672cdc124b71b239c938be67365e", CustomerType: "1", AgentId: "69"}
       // alert("设备编号接口返回："+register.state)
       if(register.state!=0){
          mui.toast(register.msg,{ duration:'long', type:'div' }) 
          layer.close(loading)  
          $(".submit").addClass('ativer')
          alert(4)
          return false;
      }
    vcode_register = register.DevNo;
    console.log(register)

code_Html_layer()
function code_Html_layer(vcode_I){
  var vcodeN=register.DevNo
      //页面层
     var barcode_layer =  layer.open({
            type: 1
            ,content:$("#code_Html").html()
           ,shadeClose:false
            ,anim: 'up'
            ,style: 'position:fixed; bottom:0; left:0; width: 100%; height: 200px; padding:10px 0; border:none;height:100%;'
      });
        if(vcodeN==null){
           alert('无效链接')
       };

         layer.close(loading)  
      var barcode = document.getElementById('barcode'),
           options = {
            format:"CODE128",
            displayValue:true,
            fontSize:18,
            height:100
          };
          // $("#barcode").attr("src",'');

        JsBarcode(barcode, vcodeN, options);//原生

     var Images = $("#barcode").attr("src");
   if(Images){
      $(".code_bg #barcode").attr("src",Images);
    }
     console.log(Images)
     console.log(vcode_I)

       mui("#demo1").progressbar({progress:0}).show();
    var  num =1;
    var numbt = 0.833;
    var take_photo_time=10;
    var timer1= setInterval(getLoc,1000);
        function getLoc(){
          //var timer1=window.setTimeout(function(){},1000);  //timer1->1 当前是第一个定时器
            if(num>120){
                num=120;
                window.clearTimeout(timer1);
                vcodeN_reomover(Images)
                layer.close(barcode_layer);

        
             }else{
              if(numbt<100){
                 mui("#demo1").progressbar().setProgress(numbt);
              }
             
             }

            take_photo_time--;
            if(take_photo_time>0){
               $("#take_photo_time").text(take_photo_time+'s');
             }else{
                $("#take_photo").addClass("ativer");
                $("#take_photo_time").html('');

             }
            
            $(".Time").text(num);
            // console.log(numbt)



            num++
            numbt=numbt+ 0.833;
        }



      $("#take_photo").click(function(){
            if($("#take_photo").hasClass("ativer")){
            //      //询问框
                     layer.open({
                      content: '您确定在机器上扫码了吗？'
                      ,btn: ['确定', '取消']
                      ,shadeClose: false
                      ,yes: function(index){
                        take_a_photo()
                        layer.close(index);
                      },no:function(index){
                          layer.close(index);
                      }
                    });
            }
        })

}
function  vcodeN_reomover(Images){
   //页面层
  var jihuoLay =  layer.open({
        type: 1
        ,content:'<div class="text" style="padding: 0px;text-align:center;margin-top:50%;"><p>激活失败！</p><p>请重新激活/(ㄒoㄒ)/~~</p></div> <div class="btnobt" style="text-align:center"><button type="button" class="mui-btn vcodeN">去激活</button><button type="button" class="mui-btn indexsub">返回主页</button></div>'
        ,anim: 'up'
        ,style: 'position:fixed; bottom:0; left:0; width: 100%; height: 200px; padding:10px 0; border:none;height:100%;'
    });

    $(".indexsub").on('click',function(){
      window.location.href='/index.php/agent/index';
    })
    $(".vcodeN").on('click',function(){
      
       code_Html_layer(Images);
       layer.close(jihuoLay)
      // layer.close(jihuoLay)
    })
}
        $(".submit").removeClass('ativer');
 }
})



      $('input,select,textarea').on('input propertychange', function () {
            var opuiuo=  Verification1();
          if(opuiuo.state==0){
              $(".submit").addClass('ativer')
          }
      })



$('#newTel').blur(function(){
    var _thisa  =$(this).val();
     if(_thisa*1){
      var TelA = insert_item(_thisa," ",3,7)
      $(this).val(TelA)
      initGetVcodeBtn() 
     }else{
      // console.log('TelA')
     }
    
     // if()
}) 

function insert_item(str,item,index,index2){
      var newstr="";             //初始化一个空字符串
      var tmp=str.substring(0,index);
      var estr=str.substring(index,index2);
      var obtr=str.substring(index2,str.length);

      newstr+=tmp+item+estr+item+obtr;

      return newstr;

}










      //绑定手机号码输入框，当内容改变时执行以下代码
      $('#newTel').on('input propertychange', function () {
              var _this  =$(this).val();
              // console.log(_this)
              $("#getCodeBtn").removeClass('ativer');
                if(_this.length==1){
                    if(_this!= 1){
                         mui.toast('输入格式有误',{ duration:'long', type:'div' }) 
                       $(this).val('')
                    }
                }else if(_this.length==2){

                   var   src =   _this.substr(1,1)
                   if(src ==1){
                         mui.toast('输入格式有误',{ duration:'long', type:'div' }) 
                       $(this).val(1)
                    }
                }else if(_this.length>=13){

                

                  if(_this*1){
                     var   src =  _this.substr(0,11)
                     $(this).val(src);
                  }else{
                    var   src =  _this.substr(0,13)
                    $(this).val(src);
                  }
                    

                    $("#getCodeBtn").addClass('ativer')
                }

               $(document).keydown(function (event) {
                        if (event.keyCode == 8 || event.keyCode == 46) {
                              //TODO
                        } 
                         else {
                            if ($('#newTel').val().length == 3 || $('#newTel').val().length == 8) {
                                phone = $('#newTel').val() + " ";
                                $('#newTel').val(phone);
                            }
                      }
                })
      });

}

//结束

// get访问方法
function checkTel(obj,$url){
  var dataNo='';
     $.ajax
       ({cache: false,
           async: false,
           type: 'get',
           data:obj,
           url: $url,
           success: function (data) {

             if(typeof(data)=='string'){
                dataNo=  jQuery.parseJSON(data);
              }else{
                    dataNo = data;
              }
           }
       });

    return dataNo;
}

// 基本数据参数

function Verification1(){
    var  msg = true;
    var  usertype=$("#usertype").val();
    var  username=$("#username").val();
    var  tel=$("#newTel").val();

   var newTel= TrimAll(tel,"g")
    var  vcode=$("#vcode").val();
    var  content=$("#content").val();
    var  province=$("#province").val();
    var  city=$("#city").val();
    var  area=$("#area").val();


var  booleanObj = {
          state:0,
          mag:'',
          datas:{
            'UseType':usertype,
            'Name':username,
            'Tel':newTel,
            'Vcode':vcode,
            'Address':content,
            'Province':province,
            'City':city,
            'area':area,
            'DevBindMobile':tel,
            'customertype':1,
            'lat':lat,
            'lng':lng,
            'stock_id':$("#BrandGoods").attr('data'),
            'CodeNumber':'',
            'RoomNo':'',
            'url':'',
             "goodsid":goodsid,
             "brandid":brandid,
          }
        };

    if(usertype==null||usertype==''||usertype==undefined){
        booleanObj.state = 1;
       booleanObj.mag = '请选择购水套餐';
       return booleanObj;
    }
    if(username==null||username==''||username==undefined){
        booleanObj.state = 1;
       booleanObj.mag = '请输入用户名';
       return booleanObj;
    }
   if(tel==null||tel==''||tel==undefined){
        booleanObj.state = 1;
        booleanObj.mag = '请输入电话号码';
 
       return booleanObj;
    }

  if(tel.length<13){
    console.log('sdasd')
    booleanObj.state = 1;
    booleanObj.mag = '输入的电话号码位数不正确';
    return booleanObj;
  }
  if(vcode==null||vcode==''||vcode==undefined){
        booleanObj.state = 1;
       booleanObj.mag = '请输入验证码';
       return booleanObj;
    }  
   if(province==null||province==''||province==undefined){
       booleanObj.state = 1;
       booleanObj.mag = '请选择省';
       return booleanObj;
    }
   if(city==null||city==''||city==undefined){
       booleanObj.state = 1;
       booleanObj.mag = '请选择市';
       return booleanObj;
    }
   if(area==null||area==''||area==undefined){
       booleanObj.state = 1;
       booleanObj.mag = '请选择区';
       return booleanObj;
    }
   if(content==null||content==''||content==undefined){
       booleanObj.state = 1;
       booleanObj.mag = '请输入详细地址';
       return booleanObj;
    }


return booleanObj;
}
 
//去除字符串中所有的空格
function TrimAll(str, is_global) {
    var result;
    result = str.replace(/(^\s+)|(\s+$)/g, "");
    if (is_global.toLowerCase() == "g") {
        result = result.replace(/\s/g, "");
    }
    return result;
}

// 验证码
function initGetVcodeBtn(){


         $("#getCodeBtn").on("click",function(){
          
           if(!$(this).hasClass("ativer")){
            mui.toast("请输入格式正确的手机号码");
            return false;
           }
              // var tel=$("#newTel").val();
           var tel= TrimAll($('#newTel').val(),"g")
   

            if(!validateTel(tel)){
                 mui.toast("请输入格式正确的手机号码");
                return;
            }
 // alert(tel)

             $.get('/index.php/agent/check-tel?tel='+tel, function(data) {
                    /*optional stuff to do after success */

                     // alert(tel)
                     var data=  jQuery.parseJSON(data);
                        console.log(data)
                        if(data.state<0){
                          mui.toast(data.msg);
                         return false;
                        }


                      $.getJSON('/index.php/agent/get-vcode?tel='+tel,function(data){

                          if(data.state!=0){
                             

                              if(data.msg!=''){
                                 mui.alert(data.msg);
                               }else{
                                  if(data.desc!=''){
                                      mui.alert(data.desc);
                                  }
                               }
                              console.log(data);
                              return;
                          }

                          $("#getCodeBtn").unbind();
                          mui.toast("操作成功,验证码即将发送到您的手机!");
                           wait();
                      });
                   });
        });
    }



   function wait(){
        maxtime=60;
        $("#getCodeBtn").val(maxtime+"s");
        delTime();
       
    }


    function delTime(){
        maxtime--;

            console.log(maxtime)
        if(maxtime<=0){
            $("#getCodeBtn").text("验证码");
            $("#getCodeBtn").addClass('ativer')
            initGetVcodeBtn();
            return;
        }
        $("#getCodeBtn").removeClass('ativer');
        $("#getCodeBtn").text(maxtime+"s");
          setTimeout(delTime,1000);
    }


    // 地址渲染

       function initProvince() {
           $("#province").empty();
          $("#province").append("<option value='' selected>请选择省</option>");
            for (var index = 0; index < $Adata.length; index++) {
                var item =  $Adata[index];
                if (item.pid == 0) {
                  // console.log(item)
                    $("#province").append("<option value='" + item.name + "'>" + item.name + "</option>");
                }
            }

        }



        function initListener() {
            $("#province").on("change", function () {
                initCityOnProvinceChange();


            });
            $("#city").on("change", function () {
                initThree();
            });
        }
        function initCityOnProvinceChange() {
            var pid = getAddressIdByName($("#province").val());
        // alert(pid)

            $("#city").empty();
            $("#area").empty();
            $("#area").append("<option value='' selected>请选择</option>");
            $("#city").append("<option value='' selected>请选择</option>");
            if (pid == 0) {
                return;
            }
            for (var index = 0; index < $Adata.length; index++) {
                var item = $Adata[index];
                if (item.pid != 0 && item.pid == pid) {
                    $("#city").append("<option value='" + item.name + "'>" + item.name + "</option>");
                    initThree()
                }
            }
        }
        function initThree() {
            var pid = getAddressIdByName($("#city").val());
            $("#area").empty();
            $("#area").append("<option value='' selected>请选择</option>");
            if (pid == 0) {
                return;
            }
            for (var index = 0; index < $Adata.length; index++) {
                var item = $Adata[index];
                if (item.pid != 0 && item.pid == pid) {
                    $("#area").append("<option value='" + item.name + "'>" + item.name + "</option>");
                }
            }
        }



        function getAddressIdByName(_name) {
           var  _name = $.trim(_name);
          // alert(_name)
            if (_name == "") {
                return 0;
            }

            for (var index = 0; index < $Adata.length; index++) {
                var item = $Adata[index];
                // console.log(item)
                var name = $.trim(item.name);

                
                if (name != "" && name == _name) {
                            // alert(_name)
                    return item.id;

                }
            }

            return 0;
        }

function use_typeApp (){
     if(!$use_type||$use_type==""||$use_type.length<0){
       return;
     }

     $("#usertype").empty();
     // $("#usertype").html('')

      var html ='<option value="">请选择购水套餐</option>';
        for(var i=0;i<$use_type.length;i++){
          var item =$use_type[i];
          // console.log(item.code)
          // if(item.code>0){
          //  var html =  '<option selected="selected" value="'+item.code+'">'+item.use_type+'</option>'
          // }else{
           html += '<option value="'+item.code+'">'+item.use_type+'</option>'
          // }
       
         }

    $("#usertype").append(html)
};
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
