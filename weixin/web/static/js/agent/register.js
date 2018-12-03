

    // console.log(datas)
    // 判断邓丽后的状态
     if(datas.state==-1){
      layer.open({
          content: datas.mas
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });
     }else{
        // 购水套餐选择
      var ii = layer.open({type: 2});
      if(datas.use_type){
        layer.close(ii)
        $("#usertype").empty();
        $("#usertype").append(' <option value="">请选择购水套餐</option>')
        for(var i=0;i<datas.use_type.length;i++){
          var item = datas.use_type[i];
           var html =  '<option value="'+item.code+'">'+item.use_type+'</option>'
          $("#usertype").append(html)
        }
      }





// 验证码,手机号码验证
    function initGetVcodeBtn(){
        $("#getCodeBtn").on("click",function(){
            var tel=$("#tel").val();
            // alert(tel)

            if(!validateTel(tel)){

                $.alert("请输入格式正确的手机号码");
                return;
            }
            $.getJSON('/index.php/agent/get-vcode?tel='+tel,function(data){
                if(data.state!=0){
                    $.alert(data.msg);
                    //console.log(data);
                    return;
                }
                $("#getCodeBtn").unbind();
                $.toast("操作成功,验证码即将发送到您的手机!");
                wait();

            });
        });
    }

    function wait(){
        maxtime=20;
        $("#getCodeBtn").val(maxtime+"s");
        delTime();
       
    }


    function delTime(){
        maxtime--;
        if(maxtime<=0){
            $("#getCodeBtn").val("获取验证码");
            $("#getCodeBtn").css("background",' url(/static/images/brnW.png) 0% 0% / 100% 100% no-repeat')

            initGetVcodeBtn();
            return;
        }
        $("#getCodeBtn").css("background",'#ddd')
        
        $("#getCodeBtn").val(maxtime+"s");
          setTimeout(delTime,1000);
    }

// 商品渲染
function brandid(){
      // 商品渲染
    var brandidName=[];
    var brandNameID=[];
    // 分离商品类型 与商品名字
       for(var i=0;i<datas.bdata.length;i++){
             var item = datas.bdata[i]
             // console.log(item)
             var brandname = item.brandname;
             var brandid = item.brandid;
            brandidName.push({brandname:brandname,brandid:brandid})
        brandNameID.push({goodsname:item.goodsname,goodsid:item.goodsid,brandid:brandid})
       }
       // 去重
     var brandidName = removeSame(brandidName,'brandid')

     // console.log(brandidName)
     // console.log(brandNameID)
     if(brandidName.length){
          for(var i=0;i<brandidName.length;i++){
              $("#devfact").append('<option value='+brandidName[i].brandid +'>'+brandidName[i].brandname +'</option>')  
          }
     }
       $("#devfact").change(function(event) {
              $("#devfa").empty().append("<option value=''>请选择设备型号</option>")

           var _this = $(this).val();

              devfa(_this,brandNameID)
     });
}
  function  devfa(brandid,brandNameID){
   // console.log(brandid)
         for(var i=0;i<brandNameID.length;i++){
   
          if(brandid==brandNameID[i].brandid){
            $("#devfa").append('<option value='+brandNameID[i].goodsid+'>'+brandNameID[i].goodsname+'</option>')
          }
      }
   }

// console.log(addressData)

// 验证码,手机号码验证
initGetVcodeBtn();
// 商品渲染
brandid();

initListener();

// 省渲染
initProvince()
// 状态记录
 initAddress()

// 状态记录


function initAddress(){
// console.log(data)
if(datas.agent_address){
	var agent_address = datas.agent_address;

	       $("#province").val(agent_address.Province);
          initCityOnProvinceChange();
          $("#city").val(agent_address.City);
          initThree();
          $("#area").val(agent_address.Area);

         $('#devfact').val('4e4908505b89ae3eae99e0e8041a5307');
          var _this = $('#devfact').val();
           devfa(_this,datas.bdata)
         $('#devfa').val(36	)
}

     if(data){
    // console.log(datas)
      var datacoordinate =  JSON.parse(data.jsonobj)
       // console.log(datacoordinate)
       if(datacoordinate){
        for(var i=0 in datacoordinate){
         // console.log(datacoordinate[i])
           $("#"+i).val(datacoordinate[i])
         }
       var _this = $('#devfact').val();
         devfa(_this,datas.bdata)
         if(datacoordinate.devfa){
         $('#devfa').val(datacoordinate.devfa)
        }
        if(data.state==2){
        // var opop  = Verification2()
          $("#view ul").css("marginLeft",'-100%');
           $(".nav .ativer").removeClass("ativer")
           $(".regNav").eq(1).addClass("ativer")
       // console.log(coordinate.jsonobj)
       }else{
         $("#view ul").css("marginLeft",'0%')
       }

    if(datacoordinate.province){

       $("#province").val(datacoordinate.province);
                initCityOnProvinceChange();
     }

     if(datacoordinate.city){
       $("#city").val(datacoordinate.city);
      initThree();
     }
     if(datacoordinate.area){
      $("#area").val(datacoordinate.area);
     }
if(data.Name){
     $("#search").val(data.Name)
}        
       }



 }

// console.log(data)
$("#vcode").change(function(){
var _val=$(this).val()
localStorage.setItem("vcode",_val ); 
})
if(datas.BaseInfo.length){
      var vcode = localStorage.getItem("vcode"); 
      $("#usertype").val(datas.BaseInfo[0].UseType);
      $("#customertype").val(datas.BaseInfo[0].CustomerType);
      $("#username").val(datas.BaseInfo[0].Name);
      $("#tel").val(datas.BaseInfo[0].Tel);
       $("#vcode").val(vcode);
      $("#viewUl").css('marginLeft','-100%');
      $(".nav .ativer").removeClass("ativer")
      $(".regNav").eq(1).addClass("ativer")
}

    }
// 点击链接到地图
function openMark(){
  var addressVal= $(".address input").val();
  var province= $("#province").val();
  var city= $("#city").val()||'';
  var area= $("#area").val()||'';
  if(!province){
      layer.open({
          content: '请选择省'
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });
      return;
  };



  // 验证填写是否有空
  var obj =Verification2();
   var objdata =   JSON.stringify(obj)
      if(objdata){
          location.href='mark?address='+objdata;
      }
  }
function initListener(){
    $("#province").on("change",function(){
        initCityOnProvinceChange();
    });

    $("#city").on("change",function(){
        initThree();
    });
}
// 区渲染
 function initThree(){
        var pid=getAddressIdByName($("#city").val());
        $("#area").empty();
        $("#area").append("<option value='' selected>请选择</option>");
        if(pid==0){
            return;
        }
        for(var index=0;index<datas.adata.length;index++){
            var item=datas.adata[index];
            if(item.pid!=0&&item.pid==pid){
                $("#area").append("<option value='"+item.name+"'>"+item.name+"</option>");
            }
        }
    }

// 市渲染
    function initCityOnProvinceChange(){
        var pid=getAddressIdByName($("#province").val());
        $("#city").empty();
        $("#city").append("<option value='' selected>请选择</option>");
        if(pid==0){
            return;
        }
        for(var index=0;index<datas.adata.length;index++){
            var item=datas.adata[index];
            if(item.pid!=0&&item.pid==pid){
                $("#city").append("<option value='"+item.name+"'>"+item.name+"</option>");
                initThree()
            }
        }
    }


    function initProvince(){
        for(var index=0;index<datas.adata.length;index++){
            var item=datas.adata[index];
            if(item.pid==0){
              $("#province").append("<option value='"+item.name+"'>"+item.name+"</option>");
            }
         
        }
    }
// 获取地址id
    function getAddressIdByName(_name){
    _name= $.trim(_name);
    if(_name==""){
        return 0;
    }
    for(var index=0;index<datas.adata.length;index++){
        var item=datas.adata[index];
        var name= $.trim(item.name);
        if(name!=""&&name==_name){
            return item.id;
        }
    }
    return 0;
}
$("#DeterminePOne").click(function(){
    //console.log(coordinate)
     var viewVal = $("#viewUl").css('marginLeft');
     var _width = Math.ceil($("#viewUl li").width()) 
     // console.log(_width)
     // console.log(viewVal)
     Verification1(); 
})

$("#DeterminePTwo").click(function(){
      var obj =    Verification2();


     if(!data.Lat||data.Lat=='undefined'||data.Lat==null){

       layer.open({
          content: '还未解析详细坐标'
           ,skin: 'msg'
        });
     return;

            

             
        }




   var   viewList = $(".door").val();
    if(!viewList){
          layer.open({
          content: '请填写详细地址'
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });
     return;
}


var    viewList=$(".door").val()||"";
        var params={
            "Name":obj.username,
            "Vcode":obj.vcode,
            "Tel":obj.tel,
            "Address":obj.search+viewList,
            "DevBindMobile":obj.tel,
            // "DevFactory":devfactory,
            // "Fid":Fid,
            "Province":obj.province,
            "City":obj.city,
            "area":obj.area,
            "UseType":obj.usertype,
            "customertype":obj.customertype,
            "brandid":obj.devfact,
            "lat":data.Lat,
            "lng":data.Lng,
            "goodsid":obj.devfa,
          //  'Address':$("#search").val()
        }
    window.location.href="create-account?"+$.param(params);
})

/*
$(".regNav").click(function(){
   var indexThis =  $(this).index();
     if(indexThis<2){
        $("#viewUl").css('marginLeft','-'+indexThis*100+'%');
       $(".nav .ativer").removeClass("ativer")
       $(".regNav").eq(indexThis).addClass("ativer")
     }
     
})
*/



// 去重 同型号只取一个
function removeSame(brandidName,brandid){
        var checked = brandidName;
        var p_ids = [];
        var data = [];
        if(checked.length) {
            $.each(checked,function(i,ck){
                // console.log(ck)
                var p_id = ck.brandid;
                if($.inArray(p_id,p_ids) == -1){
                    p_ids.push(p_id);
                    data.push(ck)
                }
            });
        }
        return data;
    }

// 首次下一步验证
var Verification1 = function (){
      var    usertype=$("#usertype").val()||"";
      var    customertype=$("#customertype").val()||"";
      var    username=$("#username").val()||"";
      var    tel=$("#tel").val()||"";
      var    vcode=$("#vcode").val()||"";

   if(!usertype){
          layer.open({
          content: '请选择购水套餐'
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });

      $("#viewUl").css('marginLeft','0%');
      $(".nav .ativer").removeClass("ativer")
      $(".regNav").eq(0).addClass("ativer");
      return;
   }
  if(!customertype){
          layer.open({
          content: '请选择客户类型'
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });

      $("#viewUl").css('marginLeft','0%');
      $(".nav .ativer").removeClass("ativer")
      $(".regNav").eq(0).addClass("ativer")
      return;
   } 
if(!username){
          layer.open({
          content: '请输入用户姓名'
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });
      $("#viewUl").css('marginLeft','0%')
      $(".nav .ativer").removeClass("ativer")
      $(".regNav").eq(0).addClass("ativer")
      return;
   }
   if(!tel){
          layer.open({
          content: '请输入电话号码'
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });
      $("#viewUl").css('marginLeft','0%')
      $(".nav .ativer").removeClass("ativer")
      $(".regNav").eq(0).addClass("ativer")
      return;
   }
     if(!vcode){
          layer.open({
          content: '请输入验证码'
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });
      $("#viewUl").css('marginLeft','0%')
      $(".nav .ativer").removeClass("ativer")
      $(".regNav").eq(0).addClass("ativer")
      return;
   }
  var obj = {
      usertype:$("#usertype").val()||"",
      customertype:$("#customertype").val()||"",
      username:$("#username").val()||"",
      tel:$("#tel").val()||"",
      vcode:$("#vcode").val()||"",}

      $("#viewUl").css('marginLeft','-100%');
      $(".nav .ativer").removeClass("ativer")
      $(".regNav").eq(1).addClass("ativer");
      $("#DetermineP").css({"background":" url(/static/images/brnW.png) no-repeat;",'background-size':' 100% 100%'})
      return obj;
}

var Verification2 = function (){
      var    devfact=$("#devfact").val()||"";
      var    devfa=$("#devfa").val()||"";
      var    province=$("#province").val()||"";
      var    city=$("#city").val()||"";
      var    area=$("#area").val()||"";
      var    viewList=$(".door").val()||"";
   if(!devfact){
          layer.open({
          content: '请选择设备品牌'
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });
       $("#viewUl").css('marginLeft','-100%');
       $(".nav .ativer").removeClass("ativer")
      $(".regNav").eq(1).addClass("ativer")
      return;
   }
   if(!devfa){
          layer.open({
          content: '请选择设备型号'
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });
       $("#viewUl").css('marginLeft','-100%');
        $(".nav .ativer").removeClass("ativer")
      $(".regNav").eq(1).addClass("ativer")
      return;
   }
   if(!province){
          layer.open({
          content: '请选择省'
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });
       $("#viewUl").css('marginLeft','-100%');
        $(".nav .ativer").removeClass("ativer")
      $(".regNav").eq(1).addClass("ativer")
      return;
   }
   if(!city){
          layer.open({
          content: '请选择市'
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });
       $("#viewUl").css('marginLeft','-100%');
        $(".nav .ativer").removeClass("ativer")
      $(".regNav").eq(1).addClass("ativer")
      return;
   }
   if(!area){
          layer.open({
          content: '请选择区'
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });
       $("#viewUl").css('marginLeft','-100%');
        $(".nav .ativer").removeClass("ativer")
      $(".regNav").eq(1).addClass("ativer")
      return;
   }


  var obj = {
         
          devfact:$("#devfact").val()||"",
          devfa:$("#devfa").val()||"",
          province:$("#province").val()||"",
          city:$("#city").val()||"",
          area:$("#area").val()||"",
          search:$("#search").val()||'',
          address:$("#search").val()+','+viewList

    }
    return obj;


}



  }

  $('input,select').bind('input porpertychange',function(){
        var viewVal = $("#viewUl").css('marginLeft');
        var _width = Math.ceil($("#viewUl li").width()) ;
           if(viewVal=='0px'){
               var index = $("#viewUl li:nth-child(1) .view-list").length;
                 for(var i=0;i<index;i++){
                    if( !$("#viewUl li:nth-child(1) .view-list").eq(i).val()){
                       $("#DeterminePOne").css("background",'#ddd');
                       return;
                    }
                     $("#DeterminePOne").css({"background":" url(/static/images/brnW.png) no-repeat",'background-size':' 100% 100%'});
              
                }
      
       }else  if(viewVal=='-'+_width+'px'){
           var index = $("#viewUl li:nth-child(2) .view-list").length;
                 for(var i=0;i<index;i++){
                    if( !$("#viewUl li:nth-child(2) .view-list").eq(i).val()){
                       $("#DeterminePTwo").css("background",'#ddd');
                       return;
                    }
                    if(!data.Lat&&data.Lat=="undefined"){
                       $("#DeterminePTwo").css("background",'#ddd');
                       return;
                    }

               $("#DeterminePTwo").css({"background":" url(/static/images/brnW.png) no-repeat",'background-size':' 100% 100%'});
                 }


       }


  });
