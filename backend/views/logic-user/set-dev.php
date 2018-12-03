<!DOCTYPE html>
<html style="overflow-x:hidden;overflow-y:hidden">
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <meta http-equiv="X-UA-Compatible"content="IE=9; IE=8; IE=7; IE=EDGE">
    <link rel="stylesheet" href="./static/js/zui/css/zui.css"/>
    <link rel="stylesheet" href="./static/js/zui/css/style.css"/>
    <link rel="stylesheet" href="./static/css/addgood.css"/>
    <link rel="stylesheet" href="./static/js/jedate/skin/jedate.css"/>

    <link rel="stylesheet" href="./static/js/datepicker/dateRange.css"/>

    <link rel="stylesheet" href="./static/js/page/jquery.pagination.css"/>
       <link rel="stylesheet" href="./static/css/chosen.css"/>
      <link rel="stylesheet" href="./static/css/Common.css"/>
    <style>
        body{
            height:100%;
            width:100%;
            overflow:auto;
        };
        .layui-layer-title {
            display:none;
        }
        .layui-layer-content,.layui-layer-btn{
        background-color: #2D3136;
        }
        .layui-layer-btn .layui-layer-btn0,.layui-layer-molv .layui-layer-btn a{
                background-color: #DD5C1A;    border-color: #DD5C1A;
        }
        #dvCBs  input,#good_sub_type_c input{
            display:none;
        }
        input{
            background-color: #393E45;
            border: none;color:#fff;
        }
        .state + label{
            background-color: #2d3136;
            border-radius: 5px;
            width:20px;
            height:20px;
            display: inline-block;
            text-align: center;
            vertical-align: middle;
            line-height: 20px;
            border-radius:2px;
            
        }
          #good_sub_type_c     .state + label {
                border: 1px solid #e46045;
          }

        .state:checked + label{
           border:1px solid #e46045;
            /*border-color: #e46045;*/
            border-radius:2px;
        }
        .state:checked + label:after{
            content:"\2714";
            font-weight:400;
            color: #e46045
        }
        .listBs{
            float:left;
            position: relative;
            width: 50%;
        }
         .listBs label,.itemBgclose{
          cursor: pointer;
         }
        .Bgclose{
            width: 20px;
            height: 25px;          cursor: pointer;
            line-height: 20px;
            /*position: absolute;*/
            right: 30px;
            text-align: center;
            top: 0;
            color: #fff;
            padding: 0;   
            /*    display: inline-block;*/

            display:none;
            background: url(/static/images3/guanbi.png) 100% 100% no-repeat;
        }
        #dvCBs label{
            margin:0;
            /*border-radius:50%;*/

        }
            .select_btn {
           border-radius: 3px;
           background-color: #E46045;
           width: 60px;
          color: #fff;border: none
        }

        .select_btn:hover{
        background-color:#e44b2b;
        color: #fff
        }  

        .chosen-container {
            margin-left: 15px;
        }

      select, .chosen-container{

          min-width: 130px !important;

      }


      .itemLi div select:last-child,  .itemLi  div  .chosen-container:last-child  {
         min-width: 190px !important;
      }



      #good_sub_type_c .itemLi span{
          min-width: inherit;
          display: inline-block;
          text-align: center;
          margin-left: 15px;
          position: relative;

      }

#good_sub_type_c .itemLi .chosen-container-single .chosen-single span{
  margin-left: 0px;
}

#good_sub_type_c .itemLi .itemNUm{
   /*position: absolute;*/
   width:20px;
   height: 20px;
     min-width: 20px;
     border-radius: 50px;
       background: #1D1F23;    line-height: 20px;    color: #E46045;
   /*left: -10%*/
    }

    .itemLi{
        /*margin-left: -40px;*/
        /*display: inline-block;*/
        min-width: 150px;
    }
    .main-title img {
        border: 0;
        margin-top: -5px;
        vertical-align: middle;
    }

    .page-head {
        padding: 10px 20px;
        padding: 1rem 2rem;
        border-radius: 2px;
        margin-top: 25px;
            padding-bottom: 80px;
        background-color: #393E45;
        min-height: 600px;
    }

    .layui-layer-dialog .layui-layer-content{
          border-top: 4px solid #e84332;    color: #000;
    }
    .layui-layer-content, .layui-layer-btn{
        background-color: #fff;
    }
    .layui-layer-btn{
          text-align: center !important;    padding:15px!important;
    }

    .layui-layer-btn a{
        color: #fff !important;

        background-color: #ea644a!important;
    }

    .layui-layer-btn .layui-layer-btn0{
         /*border-color: #1AA5F1;*/
        background-color: #1AA5F1!important;
    }
    .btn{
      min-width:100px;
       outline:none;
    }

    .btn:focus{
        outline: 0;
            /*background: #ddd;*/
    }

    .select_btn:focus{
              /*background: #ea644a;*/
    }
    .btn:active{
        background: #ddd;
        color: #fff

        border-top: 1px solid #9cc;
    /**/
        /*background: #fff;*/

        box-shadow: 0px 1px 1px #9cc inset, 1px 0px 1px #9cc inset;

    }
    .chosen-container-single .chosen-single span{
        text-align: center;
    }
    .layui-layer-btn a{
          width: 100px;
          border-radius:4px !important;
        height: 30px; 
    }
    .layui-layer-dialog {
        min-width: 311px;
    }


    .layui-layer-setwin .layui-layer-close1{
    display: none!important;
    }
    .layui-layer-dialog .layui-layer-content{
          text-align: center;
    }
    .layui-layer-dialog .layui-layer-content .main-title{
            text-align: left;
    }
    .ftitle{
      width:80px;
    }
    </style>

</head>
<body>
<div class="content_middle">
    <!--    <div class="f1">-->
    <!--        <input type="button" class="btn select_btn" value="+添加新频道" onclick="openUrl()"/>-->
    <!--    </div>-->
    <!--   <div style="text-align: right;margin-bottom: 10px">
    <a href = '/index.php?r=<?=$page_url?>' class='btn btn-primary'>返回</a>
     </div> -->
 <div style="text-align: right;margin-bottom: 10px">
               <a class="btn btn-primary" href="index.php?r=<?=$page_url?><?=$url?>">返回</a>     
        </div> 
    <div class="main-title">
        <img src="/static/images3/sidebar.png" alt="">
          <span class="font-size-S">登记用户设置</span>
    </div>
    <div  style="" class='serve page-head '>
        <div class="item" style="margin-bottom: 20px">
            <div class="ftitle "><span class="tip"></span><span class="titleserve title">服务中心：</span></div>
            <input id="agent_id" type="hidden" class="baseinput" value="<?=$agent_id?>"/>
            <div class="fcontent"><input readonly="readonly"  id="investor" type="text" class="baseinput" value="<?=$name?>"/></div>
        </div>
        <div>
        </div>
        <div class="item" style="height:auto;position: relative;">
            <div class="ftitle"><span class="tip">*</span><span class="title">购水套餐：</span></div>
            <div class="fcontent" style="height:auto;width: 500px; ">
                <!-- <p style='color: #E46045; white-space:nowrap;'>注：0元押金、99元押金、880元自购为系统默认，可不勾选</p> -->
                <!-- <p style='color: #E46045; white-space:nowrap;'>注释：0元押金，99元押金，880元自购此三个模式为固定模式,不可编辑删除,其它添加条件可删除</p> -->
                <div id="dvCBs" >
        <!-- <p style='line-height: 55px;'><a href="javascript:addGoodType2();">继续添加</a></p> -->

                <div style="position: absolute;right: 0px;">
                   <a href="javascript:addGoodType2();"><button type="button" class="btn btn-danger" style="    width: inherit;">添加条件</button></a>
                    <button type="button"  class="btn btn-info  compile" style="width: inherit;"  date=0 >编辑</button>
                </div>

                <!--   <div class="listBs listBsy">
                      <input type="checkbox" name="use_type" value="1"  id="state1" class='state' / >
                     <label for="state1"></label>
                       <span> 0元押金</span>
                  </div>
                <div class="listBs listBsy">

                     <input type="checkbox" name="use_type" value="2"   id="state2" class='state'/>
                     <label  for="state2"></label>
                     <span> 99元押金</span>
                 </div>
                 <div class="listBs listBsy">

                     <input type="checkbox" name="use_type" value="3"  id="state3" class='state'/>
                     <label  for="state3"></label>
                     <span>880元自购</span>
                  </div> -->
               </div>
                <div style='clear:both'></div>
               
            </div>
        </div>
        <div class="item" style="height:auto; margin-top: 40px;position: relative;">
            <div class="ftitle"><span class="tip">*</span><span class="title">选择设备：</span></div>
            <div class="fcontent" style="height:auto;width: 500px;   margin-top: -10px;">

<div style="position: absolute;right: 0px;top:10px;">
                    <a href="javascript:void(0);"  class=''><button type="button" class="btn btn-danger addition" style="    width: inherit;">添加条件</button></a>
                    <a href="javascript:void(0)" class='amend'  UId =''  style='display:none'><button type="button" class="btn btn-danger" style="    width: inherit;">确认添加</button></a>

                    <button type="button"  class="btn btn-info compilefacility"  date=0>编辑</button>

</div>
                
                <div id="good_sub_type_c" style='margin-top: 10px;'>
                      <div style="padding-bottom: 25px; display:none;margin-left: 25px;" class='accretion'> 
                         <select class="investor">
                            <option value="">请选择设备投资商</option>
                        </select>
                        <select class="brand">
                            <option value="">请选择设备品牌</option>
                        </select>
                        <select class="devicename">
                            <option value="">请选择设备名称</option>
                        </select>
                       </div>

                   
                </div>
                <!-- <p style='line-height: 55px;'><a href="javascript:addGoodType();">继续添加</a></p> -->
            </div>
        </div>

        <div class="detail5" style="margin-top: 60px;margin-left: 50px">
 
        <input style='  margin-left: 40px; margin-top: 25px;' type="button" class="btn select_btn  btn-danger " value="保存" onclick="savegood()"/>
    </div>

      <div style='clear:both'></div>

    </div>



</div>
<script type="text/javascript" src="./static/js/jquery.min.js"></script>
    <script type="text/javascript" src="./static/js/chosen.jquery.min.js"></script> 
<script type="text/javascript" src="./static/js/zui/js/zui.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.4"></script>
<script type="text/javascript" src="./static/js/qiniu/moxie.js"></script>
<script type="text/javascript" src="./static/js/qiniu/Plupload.js"></script>
<script type="text/javascript" src="./static/js/qiniu/qiniu.min.js"></script>
<script type="text/javascript" src="./static/js/jedate/jedate.js"></script>
<script type="text/javascript" src="./static/js/layer/layer.js"></script>
<script type="text/javascript" src="./static/js/pinyin.js"></script>
<script type="text/javascript" src="./static/js/lib.js"></script>
<!-- <script type="text/javascript" src="./static/js/good/set-dev.js"></script> -->
<!--<script type="text/javascript" src="./static/js/address.js"></script>-->

<script type="text/javascript">
    var category='';
    var merchant='';


    var baseGood=<?=json_encode($data)?>;


    var id=<?=json_encode($agent_id)?>;//服务中心id
    var name=<?=json_encode($name)?>;//服务中心name
    var province=<?=json_encode($province)?>;
    var city=<?=json_encode($city)?>;
    var area=<?=json_encode($area)?>;
    var use_types_add=<?=json_encode($use_types_add)?>;//已添加的入网属性及代号
    var use_types_select=<?=json_encode($use_types_select)?>;//已勾选的入网属性代号
    var sms='';
    var page_url=<?=json_encode($page_url)?>;
    var url=<?=json_encode($url)?>;

// console.log(page_url)



// $(".content_middle div>a").click(function(){
//     var _thisURl = $(this).attr('href');
//       // var Urlobj = encodeURIComponent(url);
//     $(this).attr('href',_thisURl+page_url+url)


//  console.log(_thisURl+page_url+url)



//     return false;
// })


// console.log(baseGood)
  if(page_url=='hotel-center/index'){
    $(".titleserve").html('酒店中心：')
  }
   var iy =  layer.open({
    type: 1,
    skin: 'layui-layer-demo', //样式类名
    closeBtn: 0, //不显示关闭按钮
    anim: 2,
    shade: [0.8, '#000'],
    content: '<div style="background-color: #25282d;opacity: 0.8;text-align: center;color: #fff;padding:10px;">加载中.....</div>'
  });



</script>
<script type="text/javascript">
 var datasdFun = function(obj,url){
     var dataonj = '4';
      $.ajax ({
           cache: false,
           async: false,
           type: 'get',
           data: obj,
           url: url,
           success: function (data) {
              // var obj = eval('(' + data + ')');
               dataonj = data;
                    // return data;
           }
       });
     //   // console.log(csj_data)
        return dataonj;

}
// 投资商获取
var   devinvestor_data = datasdFun({'province':province,'city':city,'area':area},'./?r=logic-user/get-devinvestor');
// console.log(devinvestor_data);

// var num=baseGood.length;
// console.log(use_types_add)
// 购水套餐
for(var i=0;i<use_types_add.length;i++){
    var html = '<div class="listBs"><input type="checkbox" name="use_type" value='+use_types_add[i].code+'  id="state'+use_types_add[i].code+'" class="state" / >'
    html+='<label for="state'+use_types_add[i].code+'"></label>'     
    html+='<span> '+use_types_add[i].use_type+'</span> <div class="Bgclose"><i class="fa fa-times" aria-hidden="true"></i> </div></div>'
    $("#dvCBs").append(html)
}

if(use_types_select&&use_types_select.code){
   var use_types_se = use_types_select.code.split(',')
   // console.log(use_types_se)
    for(var i=0 ;i<use_types_add.length;i++){
 // console.log(use_types_add[i])
           for(var y=0;y<use_types_se.length;y++){
                
                 if(use_types_se[y]== use_types_add[i].code ){
                     // console.log(use_types_se[y])
                     // console.log(use_types_add[i].code)
                     var pp =  $(".listBs").eq(i).find("input").attr('checked',"checked")
                     
                 }
           }
    }
}
// 购水套餐编辑按钮
$(".compile").click(function(){

  var compileDate= $(".compile").attr('date')

  if(compileDate==0){
      $(".Bgclose").css('display','inline-block');
      $(this).attr('date',1)


  }else{
        $(".Bgclose").css('display','none');
        $(this).attr('date',0)
  }
})
// 选择设备编辑按钮
$(".compilefacility").click(function(){


  var ii = layer.msg('加载中……');
  var facilityDate= $(".compilefacility").attr('date');
  if(facilityDate==0){
    var goodType=getSubGoodTypeJson();//选择商品的内容
// console.log(goodType)
    if(!goodType){
      layer.close()
      layer.msg('请选择完整的条件');
      return;
    }


      // $(".itemclose").css('display','inline-block');
      // $(".addition").parent().parent().css('right','-400px');
  


    if(goodType!=false){
   
          $(this).attr('date',1)
          var data="agent_id="+encodeURIComponent(id);//服务中心id
          data+="&name="+encodeURIComponent(name);//服务中心name
          data+="&subgoodtypes="+encodeURIComponent(getSubGoodTypeJson());//商品数据 数组
          // data+="&use_types="+encodeURIComponent(use_types);//入网属性


          $.getJSON("/index.php?r=logic-user/save-dev&"+data,function(data){
                // console.log(data)
                if(data.state==0){
                  var baseGood=data.datas;
           if(baseGood){
            // var currentIndex=itemAmount+1;
            $("#good_sub_type_c").empty()
            for(var i=1;i<baseGood.length+1;i++){
               var baseGood_id=baseGood[i-1].investor_id
                // console.log(i)
              var html = '<div class="itemLi" id="item_'+i+'">'
                  html +='<span  style="min-width: 40px;margin-left: -5px;"><input type="checkbox" name="item_" value="1" id="item_state'+i+'" class="state" ><label for="item_state'+i+'"></label></span> '; 

                  html +='<div style=" margin-left:-20px;   display: inline-block;"><select   onchange="change1('+i+')" id="investor_'+i+'">';
                  html +=' <option value="">请选择设备投资商</option>';
                  html +=' </select>';
                  html +=' <select id="brand_'+i+'"    onchange="change2('+i+')">';
                  html +='<option value="">请选择设备品牌</option>';
                  html +=' </select>';
                  html +=' <select id="devicename_'+i+'">';
                  html +=' <option value="">请选择设备名称</option>';
                  html +=' </select></div>';
                  html +=' <span class="expurgate"  style="    min-width: 25px;"><img src="/static/images3/guanbi.png" alt=""></span> </div>';
            $("#good_sub_type_c").append($(html));
            $('#investor_'+i).chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
            $('#brand_'+i).chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
            $('#devicename_'+i).chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen

            var html="";
            $(devinvestor_data).each(function(y,v){
                    if(v){
                      if(baseGood_id==v.agent_id){
                          html+="<option selected='selected' value='"+v.agent_id+"'>"+ v.investor+"</option>"
                      }else{
                        html+="<option value='"+v.agent_id+"'>"+ v.investor+"</option>"
                      }   
                    }
                });


              $(html).appendTo('#investor_'+i);
              $('#investor_'+i).trigger("chosen:updated");

              if(baseGood_id){
                    var baseGood_brand_id=baseGood[i-1].brand_id;
                    var  devbrand_data = datasdFun({'province':province,'city':city,'area':area,'agent_id': baseGood_id},'./?r=logic-user/get-devbrand');
                   
                       if (devbrand_data != '') {
                           var html = "<option value=''>请选择设备品牌</option>";
                              $(devbrand_data).each(function (i, v) {
                                  if (v) {
                                    if(baseGood_brand_id==v.BrandNo){

                                      html += "<option selected value='" + v.BrandNo + "'>" + v.BrandName + "</option>"
                                    }else{
                                       html += "<option value='" + v.BrandNo + "'>" + v.BrandName + "</option>"
                                    }
                                  }
                              });
                            $('#brand_' + i).html('');
                          $(html).appendTo('#brand_' + i);
                           $('#brand_' + i).trigger("chosen:updated");
                       }
                     
                     if(baseGood_brand_id){
                         var baseGood_goods = baseGood[i-1].goods_id;

                  // console.log(baseGood_brand_id)
                        var  goods_data = datasdFun({'province':province,'city':city,'area':area,'agent_id':baseGood_id,'brand_id':baseGood_brand_id},'./?r=logic-user/get-dev');         
                              // console.log(goods_data)
                                  if (goods_data != '') {
                                       var html = "<option value=''>请选择设备名称</option>";
                                          $(goods_data).each(function (i, v) {
                                              if (v) {
                                                     if(baseGood_goods==v.id){
                                                       html+="<option selected value='"+v.id+"'>"+ v.goodsname+"</option>"
                                                     }else{
                                                      html+="<option value='"+v.id+"'>"+ v.goodsname+"</option>"
                                                     }                                              }
                                          });
                                        $('#devicename_' + i).html('');
                                      $(html).appendTo('#devicename_' + i);
                                       $('#devicename_' + i).trigger("chosen:updated");
                                   }
                     }
              }else{
                   var html = "<option value=''>请选择设备品牌</option>";
                  $('#brand_' + i).html('');
                  $(html).appendTo('#brand_' + i);
                  $('#brand_' + i).trigger("chosen:updated");
                  //清空后面的下拉框数据
                  $('#devicename_'+i).html("<option value=''>请选择设备名称</option>");
                  $('#devicename_' + i).trigger("chosen:updated");
              }

            }

             layer.close(ii)
            }
                }else{


                     // console.log(data)
                }
          })  
    }
else{




 layer.msg('设备重复')
    }

  }else{
      // $(".itemclose").css('display','none');
      // $(".addition").parent().parent().css('right','-400px');
      $(this).attr('date',0)
      // baseGoodData(baseGood)
    var goodType=getSubGoodTypeJson();//选择商品的内容
    // console.log(goodType);
      if(goodType){
            var data="agent_id="+encodeURIComponent(id);//服务中心id
            data+="&name="+encodeURIComponent(name);//服务中心name
            data+="&subgoodtypes="+encodeURIComponent(getSubGoodTypeJson());//商品数据 数组
            // data+="&use_types="+encodeURIComponent(use_types);//入网属性
            $.getJSON("/index.php?r=logic-user/save-dev&"+data,function(data){
                  // console.log(data)
                  if(data.state==0){
                         // console.log(4)
                             baseGoodData(data.datas);
                                       layer.close(ii)
                  }else{

                     layer.msg(data.msg)

                       console.log(data)
                  }
            })  
      }
  }

// console.log(baseGood)



})










//添加购水套餐
function addGoodType2(){

var itemdvCBs=$("#dvCBs").find(".state").length;

var dvCBsIndex = itemdvCBs +1;

var displayDate='none'
  var compileDate= $(".compile").attr('date');
// console.log(compileDate)
  if(compileDate!=0){
    displayDate='inline-block'
  }else{
    displayDate='none'
  }
var htmlInput = '<div style="    text-align: left;"><div class="main-title" style="padding:20px 0;"><img src="/static/images3/caption2.png" alt=""><span class="font-size-S" style="margin-left:15px;"> 请手动输入预设值</span> </div><input type="number" name=""  class="dvCBsrmb1" value="" placeholder="请输入金额" style="background: #ebeef3;color:#000;border-radius:5px"/ >  &nbsp;元服务费<p></p><input type="number" name=""  class="dvCBsrmb2" value="" placeholder="请输入金额" style="background: #ebeef3;color:#000;border-radius:5px"/ >  &nbsp;元水费   </div>';
var dvCBslaye = layer.confirm(htmlInput, {
  area: ['150px', '300px'],
  btn: ['取消','确定'] //按钮
}, function(){
          layer.closeAll();
}, function(){
        var pppp1  = $(".dvCBsrmb1").val()
        var pppp2  = $(".dvCBsrmb2").val()
        var prnb1 = Math.round(pppp1*100)/100;
        var prnb2 = Math.round(pppp2*100)/100;
        if(prnb1<0){
            layer.msg('输入大于0的金额');
            return
        }

        if(!prnb2||prnb2<1){
            layer.msg('输入大于1的金额');
            return
        }



          $.get('./?r=logic-user/add-use-type',{'use_type':''+(prnb1*1+prnb2*1)+'元('+prnb1+'元服务费+'+prnb2+'元水费)','agent_id':id,'water_charge':prnb2,'service_charge':prnb1},function(data){ 
            if(data.state<0){
                layer.msg(data.msg);
              return;
            }


            var data = 　　$.parseJSON( data )

        // console.log(data)
             // return;

           var html = '<div class="listBs"><input type="checkbox"  checked="checked" name="use_type" value='+data.code+'  id="state'+dvCBsIndex+'" class="state" / >'
               html+='<label for="state'+dvCBsIndex+'"></label>'     
               html+='<span> '+(prnb1*1+prnb2*1)+'&nbsp;元('+prnb1+'元服务费+'+prnb2+'元水费)</span> <div class="Bgclose" style="display:'+displayDate+'"><i class="fa fa-times" aria-hidden="true"></i> </div><div>'
                 $("#dvCBs").append(html)
    })

    layer.close(dvCBslaye);
});
}


layer.closeAll()

function change1(no){
      var agent_id=$('#investor_'+no+' option:selected').attr('value');
      // console.log(agent_id)
        if (agent_id) {
          $.get('./?r=logic-user/get-devbrand', {'province':province,'city':city,'area':area,'agent_id': agent_id}, function (data) {
              // console.log(data);
               if (data != '') {
                   var html = "<option value=''>请选择设备品牌</option>";
                      $(data).each(function (i, v) {
                          if (v) {
                              html += "<option value='" + v.BrandNo + "'>" + v.BrandName + "</option>"
                          }
                      });
                    $('#brand_' + no).html('');
                    $(html).appendTo('#brand_' + no);
                   $('#brand_' + no).trigger("chosen:updated");
                   $('#devicename_'+no).html("<option value=''>请选择设备名称</option>");
                  $('#devicename_' + no).trigger("chosen:updated");


               }
          })

        } else {
            var html = "<option value=''>请选择设备品牌</option>";
            $('#brand_' + no).html('');
            $(html).appendTo('#brand_' + no);
            $('#brand_' + no).trigger("chosen:updated");
            //清空后面的下拉框数据
            $('#devicename_'+no).html("<option value=''>请选择设备名称</option>");
            $('#devicename_' + no).trigger("chosen:updated");
        }
};
function change2(no){
      var agent_id=$('#investor_'+no+' option:selected').attr('value');
      var brand_id=$('#brand_'+no+' option:selected').attr('value');

      // console.log(agent_id)
        if (brand_id) {

        $.get('./?r=logic-user/get-dev',{'province':province,'city':city,'area':area,'agent_id':agent_id,'brand_id':brand_id},function(data){
              // console.log(data);
               if (data != '') {
                   var html = "<option value=''>请选择设备名称</option>";
                      $(data).each(function (i, v) {
                          if (v) {
                              html+="<option value='"+v.id+"'>"+ v.goodsname+"</option>"
                          }
                      });
                    $('#devicename_' + no).html('');
                  $(html).appendTo('#devicename_' + no);
                   $('#devicename_' + no).trigger("chosen:updated");
               }
          })
        } else {
            $('#devicename_'+no).html("<option value=''>请选择设备名称</option>");
            $('#devicename_' + no).trigger("chosen:updated");
        }
};

// 全量保存
function savegood(){

    var goodType=getSubGoodTypeJson();//选择商品的内容

    // console.log(goodType);
    if(goodType){
      // console.log()
          var data="agent_id="+encodeURIComponent(id);//服务中心id
          data+="&name="+encodeURIComponent(name);//服务中心name
          data+="&subgoodtypes="+encodeURIComponent(getSubGoodTypeJson());//商品数据 数组
          // data+="&use_types="+encodeURIComponent(use_types);//入网属性


          $.getJSON("/index.php?r=logic-user/save-dev&"+data,function(data){
                // console.log(data)
                if(data.state==0){
                 var facilityDate= $(".compilefacility").attr('date');
                           
                      // if(facilityDate==0){
                           baseGoodData(data.datas);
                        layer.msg('保存成功')
                           baseGood=data.datas
                      // }
                }else{
                       layer.msg(data.msg)
                       console.log(data)
                }
          })  
    }else{
           layer.msg('资料不全或者是重复设备')
    }


}
// console.log(baseGood)



function unique($data) {
  var res = [];
  var json = {};
  for (var p = 0; p < $data.length; p++) {
    if (!json[$data[p]]) {
      res.push($data[p]);
      json[$data[p]] = 1;
    } else {

      return false;
    }
  }

  return res;
};

function getSubGoodTypeJson(){
       var itemAmount=$("#good_sub_type_c").find(".itemLi").length;
       // alert(itemAmount)

       // console.log(itemAmount)
      var typeList=[];
         for(var i=1;i<itemAmount+1;i++){
              // console.log( $("#item_state"+i).is(":checked"))
                var devinvestor = $("#investor_"+i).attr('dataval')?$("#investor_"+i).attr('dataval'):$("#investor_"+i).val();//设备品牌
                // var devinvestorName = $("#investor_"+i).attr('dataval')?$("#investor_"+i).attr('dataval'):$("#investor_"+i).val();//设备品牌
                var devbrand = $("#brand_"+i).attr('dataval')?$("#brand_"+i).attr('dataval'):$("#brand_"+i).val();//设备品牌
                // var devbrand = $("#brand_"+i).attr('dataval') ? $("#brand_"+i).attr('brand_'):$("#investor_"+i).val();//设备品牌
                var devname = $("#devicename_"+i).attr('dataval')?$("#devicename_"+i).attr('dataval'):$("#devicename_"+i).val();//设备品牌

                 // console.log(devname)

                if(!devname){
                  layer.msg('资料不完整');

                  return;
                }
                typeList.push(JSON.stringify({
                devinvestor:devinvestor,
                // devinvestorName:devinvestorName,
                devbrand:devbrand,
                devname:devname,
                }))
         }

    // .log(typeList)     
var typeList= unique(typeList)
// console.log(typeList)

 if(typeList){
  // 
     for( var i=0;i<typeList.length;i++){
       // typeList[i]
        if(typeof(typeList[i])=='string'){
                typeList[i]=  $.parseJSON( typeList[i])
        }
     }
// console.log(typeList)
return JSON.stringify(typeList);

}else{
   return typeList;
}

         // 

  }

baseGoodData(baseGood);



function  baseGoodData(baseGood){
      if(baseGood.length){
      var itemAmount=$("#good_sub_type_c").find(".itemLi").length;
      // console.log(itemAmount)
     var facilityDate= $(".compilefacility").attr('date');
      // console.log(facilityDate)

      var displayDate;
      var displayDate2;
        if(facilityDate==0){
          
              displayDate='none';
               displayDate2='inline-block';
        }else{
              displayDate='inline-block'
               displayDate2='none';
        }



// alert(displayDate)

// <input type="checkbox" name="item_" value="1" id="item_state'+currentIndex+'" class="state" checked="checked"><label for="item_state'+currentIndex+'"></label>


  $("#good_sub_type_c").empty()
      for(var index= 0;index < baseGood.length;index++){

          var currentIndex=index+1;
          var html = '<p  class="itemLi"  id="item_'+index+'" onjId='+baseGood[index].id+'> '  +

                 '<span class="itemNUm"  style="display:'+displayDate2+'">'+currentIndex+' </span> '+
                 '<span  style="display:'+displayDate+';min-width: 40px;margin-left: -5px;"><input type="checkbox" name="item_" value="1" id="item_state'+currentIndex+'" class="state"><label for="item_state'+currentIndex+'"></label></span> '+
                 
                  '  <span id="investor_'+currentIndex+'" dataval="'+baseGood[index].investor_id+'">'+baseGood[index].Name+'</span>'+
                  '<span id="brand_'+currentIndex+'"  dataval="'+baseGood[index].brand_id+'">'+baseGood[index].BrandName+'</span>'+
                  '<span  id="devicename_'+currentIndex+'"   dataval="'+baseGood[index].goods_id+'">'+baseGood[index].GoodsName+'</span>'+
                  '<span class="itemclose" style="display:'+displayDate+';min-width:50px;    margin: 0;"><span style="min-width:50px;"  class="itemBgclose"> '+
                  '<img src="/static/images3/guanbi.png" alt="">'+
                  '</span>'+
                  '</p>'
               
                   $("#good_sub_type_c").append($(html));
          }
      }

}




$(document).on('click','.btn',function(){
  var _this = $(this)


})



.on('click','.addition',function(){




        var itemAmount=$("#good_sub_type_c").find(".itemLi").length;
        // console.log(4)
        var facilityDate= $(".compilefacility").attr('date');
        // console.log(facilityDate)
        var displayDate;
        var displayDate2;
        if(facilityDate==0){
          
              displayDate='none';
               displayDate2='inline-block';
        }else{
              displayDate='inline-block'
               displayDate2='none';
        }
       var currentIndex=itemAmount+1;
          var html = '<div class="itemLi" id="item_'+currentIndex+'"  onjid='+id+'>'
                html +=' <span class="itemNUm"  style="display:'+displayDate2+'">'+currentIndex+' </span>'   
                html +='<span  style="display:'+displayDate+';min-width: 40px;margin-left: -5px;"><input type="checkbox" name="item_" value="1" id="item_state'+currentIndex+'" class="state"><label for="item_state'+currentIndex+'"></label></span> '   
                html +='<div style=" margin-left:-10px;   display: inline-block;"><select   onchange="change1('+currentIndex+')" id="investor_'+currentIndex+'">';
                html +=' <option value="">请选择设备投资商</option>';
                html +=' </select>';
                html +=' <select id="brand_'+currentIndex+'"    onchange="change2('+currentIndex+')">';
                html +='<option value="">请选择设备品牌</option>';
                html +=' </select>';
                html +=' <select id="devicename_'+currentIndex+'">';
                html +=' <option value="">请选择设备名称</option>';
                html +=' </select></div>';
                html +=' <span  class="expurgate" style="    min-width: 25px;"><img src="/static/images3/guanbi.png" alt=""></span> </div>';
            $("#good_sub_type_c").append($(html));
            $('#investor_'+currentIndex).chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
            $('#brand_'+currentIndex).chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
            $('#devicename_'+currentIndex).chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
              var html="";
                $(devinvestor_data).each(function(i,v){
                    if(v){
                        html+="<option value='"+v.agent_id+"'>"+ v.investor+"</option>"
                    }
                });
           $(html).appendTo('#investor_'+currentIndex);
           $('#investor_'+currentIndex).trigger("chosen:updated");

})


.on('click', '.Bgclose', function() {
    var _this = $(this);
    var  code = _this.parent().find("input").val();






        layer.confirm('你确认要删除吗？', {
          btn: ['取消','确定'] //按钮
        }, function(){
            layer.closeAll();
        }, function(){
            // console.log(ischecked)

               var ii=layer.msg("操作中……");
    $.get('./?r=logic-user/del-use-type',{'code':code,'agent_id':id},function(data){
              var obj = eval('(' + data + ')');
                 layer.close(ii);
        
             if(data.state<0){
                var obj = eval('(' + data + ')');
                // console.log(obj)
                return;
            }
            _this.parent().remove();

      
            layer.alert('删除成功', {
              skin: 'layui-layer-molv' //样式类名
              ,closeBtn: 0
            });

          // window.location.reload()
            })
                    layer.close();
        });







// layer.msg('<div style="padding:50px;    font-size: 25px;">你确认要删除吗？</div>', {
//   time: 0 //不自动关闭
//    ,btn: ['确定', '取消']
//   ,yes: function(index){
//    var ii=layer.msg("操作中……");
//     $.get('./?r=logic-user/del-use-type',{'code':code,'agent_id':id},function(data){
//               var obj = eval('(' + data + ')');
//                  layer.close(ii);
        
//              if(data.state<0){
//                 var obj = eval('(' + data + ')');
//                 // console.log(obj)
//                 return;
//             }
//             _this.parent().remove();

      
//             layer.alert('删除成功', {
//               skin: 'layui-layer-molv' //样式类名
//               ,closeBtn: 0
//             });

//           // window.location.reload()
//     })


//     layer.close(index);
//   }
// });
}).on('click','.listBs input',function(){
 
     var _this = $(this).val();

     // var pp =  $(".listBs").find("input").attr('checked',"checked").index();
        var pp =  $(".listBs input[type='checkbox']:checked").val();
       var  use_types = [];

             $.each($('.listBs input:checkbox:checked'),function(){
                // window.alert("你选了："+$('input[type=checkbox]:checked').length+"个，其中有："+$(this).val());
                  use_types.push($(this).val())

            });

// console.log(use_types)
             if(use_types.length<1){
         
             layer.msg(  "至少勾选一个购水套餐");

             return false;
        }

           var obj={
              use_types:encodeURIComponent(use_types),
              agent_id:id,

           }
     var ii=layer.msg("加载中……");

     
           $.get('./?r=logic-user/save-use-type',obj,function(data){
              layer.close(ii);
              // console.log(data)

           })


})



.on('click','.expurgate',function(){
   
    var facilityDate= $(".compilefacility").attr('date');
  // console.log(facilityDate)

  if(facilityDate==0){
      $(this).parents(".itemLi").remove();
  }else{
     var itemAmount=$("#good_sub_type_c").find(".itemLi").length;

      var ischecked=[];
      var  ischeckedNum=0;
      var  ischeckedID=[];


      for(var i=1;i<itemAmount+1;i++){
          // console.log( )
          if(!$("#item_state"+i).is(":checked")){
                var devinvestor = $("#investor_"+i).attr('dataval')?$("#investor_"+i).attr('dataval'):$("#investor_"+i).val();//设备品牌
                var devbrand = $("#brand_"+i).attr('dataval')?$("#brand_"+i).attr('dataval'):$("#brand_"+i).val();//设备品牌
                // var devbrand = $("#brand_"+i).attr('dataval') ? $("#brand_"+i).attr('brand_'):$("#investor_"+i).val();//设备品牌
                var devname = $("#devicename_"+i).attr('dataval')?$("#devicename_"+i).attr('dataval'):$("#devicename_"+i).val();//设备品牌
                if(devname){
                  ischecked.push({
                    devinvestor:devinvestor,
                    devbrand:devbrand,
                    devname:devname,
                    })
                }
          }else{

            ischeckedID.push('item_'+i)
            ischeckedNum++
          }
      }
        var ischeckedNumfalse = true;


       if(ischeckedNum){
        layer.confirm('是否确定删除这'+ischeckedNum+'台设备', {
          btn: ['取消','确定'] //按钮
        }, function(){
               layer.closeAll();
        }, function(){
            // console.log(ischecked)

            var goodType= JSON.stringify(ischecked);
                var data="agent_id="+encodeURIComponent(id);//服务中心id
                data+="&name="+encodeURIComponent(name);//服务中心name
                data+="&subgoodtypes="+encodeURIComponent(goodType);//商品数据 数组

                    $.getJSON("/index.php?r=logic-user/save-dev&"+data,function(data){
                              // console.log(data)
                              if(data.state==0){
                              layer.msg('删除成功')
                              }
                        })
                    layer.close();
        });

       }else{
        var _this = $(this).parents(".itemLi");
     

          layer.confirm('是否确定删除这1台设备', {
          btn: ['取消','确定'] //按钮
        }, function(){
    layer.closeAll();
        }, function(){
          _this.remove();  
   var itemAmount=$("#good_sub_type_c").find(".itemLi").length;
              var ischecked=[];
               for(var i=1;i<itemAmount+1;i++){
                       var devinvestor = $("#investor_"+i).attr('dataval')?$("#investor_"+i).attr('dataval'):$("#investor_"+i).val();//设备品牌
                var devbrand = $("#brand_"+i).attr('dataval')?$("#brand_"+i).attr('dataval'):$("#brand_"+i).val();//设备品牌
                // var devbrand = $("#brand_"+i).attr('dataval') ? $("#brand_"+i).attr('brand_'):$("#investor_"+i).val();//设备品牌
                var devname = $("#devicename_"+i).attr('dataval')?$("#devicename_"+i).attr('dataval'):$("#devicename_"+i).val();//设备品牌

               if(devname){
                  ischecked.push({
                    devinvestor:devinvestor,
                    devbrand:devbrand,
                    devname:devname,
                    })
                }


                 
               }
               // console.log(ischecked)
                 var goodType= JSON.stringify(ischecked);
                var data="agent_id="+encodeURIComponent(id);//服务中心id
                data+="&name="+encodeURIComponent(name);//服务中心name
                data+="&subgoodtypes="+encodeURIComponent(goodType);//商品数据 数组

                    $.getJSON("/index.php?r=logic-user/save-dev&"+data,function(data){
                              // console.log(data)
                              if(data.state==0){
                              var  GoodTypeJson =    $.parseJSON( goodType)
                              // console.log( GoodTypeJson)
                                  
                              }
                        })
            layer.close();
        });
       }
  }
})
</script>
</body>
</html>

