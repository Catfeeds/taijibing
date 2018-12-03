

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


  // 坐标判断

console.log(baseInfo);
            //   
  $("#vcode").change(function(){
    var _val=$(this).val()
      localStorage.setItem("vcode",_val ); 
  })
if(baseInfo.length){
      var vcode = localStorage.getItem("vcode"); 
      $("#usertype").val(baseInfo[0].UseType);
      $("#customertype").val(baseInfo[0].CustomerType);
      $("#username").val(baseInfo[0].Name);
      $("#tel").val(baseInfo[0].Tel);
      $("#vcode").val(vcode);
      $("#viewUl").css('marginLeft','-100%');
      $(".nav .ativer").removeClass("ativer")
      $(".regNav").eq(1).addClass("ativer")
}
// 下一步判断
$("#DetermineP").click(function(){
    //console.log(coordinate)
    var viewVal = $("#viewUl").css('marginLeft');
    if(viewVal=='0%'){
         Verification1()
     }else  if(viewVal=='-100%'){
       var obj =    Verification2()
       //console.log(obj)]
           if(!coordinate.Lat){
            layer.open({
           content: '还未解析详细坐标'
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });

      var    viewList=$("#view-list").val()||"";

    if(!viewList){
          layer.open({
          content: '请填写详细地址'
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });
       $("#viewUl").css('marginLeft','-100%');
        $(".nav .ativer").removeClass("ativer")
      $(".regNav").eq(1).addClass("ativer")
      return;
   }

      $("#viewUl").css('marginLeft','-100%');
      $(".nav .ativer").removeClass("ativer")
      $(".regNav").eq(1).addClass("ativer")

    return;
      }

        var params={
            "Name":obj.username,
            "Vcode":obj.vcode,
            "Tel":obj.tel,
            "Address":obj.search,
            "DevBindMobile":obj.tel,
            // "DevFactory":devfactory,
            // "Fid":Fid,
            "Province":obj.province,
            "City":obj.city,
            "area":obj.area,
            "UseType":obj.usertype,
            "customertype":obj.customertype,
            "brandid":obj.devfact,
            "lat":coordinate.Lat,
            "lng":coordinate.Lng,
            "goodsid":obj.devfa
        }


console.log(params)
window.location.href="create-account?"+$.param(params);
      //    $.getJSON("/index.php/agent/user-register?"+ $.param(params),function(data){
      //       //console.log(data)
      //       if(data.state!=0){
      //           $.alert(data.msg);
      //       $("#viewUl").css('marginLeft','0%');
      //       $(".nav .ativer").removeClass("ativer")
      //       $(".regNav").eq(0).addClass("ativer")
      //         return;
      //       }

            


      //      window.location.href="create-account?DevNo="+data.result.devNo;

      // // location.href='create-account';
  
      //   });龙

        //console.log(params)

     }
})
$(".regNav").click(function(){
   var indexThis =  $(this).index();
     if(indexThis<2){
        $("#viewUl").css('marginLeft','-'+indexThis*100+'%');
       $(".nav .ativer").removeClass("ativer")
       $(".regNav").eq(indexThis).addClass("ativer")
     }
     
})
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



function brandid(){

      // 商品渲染
    var brandidName=[];
    var brandNameID=[];
    // 分离商品类型 与商品名字
       for(var i=0;i<bdata.length;i++){

        brandidName.push({brandid:bdata[i].brandid,brandname:bdata[i].brandname})
        brandNameID.push({brandid:bdata[i].brandid,goodsid:bdata[i].goodsid,goodsname:bdata[i].goodsname})
       }
       // 去重
     var brandidName = removeSame(brandidName,'brandid')
     // console.log(brandidName)
     if(brandidName.length){
          for(var i=0;i<brandidName.length;i++){
              $("#devfact").append('<option value='+brandidName[i].brandid +'>'+brandidName[i].brandname +'</option>')  
          }
     }
       $("#devfact").change(function(event) {

       //     /* Act on the event */
           var _this = $(this).val();
           for(var i=0;i<brandNameID.length;i++){
            //console.log(brandNameID[i])
              if(_this==brandNameID[i].brandid){
                $("#devfa").append('<option value='+brandNameID[i].goodsid+'>'+brandNameID[i].goodsname+'</option>')
              }
              // $("#devfact").append('<option value='+brandidName[i].brandid +'>'+brandidName[i].brandname +'</option>')  
          }
     });
}



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

    $(function(){
        initGetVcodeBtn();
        initProvince();
        initListener();
        brandid()
        initAddress();
       $(document).click(function(){
       home()
       })
home()
    function home(){
  var viewVal = $("#viewUl").css('marginLeft');
             if(viewVal=='0%'){
               var index = $("#viewUl li:nth-child(1) .view-list").length;
                 for(var i=0;i<index;i++){
                    if( !$("#viewUl li:nth-child(1) .view-list").eq(i).val()){
                       $("#DetermineP").css("background",'#ddd');
                       return;
                    }
               $("#DetermineP").css({"background":" url(/static/images/brnW.png) no-repeat;",'background-size':' 100% 100%'});
                 }

             }else if(viewVal=='-100%'){
                  var index = $("#viewUl li:nth-child(2) .view-list").length;
                    for(var i=0;i<index;i++){
                    if( !$("#viewUl li:nth-child(2) .view-list").eq(i).val()){
                       $("#DetermineP").css("background",'#ddd');
                       return;
                    }
               $("#DetermineP").css({"background":" url(/static/images/brnW.png) no-repeat;",'background-size':' 100% 100%'});
                 }
             }
       }
    });
    function initAddress(){

        // 状态记录\
       
        var data = JSON.parse(coordinate.jsonobj)
        //console.log(data)
 if(data){
           for(var i=0 in data){
          $("#"+i).val(data[i])
         }

       var _this = $('#devfact').val();
       for(var i=0;i<bdata.length;i++){
              if(_this==bdata[i].brandid){
                $("#devfa").append('<option value='+bdata[i].goodsid+'>'+bdata[i].goodsname+'</option>')
              }
        }
        if(data.devfa&&data.devfa!=null){
          $("#devfa").val(data.devfa)
          initCityOnProvinceChange();
        }
     if(data.city){
       $("#city").val(data.city);
      initThree();
     }
     if(data.area){
      $("#area").val(data.area);
     }
       if(coordinate.state==2){
        // var opop  = Verification2()
          $("#view ul").css("marginLeft",'-100%');
           $(".nav .ativer").removeClass("ativer")
           $(".regNav").eq(1).addClass("ativer")
       // console.log(coordinate.jsonobj)
       }else{
         $("#view ul").css("marginLeft",'0%')
       }
 }

 console.log(coordinate)

if(coordinate.Name){
  $("#search").val(coordinate.Name)
}

    }
    function getAddressIdByName(_name){
        _name= $.trim(_name);
        if(_name==""){
            return 0;
        }
        for(var index=0;index<adata.length;index++){
            var item=adata[index];
            var name= $.trim(item.name);
            if(name!=""&&name==_name){
                return item.id;
            }
        }
        return 0;
    }
    function initListener(){
        $("#province").on("change",function(){
            initCityOnProvinceChange();
        });
        $("#city").on("change",function(){
            initThree();
        });
    }
    function initCityOnProvinceChange(){
        var pid=getAddressIdByName($("#province").val());
        $("#city").empty();
        $("#city").append("<option value='' selected>请选择</option>");
        if(pid==0){
            return;
        }
        for(var index=0;index<adata.length;index++){
            var item=adata[index];
            if(item.pid!=0&&item.pid==pid){
                $("#city").append("<option value='"+item.name+"'>"+item.name+"</option>");
                initThree()
            }
        }
    }
    function initThree(){
        var pid=getAddressIdByName($("#city").val());
        $("#area").empty();
        $("#area").append("<option value='' selected>请选择</option>");
        if(pid==0){
            return;
        }
        for(var index=0;index<adata.length;index++){
            var item=adata[index];
            if(item.pid!=0&&item.pid==pid){
                $("#area").append("<option value='"+item.name+"'>"+item.name+"</option>");
            }
        }
    }

    function initProvince(){
    	
        for(var index=0;index<addressData.length;index++){
        
            var item=adata[index];
            	// console.log()
            	$("#province").append("<option value='"+item.name+"'>"+item.name+"</option>");
            // if(item.pid==0){
                // $("#province").append("<option value='"+item.name+"'>"+item.name+"</option>");
            // }
        }
    }



    function initGetVcodeBtn(){
        $("#getCodeBtn").on("click",function(){
            var tel=$("#tel").val();
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
        if(maxtime<0){
            $("#getCodeBtn").val("获取验证码");
            initGetVcodeBtn();
            return;
        }
        $("#getCodeBtn").val(maxtime+"s");
        setTimeout(delTime,1000);
    }
