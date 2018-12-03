<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/25
 * Time: 11:15
 */

use feehi\widgets\ActiveForm;

$this->title = "";
?>
    <link rel="stylesheet" href="./static/css/chosen.css"/>
    <link rel="stylesheet" href="./static/css/Common.css?v=1.1"/>
<style type="text/css" media="screen">
	.has-success .control-label {
    color: #eeeeee;
}
.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
   border-color: #eeeeee;
    background: #363643;
    opacity: 1;
}
.has-success .form-control {
    border-color: #eeeeee;
    background: #363643;
}
 .has-success .form-control{
 	border-color: #8c8888;
    border-radius:5px;
 }
.ibox-content select,.ibox-content option,input{
	 width: initial ;
      border-color: #8c8888;
     border-radius:5px;
}.btn{
line-height:20px;
}
.btn-primary{
line-height:20px
}
.btn-white{
display:none;
}  
select, .chosen-container{
	    width: initial !important;
}
.layui-layer-content{
        height: 100% !important;
    line-height: 30px !important;
    width: 100%;
}
.layui-layer-btn{
    position: absolute;
    width: 100%;
    text-align: center;
    bottom: 0;
}
.layui-layer{
    left:25%;
}
.layui-layer-setwin .layui-layer-min cite,.layui-layer-setwin{
    display:none;
}
.position{
    display:block;
}
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <div style="text-align: right;margin-bottom: 10px">
             <!-- <?= \yii\bootstrap\Html::a('返回',['customer/list'],['class'=>'btn btn-primary'])?> -->
            <a class="btn btn-primary" href="/index.php?r=customer/list<?=$url?>">返回</a>
             </div>
            <div class="ibox-content">
                <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data','class'=>'form-horizontal']]); ?>
                <?= $form->field($model["model"], 'Name')->textInput(['maxlength' => 64]) ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model["model"], 'Tel')->textInput(['maxlength' => 11]) ?>
                <div class="hr-line-dashed"></div>
       <!-- <div class="hr-line-dashed"></div> -->
                <!-- <div class="hr-line-dashed"></div> -->
                <?= $form->field($model["data2"], 'CustomerType')->dropDownList(['1' => '家庭','2' => '公司','3' => '集团','99' => '其他'])->label('客户类型') ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model["data2"], 'UseType')->dropDownList(\yii\helpers\ArrayHelper::map($use_type,'code', 'use_type'))->label('入网属性') ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model["data2"], 'AgentId')->dropDownList(\yii\helpers\ArrayHelper::map($agent,'Id', 'Name'))->label('所属服务中心') ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model["data2"], 'DevNo')->textInput(['maxlength' => 64,'readonly'=>'true'])->label('设备编号') ?>
                <div class="hr-line-dashed"></div>
                <!--地址-->
                <div class="form-group field-adminroleuser-role_id required">
                    <label class="col-sm-2 control-label" for="adminroleuser-role_id">地址</label>
                    <div class="col-sm-10">
                        <select class="control-label" name="DevRegist[Province]" id="province">
                            <option value="">请选择省</option>
                        </select>
                        <select class="control-label" name="DevRegist[City]" id="city">
                            <option value="">请选择市</option>
                        </select>
                        <select class="control-label" name="DevRegist[Area]" id="area">
                            <option value="">请选择区</option>
                        </select>
                    </div>
                </div>
                 <?= $form->field($model["data2"], 'Address')->textInput(['maxlength' => 64,'value'=>$model["data2"]['Address'].$model["data2"]['RoomNo']])->label('详细地址')  ?>


            
                 <input type="text" name="DevRegist[RoomNo]" value="" style="display: none">
<!-- 
               <?= $form->field($model["data2"], 'RoomNo')->textInput(['maxlength' => 64])->label('门牌号') ?> -->


                <div class="hr-line-dashed"></div>
                <?= $form->field($model["data2"], 'Lat')->textInput(['maxlength' => 11])->label('纬度') ?>
                <?= $form->field($model["data2"], 'Lng')->textInput(['maxlength' => 11])->label('经度') ?>
                 <div class="position">
                    <label class="col-sm-2 control-label" for="devregist-lng"></label>
                <div class="col-sm-10"><input type="button" class="btn select_btn" style="    background: #E46045;height: 26px;margin-bottom: 5px;line-height: 15px;margin-left: 0px" value="+标记位置" onclick="openMark()"></div>
                </div>
                <div style="clear:both"></div>
             <div class="hr-line-dashed"></div>
                <!--设备型号-->
                <div class="form-group field-adminroleuser-role_id required">
                    <label class="col-sm-2 control-label" for="adminroleuser-role_id">设备型号</label>
                    <div class="col-sm-10">
                        <select class="control-label" name="DevRegist[brand_id]" id="brand_id">
                            <option value="">请选择</option>
                        </select>
                        <select class="control-label" name="DevRegist[goods_id]" id="goods_id">
                            <option value="">请选择</option>
                        </select>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>

               
                <!-- <div class="hr-line-dashed"></div> -->

       

                <?= $form->field($model["model"], 'Remark')->textarea(['maxlength' => 20,'placeholder'=>"最多20个字"])->label('备注') ?>
                <div class="hr-line-dashed"></div>

   <!-- <?= $form->field($model["data2"], 'tog')->radioList(['0'=>'否','1'=>'是'])->label('是否修改历史数据') ?>  -->
                <!-- <div class="hr-line-dashed"></div> -->
                <?= $form->defaultButtons() ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<script>
var data=<?=$model["data"]?>;
var province='<?=$model["data2"]["Province"]?>';
var city='<?=$model["data2"]["City"]?>';
var area='<?=$model["data2"]["Area"]?>';
var dev_brand=<?=$model["dev_brand"]?>;

var dev_goods=<?=$model["dev_goods"]?>;

var brand_id='<?=$model["brand_id"]?>';

var goods_id='<?=$model["goods_id"]?>';


var CustomerType='<?=$model["data2"]['CustomerType']?>';
// console.log(dev_goods)
// console.log(goods_id)
  console.log(dev_brand);
  console.log(brand_id);
</script>
<script type="text/javascript" src="./static/js/jquery.min.js"></script>
<script type="text/javascript" src="./static/js/layer/layer.js"></script>
    <script type="text/javascript" src="/static/js/chosen.jquery.min.js"></script>
    <script type="text/javascript" src="/static/js/Common2.js?v=4"></script>
<script>
// 地址渲染 
if(CustomerType==4){
       $(".position").css('display','none')
       $("#devregist-customertype").empty().append('<option value="4">酒店</option>');
 //   $("#devregist-usetype").empty().append('<option value="1" selected="">0元押金</option>');
    $("#customer-tel,#devregist-lat,#devregist-lng,#devregist-agentid,#devregist-usetype,#devregist-customertype,#devregist-devno").attr("disabled",'true');
};
addressResolve(data,province,city,area);

// function openMark(){
//     var title="地图标记";
//    // var nameUrl = $("#province").val()+$("#city").val()+$("#area").val();
// console.log()


//     // $.get("/index.php?r=goods/mark&name="+encodeURIComponent(nameUrl),"",function(msg){
//     //     // (new $.zui.ModalTrigger({custom: msg,title:title})).show();
//     //     var ppp = layer.open({
//     //       type: 1,
//     //       title: false,
//     //       area: ['730px', '550px'],
//     //       closeBtn: 0,
//     //       shadeClose: true,
//     //       skin: 'yourclass',
//     //        content:msg,
//     //        btn: ['确认', '取消'],
//     //        yes:function(){
//     //             ok();
//     //            layer.close(ppp);
//     //        },
//     //        no:function(){
//     //        layer.close();
//     //        }

//     //     });
//     // })
// }


// addressOperateService({
// 	 agenty:
// })


// $("#customer-tel,#devregist-lat,#devregist-lng,#devregist-agentid").attr("disabled",'true');
$("#devregist-customertype").chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
$("#devregist-agentid").chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
// $("#devregist-usetype").chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen


var addres_dev_brandB= function (obj) {
        var addressInfo = this;
        this.devbrandInfo = $("#" + obj.devbrand);//服务中心 select对象
        this.devnameInfo = $("#" + obj.devname);//运营中心select对象
console.log(obj)
        this.devbrand=function(){
          addressInfo.devnameInfo.empty();
           addressInfo.devnameInfo.append("<option value=>请选择设备型号</option>");
           var Opts = "";
            $.each(obj.devbrand_data, function (index, item) {
                if (item) {
                	  if(obj.where.devbrand==item.BrandNo){
 						Opts += "<option selected='selected' value='" + item.BrandNo + "' >" + item.BrandName + "</option>";
                	  }else{
                	  	Opts += "<option value='" + item.BrandNo + "'>" + item.BrandName + "</option>";
                	  }
                    // console.log(item)
                   
                }
            });
            addressInfo.devbrandInfo.append(Opts)
            addressInfo.devbrandInfo.chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
            addressInfo.devnameInfo.chosen({no_results_text: "没有找到",disable_search_threshold: 10}); //初始化chosen
        }
        this.devname=function(){
             addressInfo.devnameInfo.empty();
             addressInfo.devnameInfo.append("<option value=>请选择设备型号</option>");  
              var _thisVal = addressInfo.devbrandInfo.val();
                  var ii =  layer.open({
                    type: 1,
                    skin: 'layui-layer-demo', //样式类名
                    closeBtn: 0, //不显示关闭按钮
                    area: ['100px', '30px'],
                    anim: 2,
                    shade: [0.8, '#000'],
                    content: '<div style="background-color: #25282d;opacity: 0.8;text-align: center;color: #fff;height:30px;line-height30px;">加载中.....</div>'
                  });
                
                $.get('./?r=customer/get-goods',{'brand_id':_thisVal},function(data){
			            console.log(data);
			             var Opts = "";
			                if(data){
					             $.each(data, function (index, item) {
			                        if (item) {
			                           if(obj.where.devname==item.id){
			                            	// console.log(item)
			                                Opts += "<option  selected='selected'  value='" + item.id + "'>" + item.name + "</option>";
			                            }else{
			                            	   Opts += "<option value='" + item.id + "'>" + item.name + "</option>";
			                            }
			                          
			                        }
			                    });

			                }
			       addressInfo.devnameInfo.append(Opts);
                   addressInfo.devnameInfo.trigger("chosen:updated");
                   layer.close(ii)
			         })
        }

        this.init = function () {
 		    addressInfo.devbrand();
 		    addressInfo.devname();
 		    addressInfo.devbrandInfo.bind("change", addressInfo.devname);
        }

        this.init()
}

// 设备品牌型号
addres_dev_brandB({
     devbrand:'brand_id',
     devbrand_data:dev_brand,
     devname:'goods_id',
     devname_data:dev_goods,
     where:{
        devbrand:brand_id,
        devname:goods_id
     }
})

    // //设备型号
    // function initbrand(){
    //     var html='';
    //     for(var i=0;i<dev_brand.length;i++){
    //         var item=dev_brand[i];
    //         if(item.BrandNo==brand_id){
    //             html+="<option selected='selected' value='"+item.BrandNo+"'>"+item.BrandName+"</option>";
    //         }else{
    //             html+="<option value='"+item.BrandNo+"'>"+item.BrandName+"</option>";
    //         }
    //     }
    //     $("#brand_id").append(html);
    // }
    // function initgoods(){
    //     var html='';
    //     for(var i=0;i<dev_goods.length;i++){
    //         var item=dev_goods[i];
    //         if(item.id==goods_id){
    //             html+="<option selected='selected' value='"+item.id+"'>"+item.name+"</option>";
    //         }else{
    //             html+="<option value='"+item.id+"'>"+item.name+"</option>";
    //         }
    //     }
    //     $("#goods_id").append(html);
    // }

//     $('#brand_id').change(function(){
//         var brand_id=$("#brand_id option:selected").val();
//            if(brand_id){
//             //获取该品牌下的所有商品
//             $.get('./?r=customer/get-goods',{'brand_id':brand_id},function(data){
// //                console.log(data);
//                 if(data){
//                     var html="<option value=''>请选择</option>";
//                     $(data).each(function(i,v){
//                         html+="<option value='"+v.id+"'>"+v.name+"</option>"
//                     });

//                     $("#goods_id").html(html);

//                 }
//             })
//         }else{

//             $("#goods_id").html("<option value=''>请选择</option>");
//         }

//     });

    $(function(){

       // initbrand();
       // initgoods();

       // initProvince();
       // initListener();
      //  initAddress();
//        initMap();
    });


 
    function openMark(){
        //iframe窗
        layer.open({
          type: 2,
          title: false,
          closeBtn: 0, //不显示关闭按钮
          shade: [0],
         area: ['730px', '350px'],
          // offset: 'rb', //右下角弹出
          // time: 2000, //2秒后自动关闭
           maxmin: true, //开启最大化最小化按钮
          anim: 2,
          content: [ '/index.php?r=goods/mark2', 'no'], //iframe的url，no代表不显示滚动条
          btn: ['确认', '取消'],

          yes:function(){
          },
          end: function(){ //此处用于演示

          },


        });

    }



function mark(point){
    $("#lat").val(point.lat);
    $("#lng").val(point.lng);
}



    function hideMark(){
        $("#mapContainer").hide();
    }
    function  sureLocation(){
        if(cur==null){
            alert("请先标注点！");
            return;
        }
        $("#lat").val(cur.lat);
        $("#lng").val(cur.lng);
        hideMark();
    }
    function initMap(){
        $("#address").val(address);
        $("#lat").val(baiDuLat);
        $("#lng").val(baiDuLng);


        map = new BMap.Map("map");
        geoc = new BMap.Geocoder();
        map.enableScrollWheelZoom(); //可滑动
        map.addControl(new BMap.NavigationControl()); //导航条
        var point = new BMap.Point(104.067923, 30.679943); //成都市(116.404, 39.915);
        map.centerAndZoom(point, 13);
        $("#map").css({"height":"100%"});
    }
    function initAddress(){
        $("#province").val(province);
        initCityOnProvinceChange();
        $("#city").val(city);
        initThree();
        $("#area").val(area);
    }
    function getAddressIdByName(_name){
        _name= $.trim(_name);
        if(_name==""){
            return 0;
        }
        for(var index=0;index<data.length;index++){
            var item=data[index];
            var name= $.trim(item.Name);
            if(name!=""&&name==_name){
                return item.Id;
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
        $("#city").append("<option value=''>请选择</option>");
        if(pid==0){
            return;
        }
        for(var index=0;index<data.length;index++){
            var item=data[index];
            if(item.PId!=0&&item.PId==pid){
                $("#city").append("<option value='"+item.Name+"'>"+item.Name+"</option>");
                initThree()
            }
        }
    }
    function initThree(){
        var pid=getAddressIdByName($("#city").val());
        $("#area").empty();
        $("#area").append("<option value=''>请选择</option>");
        if(pid==0){
            return;
        }
        for(var index=0;index<data.length;index++){
            var item=data[index];
            if(item.PId!=0&&item.PId==pid){
                $("#area").append("<option value='"+item.Name+"'>"+item.Name+"</option>");
            }
        }
    }
    function initProvince(){
        for(var index=0;index<data.length;index++){
            var item=data[index];
            if(item.PId==0){
                $("#province").append("<option value='"+item.Name+"'>"+item.Name+"</option>");
            }
        }
    }


</script>
